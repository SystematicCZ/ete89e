<template>
  <div>
    <page-header
      heading="Mentoři"
      lead="Tohle jsou lidé, kteří se ti snaží předat vědomosti."
    >
      <template v-slot:controls>
        <search-bar
          v-model="term"
          button="Hledat"
        />
      </template>
    </page-header>
    <b-container class="rounded bg-white py-5 mt--3">
      <b-container class="inner-container">
        <h2 class="mb-5">Vyčující <span v-if="term.length"> - {{ term }}</span></h2>
        <skeleton-list
          v-if="loading"
        />
        <div
          v-else
        >
          <professor-list
            :professors="professors"
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
import PageHeader from '../components/PageHeader.vue';
import SearchBar from '../components/SearchBar.vue';
import SkeletonList from '../components/skeleton/SkeletonList.vue';
import professors from '../_data/teachers.json';
import ProfessorList from '../components/professor/ProfessorList.vue';

export default {
  components: { ProfessorList, PageHeader, SearchBar, SkeletonList },
  mixins: [searchableMixin],
  data() {
    return {
      professors: null,
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
      this.professors = professors;
      this.$sleep(400).then(() => {
        this.loading = false;
      });
    },
    search(term) {
      // fake
      this.loading = true;
      this.professors = professors.filter(item => item.name.toLowerCase().includes(term.toLowerCase()));
      this.$sleep(400).then(() => {
        this.loading = false;
      });
    },
  },
};
</script>
