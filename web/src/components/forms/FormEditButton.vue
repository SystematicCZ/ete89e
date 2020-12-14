<template>
  <div>
    <b-button
      v-if="!isEditing"
      variant="outline-warning"
      class="edit-button"
      @click="$emit('edit')"
    >
      <b-icon
        v-b-tooltip
        title="Upravit"
        icon="pencil"
      />
    </b-button>
    <b-button
      v-else
      variant="outline-warning"
      class="edit-button"
      @click="$emit('cancel')"
    >
      <b-icon
        v-b-tooltip
        title="Zrušit"
        icon="x"
      />
    </b-button>
  </div>
</template>
<script>
export default {
  props: {
    isEditing: { type: Boolean, required: true },
  },
};
</script>
<style scoped lang="scss">
.edit-button {
  position: absolute;
  right: 0;
  top: 0;
}
</style>

