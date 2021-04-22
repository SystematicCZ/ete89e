<template>
  <div>
    <page-header
      heading="Ostatní zmatení"
      lead="Tady se můžeš podívat, kdo další bojuje na stejném kolbišti."
    >
      <template v-slot:controls>
        <search-bar
          v-model="term"
          button="Hledat"
        />
      </template>
    </page-header>
    <b-container class="rounded shadow bg-white py-5 mt--3">
      <b-container class="inner-container">
        <h2 class="mb-5">Uživatelé <span v-if="term.length"> - {{ term }}</span></h2>
        <skeleton-list
          v-if="loading"
        />
        <div
          v-else
        >
          <profile-list
            :users="users"
          />
          <div
            class="mt-3"
          >
            <b-pagination
              v-model="currentPage"
              total-rows="20"
              per-page="5"
              align="center"
            ></b-pagination>
          </div>
        </div>
      </b-container>
    </b-container>
  </div>
</template>
<script>
import axios from 'axios';
import searchableMixin from '../components/searchableMixin';
import ProfileList from '../components/profile/ProfileList.vue';
import PageHeader from '../components/PageHeader.vue';
import SearchBar from '../components/SearchBar.vue';
import SkeletonList from '../components/skeleton/SkeletonList.vue';

export default {
  components: { SkeletonList, SearchBar, PageHeader, ProfileList },
  mixins: [searchableMixin],
  metaInfo: {
    title: 'Studenti',
    meta: [
      {
        vmid: 'description',
        name: 'description',
        content: 'My víme kdo s tebou studuje.',
      },
    ],
  },
  data() {
    return {
      users: [],
      loading: true,
      currentPage: 1,
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
    load() {
      axios.get(`${this.$root.$options.vars.API_URL}users`, { withCredentials: true }).then((response) => {
        this.users = response.data;
        this.loading = false;
      }).catch((error) => {
        console.log(error);
      });
    },
    search(term) {
      this.loading = true;
      axios.get(
        `${this.$root.$options.vars.API_URL}users`,
        { withCredentials: true, params: { search: term } },
      ).then((response) => {
        this.users = response.data;
        this.loading = false;
      }).catch((error) => {
        console.log(error);
      });
    },
  },
};
</script>
