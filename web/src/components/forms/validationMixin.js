import { flatten } from 'flat';
import { cloneDeep, fromPairs, get, isObjectLike, toPairs } from 'lodash';

export default {
  computed: {
    // A convenient $v wrapper (vuelidate library) which expands it with custom properties.
    validations() {
      return this.expandVuelidateObjectRecursively(this.$v.payload);
    },
  },

  methods: {
    expandVuelidateObjectRecursively(vuelidateNode) {
      return fromPairs(toPairs(vuelidateNode).map(([key, value]) => {
        if (
          // the property does not have a child node...
          !isObjectLike(value)

          // ... or it is not the child node we're interested in
          || ['$iter', '$params', '$model'].some(ignoredKey => ignoredKey === key)
        ) {
          return [key, value]; // pass the node unchanged
        }

        // for each "proper" child node...
        return [
          key,
          {
            ...this.expandVuelidateObjectRecursively(value), // continue "deeper" recursively...
            ...this.expandVuelidateNode(value), // ...but first, expand the current node
          },
        ];
      }));
    },

    expandVuelidateNode(vuelidateNode) {
      return {
        $required: vuelidateNode.hasOwnProperty('required'),
        $errorMessage: this.buildErrorMessage(vuelidateNode),
        $success: !vuelidateNode.$error && !vuelidateNode.pending && vuelidateNode.$dirty,
      };
    },

    buildErrorMessage(vuelidateNode) {
      if (!vuelidateNode.$error) {
        return null;
      }

      const errorMessages = toPairs(vuelidateNode)
        .filter(this.getFailingRules)
        .map(([rule]) => window.validationErrorTranslations[rule]);

      if (errorMessages.length === 0) {
        return null;
      }

      return errorMessages[0]; // Always render the first error associated with the field.
    },

    getFailingRules([key, value]) {
      return key.charAt(0) !== '$' && value === false;
    },

    // Whenever user types something into the form, we determine which field has changed
    // and call $v[field].$touch so that vuelidate knows the field has already been interacted with.

    // Note: we are flattening the objects since we only care about the leaves anyways.
    // It is easier to compare two objects in a non-recursive manner (see `flat` library).
    trackUserInteraction() {
      this.$watch(
        () => cloneDeep(this.payload),

        (newValue, oldValue) => {
          Object.entries(flatten(newValue))
            .reduce(
              this.detectChangedFieldsAgainst(flatten(oldValue)),
              [], // multiple fields can change at the same time (the field can be debounced)
            )
            .forEach((changedField) => {
              const vuelidateNode = this.getUnderlyingVuelidateNode(changedField);

              if (vuelidateNode) {
                vuelidateNode.$touch();
              }
            });
        },

        { deep: true },
      );
    },

    detectChangedFieldsAgainst(oldValueFlattened) {
      return (changedFields, [field, value]) => {
        if (oldValueFlattened[field] !== value) {
          return changedFields.concat(field);
        }

        return changedFields;
      };
    },

    // Vuelidate library wraps arrays found in `data` under an `$each` property, we have to adjust.
    normalizePropertyPath(fragments, fragment) {
      if (Number.isNaN(parseInt(fragment, 10))) {
        return fragments.concat([fragment]);
      }

      return fragments.concat(['$each', fragment]);
    },

    getUnderlyingVuelidateNode(changedFieldFlattenedAccessor) {
      return get(
        this.$v.payload,

        changedFieldFlattenedAccessor.split('.').reduce(
          this.normalizePropertyPath,
          [],
        ),

        null,
      );
    },

    scrollToFirstInvalidElement(DOMwrapper = this.$el) {
      this.$v.$touch();
      this.$nextTick(() => {
        const firstFailingElementsPosition = this.getInvalidElements(DOMwrapper)
          .reduce(this.findFirstInvalidElementsPosition, null);

        if (firstFailingElementsPosition) {
          window.scroll({
            top: firstFailingElementsPosition - (window.innerHeight / 2),
            behavior: 'smooth',
          });
        }
      });
    },

    getInvalidElements(DOMwrapper) {
      return Array.from(DOMwrapper.querySelectorAll('.is-invalid, .invalid-message, .invalid-feedback'));
    },

    findFirstInvalidElementsPosition(topmostFoundPosition, currentElement) {
      const positionOfCurrent = this.getElementPosition(currentElement);

      if (topmostFoundPosition === null || positionOfCurrent < topmostFoundPosition) {
        return positionOfCurrent;
      }

      return topmostFoundPosition;
    },

    getElementPosition(element) {
      return element.getBoundingClientRect().y + (window.scrollY);
    },

    isReadyToSubmit() {
      return !this.$v || (!this.$v.$invalid && !this.$v.$pending);
    },

    isPending() {
      return this.$v && this.$v.$pending;
    },
  },
};
