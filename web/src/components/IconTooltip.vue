<template>
  <div
    v-b-tooltip.hover
    :title="text"
    class="icon-tooltip"
  >
    <b-icon
      icon="question-circle"
    />
  </div>
</template>

<script>

export default {

  props: {
    text: { type: String, required: true },
  },
};
</script>
