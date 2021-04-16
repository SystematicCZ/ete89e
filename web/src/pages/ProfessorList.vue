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
    <b-container class="rounded shadow bg-white py-5 mt--3">
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
import ProfessorList from '../components/professor/ProfessorList.vue';
import axios from 'axios';

export default {
  components: { ProfessorList, PageHeader, SearchBar, SkeletonList },
  mixins: [searchableMixin],
  metaInfo: {
    title: 'Vyučující',
    meta: [
      {
        vmid: 'description',
        name: 'description',
        content: 'My víme kdo tě bude trápit.',
      },
    ],
  },
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
      axios.get(`${this.$root.$options.vars.API_URL}professors`).then((response) => {
        this.professors = response.data;
        this.loading = false;
      }).catch((error) => {
        console.log(error);
      });
    },
    search(term) {
      this.loading = true;

      axios.post(`${this.$root.$options.vars.API_URL}professors/search`, { search: term }).then((response) => {
        this.professors = response.data;
        this.loading = false;
      }).catch((error) => {
        console.log(error);
      });
    },
  },
};
</script>
