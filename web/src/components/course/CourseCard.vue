<template>
  <div>
    <b-card
      :title="course.name"
      class="mb-2"
    >
      <b-card-text>
        {{ course.description }}
      </b-card-text>
    </b-card>
  </div>
</template>
<script>
export default {
  props: {
    course: { type: Object, required: true },
  },
};
</script>
