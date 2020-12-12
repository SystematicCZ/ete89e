<template>
  <div>
    <page-header
      heading="Ostatní zmatení"
      lead="Tady se můžeš podívat, kdo další bojuje na stejném kolbišti."
    >
      <template v-slot:controls>
        <search-bar
          button="Hledat"
          @search="search"
        />
      </template>
    </page-header>
    <b-container class="rounded bg-white py-5 mt--3">
      <b-container class="inner-container">
        <h2 class="mb-5">Uživatelé <span v-if="searchString.length"> - {{ searchString }}</span></h2>
        <list-skeleton
          v-if="loading"
        />
        <profile-list
          v-else
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
      </b-container>
    </b-container>
  </div>
</template>
<script>
import users from '../_data/users.json';
import ProfileList from '../components/profile/ProfileList.vue';
import PageHeader from '../components/PageHeader.vue';
import SearchBar from '../components/SearchBar.vue';
import ListSkeleton from '../components/ListSkeleton.vue';

const sleep = ms => new Promise(res => setTimeout(res, ms, ms));

export default {
  components: { ListSkeleton, SearchBar, PageHeader, ProfileList },
  data() {
    return {
      users: [],
      searchString: '',
      loading: true,
      currentPage: 1,
    };
  },
  created() {
    this.load();
  },
  methods: {
    load() {
      // fake
      this.users = users;
      sleep(400).then(() => {
        this.loading = false;
      });
    },
    search(term) {
      // fake
      this.loading = true;
      this.searchString = term;
      this.users = users.filter(item => item.fullName.toLowerCase().includes(term.toLowerCase()));
      sleep(400).then(() => {
        this.loading = false;
      });
    },
  },
};
</script>
