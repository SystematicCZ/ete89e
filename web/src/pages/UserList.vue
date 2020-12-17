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
import searchableMixin from '../components/searchableMixin';
import users from '../_data/users.json';
import ProfileList from '../components/profile/ProfileList.vue';
import PageHeader from '../components/PageHeader.vue';
import SearchBar from '../components/SearchBar.vue';
import SkeletonList from '../components/skeleton/SkeletonList.vue';

export default {
  components: { SkeletonList, SearchBar, PageHeader, ProfileList },
  mixins: [searchableMixin],
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
      // fake
      this.users = users;
      this.$sleep(400).then(() => {
        this.loading = false;
      });
    },
    search(query) {
      // fake
      this.loading = true;
      this.users = users.filter(item => item.fullName.toLowerCase().includes(query.toLowerCase()));
      this.$sleep(400).then(() => {
        this.loading = false;
      });
    },
  },
};
</script>
