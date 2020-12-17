<template>
  <div
  >
    <input-text
      v-model="term"
      :placeholder="placeholder"
      class="w-75"
      @keydown.enter="emitSearch"
    />
    <b-button
      v-if="button"
      variant="primary"
      class="ml-2"
      @click="emitSearch"
    >
      <b-icon icon="search"/>
      {{ button }}
    </b-button>
  </div>
</template>
<script>
import InputText from './forms/InputText.vue';

export default {
  components: { InputText },
  model: {
    prop: 'query',
    event: 'search',
  },
  props: {
    button: { type: String, default: null },
    placeholder: { type: String, default: '' },
    query: { type: String, default: '' },
  },
  data() {
    return {
      term: this.query,
    };
  },
  created() {
    window.addEventListener('keydown', this.onKeyPush);
  },
  destroyed() {
    window.removeEventListener('keydown', this.onKeyPush);
  },
  methods: {
    emitSearch() {
      this.$emit('search', this.term);
    },
    onKeyPush(event) {
      if (event.code === 'Enter') {
        this.emitSearch();
      }
    },
  },
};
</script>
