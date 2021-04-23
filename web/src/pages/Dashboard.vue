<template>
  <div>
    <page-header
      heading="Bojiště"
      lead="Tady je vidět, kde všude se bojuje"
    >
      <template v-slot:controls>
        <search-bar
          v-model="term"
          button="Hledat"
        />
        <router-link
          :to="{name: 'addCourse'}"
          class="btn btn-warning mt-2"
        >
          Přidat kurz
        </router-link>
      </template>
    </page-header>
    <b-container class="mt--3 px-0">
      <b-row v-if="!isLoading && courses.length">
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
      <b-container
        v-else-if="!isLoading && courses.length === 0"
        class="inner-container bg-white rounded p-3">
        <h2>Dobojováno</h2>
        <p>Nic tu není</p>
      </b-container>
      <skeleton-list-cards
        v-else-if="isLoading"
      />
    </b-container>
  </div>
</template>

<script>
import axios from 'axios';
import searchableMixin from '../components/searchableMixin';
import PageHeader from '../components/PageHeader.vue';
import SearchBar from '../components/SearchBar.vue';
import CourseCard from '../components/course/CourseCard.vue';
import SkeletonListCards from '../components/skeleton/SkeletonListCards.vue';

export default {
  components: { SkeletonListCards, CourseCard, PageHeader, SearchBar },
  mixins: [searchableMixin],
  metaInfo: {
    title: 'Kurzy',
    meta: [
      {
        vmid: 'description',
        name: 'description',
        content: 'My víme všechno o každým předmětu, se ktrým bojuješ.',
      },
    ],
  },
  data() {
    return {
      courses: null,
      isLoading: true,
    };
  },
  created() {
    if (this.term.length) {
      this.search(this.term);
    } else {
      this.load();
    }
  },
  methods: {
    search(term) {
      this.isLoading = true;
      axios.get(
        `${this.$root.$options.vars.API_URL}courses`,
        { withCredentials: true, params: { search: term } },
      ).then((response) => {
        this.courses = response.data;
        this.isLoading = false;
      }).catch((error) => {
        console.log(error);
      });
    },
    load() {
      axios.get(`${this.$root.$options.vars.API_URL}courses`, { withCredentials: true }).then((response) => {
        this.courses = response.data;
        this.isLoading = false;
      }).catch((error) => {
        console.log(error);
      });
    },
  },
};
</script>
