<template>
  <div>
    <page-header
      :heading="course.name"
    >
      <template v-slot:controls>
        <b-button
          variant="warning"
        >
          <b-icon
            icon="check"
            class="mr-1"
          />
          Přidat k mým
        </b-button>
      </template>
    </page-header>
    <b-container
      class="mt--3"
    >
      <course-summary
        :course="course"
      />
    </b-container>
  </div>
</template>
<script>
import courses from '../_data/courses.json';
import CourseSummary from '../components/course/CourseSummary.vue';
import CourseDiscussion from '../components/course/CourseDiscussion.vue';
import PageHeader from '../components/PageHeader.vue';

export default {
  components: { PageHeader, CourseDiscussion, CourseSummary },
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
    },
  },
};
</script>
