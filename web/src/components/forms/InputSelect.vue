<template>
  <select
    ref="select"
    :value="value"
    v-bind="attributes"
    @blur="blur"
    @keyup.esc="blur"
    @change="$emit('input', $event.target.value)"
  >
    <option
      v-if="placeholder && !attributes.hasOwnProperty('readonly')"
      :value="null"
    >
      {{ placeholder }}
    </option>

    <template
      v-for="(option, index) in options"
    >
      <optgroup
        v-if="Array.isArray(option.value)"
        :key="index"
        :label="option.text"
      >
        <option
          v-for="suboption in option.value"
          v-bind="$attrs"
          :key="suboption.value"
          :value="suboption.value"
          :disabled="attributes.hasOwnProperty('readonly') && suboption.value !== selected"
        >
          {{ capitalize ? $options.filters.capitalize(suboption.text) : suboption.text }}
        </option>
      </optgroup>
      <option
        v-else
        v-bind="$attrs"
        :key="option.value"
        :value="option.value"
        :disabled="attributes.hasOwnProperty('readonly') && option.value !== selected"
      >
        {{ capitalize ? $options.filters.capitalize(option.text) : option.text }}
      </option>
    </template>


  </select>
</template>

<script>
export default {

  props: {
    label: { type: String, default: '' },
    labelExtra: { type: String, default: '' },
    instructions: { type: String, default: '' },
    instructionsExtra: { type: String, default: '' },
    more: { type: String, default: '' },
    labelMore: { type: String, default: '' },
    tooltipMore: { type: String, default: '' },
    id: { type: String, default: null },
    name: { type: String, default: null },
    value: { type: [String, Number], default: null },
    serverError: { type: String, default: '' },
    validation: { type: Object, required: false, default: null },
    options: { type: Array, required: true },
    placeholder: { type: String, default: '' },
    capitalize: { type: Boolean, default: true },
    simple: { type: Boolean, default: false },
    rightAlignControls: { type: Boolean, default: false },
  },

  data() {
    return {
      clicked: false,
      selected: this.value,
      isShowingError: false,
    };
  },

  computed: {
    required() {
      return Boolean(this.validation && this.validation.$params.required);
    },

    validationColor() {
      return {
        'is-invalid': this.isShowingError,
        'is-valid': !this.isShowingError && this.validation && this.validation.$dirty,
      };
    },

    attributes() {
      return {
        id: this.id,
        name: this.name,
        class: ['custom-select', this.validationColor],
        ...this.$attrs,
      };
    },
  },

  methods: {
    blur() {
      this.$refs.select.blur();

      this.$emit('blur');

      if (this.validation) {
        this.validation.$touch();
      }
    },
  },
};
</script>
