<template>
  <button
    v-b-tooltip.hover
    :title="text"
    class="form-tooltip-toggle ml-1"
    type="button"
  />
</template>

<script>

export default {

  props: {
    text: { type: String, required: true },
  },
};
</script>
