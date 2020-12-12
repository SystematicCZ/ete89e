<template>
  <div
  >
    <input-text
      v-model="searchString"
      :placeholder="placeholder"
      class="w-75"
      @keydown.enter="emitSearch"
    />
    <b-button
      v-if="button"
      variant="warning"
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
  props: {
    button: { type: String, default: null },
    placeholder: { type: String, default: '' },
  },
  data() {
    return {
      searchString: '',
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
      this.$emit('search', this.searchString);
    },
    onKeyPush(event) {
      if (event.code === 'Enter') {
        this.emitSearch();
      }
    },
  },
};
</script>
