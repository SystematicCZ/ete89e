<template>
  <b-container>
    <b-row>
      <b-col
        v-for="(item, key) in courses"
        :key="`course_${key}`"
        cols="12"
        md="4"
      >
        <course-card
          :course="item"
        />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import CourseCard from '../components/course/CourseCard.vue';

export default {
  components: { CourseCard },
  data() {
    return {
      courses: null,
    };
  },
  created() {
    this.courses = this.generateData();
  },
  methods: {
    generateData() {
      const courses = [];
      for (let i = 0; i < 10; i += 1) {
        courses.push({
          name: 'fef',
          description: 'feergergreg',
        });
      }

      return courses;
    },
  },
  beforeRouteEnter(to, from, next) {
    to.meta.heading = 'Courses';
    next();
  },
};
</script>
