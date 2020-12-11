<template>
  <b-container>
    <b-row>
      <b-col
        v-for="(item, key) in courses"
        :key="`course_${key}`"
        cols="12"
        md="4"
        class="mb-3"
      >
        <course-card
          :course="item"
        />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import courses from '../_data/courses.json';
import CourseCard from '../components/course/CourseCard.vue';

export default {
  components: { CourseCard },
  data() {
    return {
      courses: null,
    };
  },
  created() {
    this.courses = courses;
    this.$route.meta.heading = 'Courses';
  },
  methods: {
  },
};
</script>
