<template>
  <div>
    <page-header
      :heading="course ? course.name : ''"
    >
      <template
        v-slot:controls
        v-if="!loading"
      >
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
        v-if="course && !loading"
        :course="course"
        @course-changed="course = $event"
        @events-changed="course.events = $event"
      />
      <div
        v-else
        class="rounded shadow p-3 bg-white mb-3"
      >
        <skeleton-list/>
      </div>
    </b-container>
  </div>
</template>
<script>
import axios from 'axios';
import CourseSummary from '../components/course/CourseSummary.vue';
import CourseDiscussion from '../components/course/CourseDiscussion.vue';
import PageHeader from '../components/PageHeader.vue';
import SkeletonList from '../components/skeleton/SkeletonList.vue';

export default {
  components: { SkeletonList, PageHeader, CourseDiscussion, CourseSummary },
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
      loading: true,
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
      this.loading = true;
      this.course = null;
      axios.get(`${this.$root.$options.vars.API_URL}courses/${this.$route.params.id}`, { withCredentials: true }).then((response) => {
        this.course = response.data;
        this.loading = false;
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
