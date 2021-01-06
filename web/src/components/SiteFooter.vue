<template>
  <b-container>
    <footer class="footer p-3 mt-3 text-secondary d-flex flex-row border-top">
      <p class="mb-0 mr-5 my-auto">© 2020 Tým 7</p>
      <b-link
        class="mr-5 my-auto"
        to="/about"
      >
        O projektu
      </b-link>
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
        <tm7-snake/>
      </b-modal>
    </footer>
  </b-container>
</template>
<script>
import Snake from './Tm7Snake.vue';

export default {
  components: { Snake },
};
</script>
