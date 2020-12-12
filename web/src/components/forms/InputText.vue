<template>
  <div class="input-group">
    <input
      :class="{
        'is-valid': validations && !validations.$pending && validations.$success,
        'is-invalid': validations && validations.$errorMessage,
      }"
      :placeholder="placeholder"
      :readonly="readonly"
      :type="type"
      :value="value"
      v-bind="$attrs"
      class="form-control"
      @blur="onBlur($event.target.value)"
      @input="notifyDebounced"
    >
  </div>
</template>

<script>
import { debounce } from 'lodash';
import prependHttp from 'prepend-http';

export default {
  props: {
    debounce: { type: Number, default: 0 },
    placeholder: { type: String, default: '' },
    readonly: { type: Boolean, default: false },
    type: { type: String, default: 'text' },
    validations: { type: Object, default: null },
    value: { type: [Number, String], default: null },
  },

  data() {
    return {
      notifyDebounced: debounce(
        e => this.$emit('input', e.target.value),
        this.debounce,
      ),
    };
  },
  methods: {
    onBlur(value) {
      if (value && this.type === 'url') {
        this.$emit('input', prependHttp(value));
        return;
      }

      this.$emit('input', value);
    },
  },
};
</script>
