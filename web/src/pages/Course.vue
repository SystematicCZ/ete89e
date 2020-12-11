<template>
  <b-container>
    <course-summary
      :course="course"
    />
  </b-container>
</template>
<script>
import courses from '../_data/courses.json';
import CourseSummary from '../components/course/CourseSummary.vue';
import CourseDiscussion from '../components/course/CourseDiscussion.vue';

export default {
  components: { CourseDiscussion, CourseSummary },
  data() {
    return {
      course: null,
    };
  },
  watch: {
    $route: 'load',
  },
  created() {
    this.load();
  },
  methods: {
    load() {
      [this.course] = courses.filter(item => item.id == this.$route.params.id);
      this.$route.meta.heading = this.course.name;
    },
  },
};
</script>
