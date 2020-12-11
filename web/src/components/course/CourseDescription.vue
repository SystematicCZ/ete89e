<template>
  <div>
    <h3
      class="mb-4"
    >Informace o předmětu</h3>
    <p> {{ text }}</p>
  </div>
</template>
<script>
export default {
  props: {
    text: { type: String, required: true },
  },
};
</script>
