export default {
  props: {
    query: { type: String, default: '' },
  },

  data() {
    return {
      term: this.query,
    };
  },
  watch: {
    term(newValue) {
      this.$router.push({ path: this.$route.path, query: { query: newValue } });
      this.search(newValue);
    },
  },
  methods: {
    search(term) {
      throw new Error('Implement search method');
    },
  },
};
