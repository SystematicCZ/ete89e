<template>
  <div>
    <div class="fz--sm justify-content-between d-flex text-secondary pl-2 pr-2">
      <div
        :class="['form-group form-group--custom', {
          'is-required': required,
          'is-valid': validations && validations.$success,
          'is-invalid': validations && validations.$errorMessage}]"
      >
        <legend
          class="cursor-pointer"
          @click="isExpanded = !isExpanded"><template v-if="collapsable">({{ options.length }})</template> <img
            v-if="collapsable && expandImageSrc"
            :src="expandImageSrc"
            class="ml-1"
            width="8"
            height="8"></legend>
      </div>
      <div class="checkbox-group-counter-placeholder">{{ translations.selected }}: {{ checked.length }}</div>
    </div>

    <div
      ref="checkbox-list"
      :class="{'d-none': collapsable && !isExpanded}"
      class="checkbox-group-list"
    >
      <ul class="checkbox-group-list-inner">
        <li v-if="checkAll">
          <div class="form-check">
            <div class="custom-control custom-checkbox">
              <input
                v-bind="getAttributes({id:translations.checkAll, value: translations.checkAll })"
                v-model="isCheckedAll"
                name=""
                @change="toggleCheckAll()"
              >
              <label
                :for="translations.checkAll"
                class="custom-control-label"
              >
                <slot v-if="labelAll != null">
                  {{ labelAll }}
                </slot>
                <slot v-else>
                  {{ translations.checkAll }}
                </slot>
              </label>
            </div>
          </div>
        </li>
        <template v-for="option in options">
          <li>
            <div class="form-check">
              <div class="custom-control custom-checkbox">
                <input
                  v-bind="getAttributes(option)"
                  :disabled="option.disabled"
                  @change="updateValues(option)"
                >
                <label
                  :for="option.value"
                  class="custom-control-label"
                >
                  <slot>
                    {{ option.text }}
                  </slot>
                </label>
              </div>
            </div>
          </li>
        </template>
      </ul>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    labelAll: { type: String, default: null },
    value: { type: Array, default: () => [] },
    validations: { type: Object, required: false, default: null },
    translations: { type: Object, required: true },
    options: { type: Array, required: true },
    checkAll: { type: Boolean, default: false },
    customHeight: { type: Number, required: false, default: 0 },
    collapsable: { type: Boolean, default: false },
    expandImageSrc: { type: String, default: null },
  },
  data() {
    return {
      checked: this.value,
      isCheckedAll: false,
      isExpanded: false,
    };
  },
  computed: {
    required() {
      return Boolean(this.validations && this.validations.$params.required);
    },
  },
  mounted() {
    if (this.customHeight) {
      this.$refs['checkbox-list'].setAttribute('style', `height:${this.customHeight}rem`);
    }
  },
  methods: {
    getAttributes(option) {
      return {
        class: ['custom-control-input'],
        type: 'checkbox',
        id: `${option.value}`,
        value: option.value,
        checked: (this.checked.indexOf(option.value) > -1),
      };
    },
    updateValues(option) {
      const index = this.checked.indexOf(option.value);

      if (index > -1) {
        this.checked.splice(index, 1);
        this.isCheckedAll = false;
      } else {
        this.checked.push(option.value);
      }

      if (this.validations) {
        this.validations.$touch();
      }

      this.$emit('input', this.checked);
    },
    toggleCheckAll() {
      this.checked = [];

      if (this.isCheckedAll) {
        for (const option in this.options) {
          this.checked.push(this.options[option].value);
        }
      }

      this.$emit('input', this.checked);
    },
  },
};
</script>
