<template>
  <div class="input-group">
    <input
      :class="{
        'is-valid': validations && validations.$success,
        'is-invalid': validations && validations.$errorMessage,
      }"
      :readonly="readonly"
      :type="type"
      :value="value"
      class="form-control"
      @blur="onBlur($event.target.value)"
      @input="$emit('input', $event.target.value)"
    >
  </div>
</template>

<script>
import prependHttp from 'prepend-http';

export default {
  props: {
    readonly: { type: Boolean, default: false },
    type: { type: String, default: 'text' },
    validations: { type: Object, default: null },
    value: { type: String, required: true },
  },

  methods: {
    onBlur(value) {
      if (value && this.type === 'url') {
        this.$emit('input', prependHttp(value));
      }
    },
  },
};
</script>
