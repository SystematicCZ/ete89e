<template>
  <b-container>
    <footer class="footer p-3 text-secondary d-flex flex-row">
      <p class="mb-0 mr-5 my-auto">© 2020 Tým 7</p>
      <b-button
        v-b-modal.snake
        variant="outline-primary"
      >
        Had
      </b-button>
      <b-modal
        id="snake"
        title="Had"
        centered
        hide-footer
      >
        <snake/>
      </b-modal>
    </footer>
  </b-container>
</template>
<script>
import Snake from './Snake.vue';

export default {
  components: { Snake },
};
</script>
