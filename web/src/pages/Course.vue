<template>
  <div>
    <page-header
      :heading="course ? course.name : ''"
    >
      <template v-slot:controls>
        <b-button
          v-if="!subscribed"
          variant="warning"
          @click="toggleCourse"
        >
          <b-icon
            icon="check"
            class="mr-1"
          />
          Přidat k mým
        </b-button>
        <b-button
          v-else
          variant="danger"
          @click="toggleCourse"
        >
          <b-icon
            icon="x"
            class="mr-1"
          />
          Odebrat z mých
        </b-button>
      </template>
    </page-header>
    <b-container
      class="mt--3 px-0"
    >
      <course-summary
        v-if="course"
        :course="course"
        @course-changed="course = $event"
        @events-changed="course.events = $event"
      />
    </b-container>
  </div>
</template>
<script>
import axios from 'axios';
import CourseSummary from '../components/course/CourseSummary.vue';
import CourseDiscussion from '../components/course/CourseDiscussion.vue';
import PageHeader from '../components/PageHeader.vue';

export default {
  components: { PageHeader, CourseDiscussion, CourseSummary },
  metaInfo() {
    const title = (this.course) ? this.course.name : 'O kurzu';
    return {
      title,
      meta: [
        {
          vmid: 'description',
          name: 'description',
          content: 'Už jsi zase zapomněl, že máš odevzdat semestrálku? Nevíš co tě čeká na zkoušce?',
        },
      ],
    };
  },
  data() {
    return {
      course: null,
    };
  },
  computed: {
    subscribed() {
      return this.$store.state.user.courses.filter(item => item.id == this.$route.params.id).length > 0;
    },
  },
  watch: {
    $route: 'load',
  },
  created() {
    this.load();
  },
  methods: {
    load() {
      axios.get(`${this.$root.$options.vars.API_URL}courses/${this.$route.params.id}`, { withCredentials: true }).then((response) => {
        this.course = response.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    toggleCourse() {
      axios.post(`${this.$root.$options.vars.API_URL}courses/${this.$route.params.id}/toggle_subscription`, {}, { withCredentials: true }).then((response) => {
        this.$store.dispatch('updateUser', response.data);
      }).catch((error) => {
        console.log(error);
      });
    },
  },
};
</script>
