<template>
  <multiselect
    v-model="data"
    :class="{
        'is-valid': validations && !validations.$pending && validations.$success,
        'is-invalid': validations && validations.$errorMessage,
      }"
    :options="options"
    :searchable="true"
    :track-by="trackBy"
    :label="optionLabel"
  />
</template>
<script>
import Multiselect from 'vue-multiselect';

require('vue-multiselect/dist/vue-multiselect.min.css');

export default {
  components: { Multiselect },
  props: {
    value: { type: Number, default: null },
    validations: { type: Object, default: null },
    options: { type: Array, required: true },
    trackBy: { type: String, default: 'id' },
    optionLabel: { type: String, default: 'name' },
  },
  data() {
    return {
      data: null,
    };
  },
  watch: {
    data(newValue) {
      this.$emit('input', newValue[this.trackBy]);
    },
    options(newValue) {
      this.data = newValue.find(element => element[this.trackBy] === this.value) || null;
    },
  },
};
</script>
