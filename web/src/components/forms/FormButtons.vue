<template>
  <div>
    <b-button
      :disabled="submitDisabled"
      variant="primary"
      type="submit"
      @click="$emit('save')"
    >
      <b-icon icon="check"/>
      Uložit
    </b-button>
    <b-button
      v-if="cancelButton"
      variant="warning"
      @click="$emit('cancel')"
    >
      <b-icon icon="x"/>
      Zrušit
    </b-button>
  </div>
</template>
<script>
export default {
  props: {
    cancelButton: { type: Boolean, default: false },
    submitDisabled: { type: Boolean, default: false },
  },
};
</script>
