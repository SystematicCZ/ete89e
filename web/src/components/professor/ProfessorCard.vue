<template>
  <b-card
    class="border-0 shadow"
  >
    <b-card-text
      class="text-center"
    >
      <h5>{{ professor.title }} {{ professor.name }}</h5>
      <p class="text-secondary">Předměty</p>
      <div class="text-left">
        <b-link
          v-for="(course, index) in professor.courses"
          :key="`course_link_${index}`"
          :to="{name: 'course', params: {id: course.id, slug: course.slug}}"
        >
          {{ course.name }} <br>
        </b-link>
      </div>
    </b-card-text>
  </b-card>
</template>
<script>

export default {
  props: {
    professor: { type: Object, required: true },
  },
};
</script>
