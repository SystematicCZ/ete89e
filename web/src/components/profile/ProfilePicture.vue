<template>
  <img
    :src="pictureUrl"
    alt="User profile picture"
    width="170"
    class="rounded-circle"
  >
</template>
<script>
export default {
  props: {
    pictureUrl: { type: String, required: true },
  },
};
</script>
