<template>
  <div>
    <div
      class="form-check pl-0"
    >
      <div class="custom-control custom-checkbox">
        <input
          :id="id"
          :value="value"
          class="custom-control-input"
          type="checkbox"
          @change="updateValue"
        >
        <label
          :id="`label-for-${id}`"
          :for="id"
          class="custom-control-label"
        >
          <slot>
            <span v-html="label"/>
          </slot>

          <span
            v-if="validations && (validations.$params.required || validations.$required)"
            class="required-mark ml-1"/>
        </label>
      </div>
    </div>
    <div
      v-if="validations && validations.$errorMessage"
      class="invalid-feedback"
      v-html="validations && validations.$errorMessage"
    />
  </div>

</template>

<script>

export default {

  props: {
    id: { type: String, required: true },
    label: { type: String, required: true },
    value: { type: Boolean, default: false },
    validations: { type: Object, default: null },
  },

  methods: {
    updateValue() {
      this.$emit('input', !this.value);
    },
  },
};
</script>
