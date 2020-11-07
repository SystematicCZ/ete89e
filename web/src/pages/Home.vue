<template>
  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading">Page example</h1>
      <p class="lead text-muted">I'm the example page</p>

      <example-form
        submit-url="http://httpbin.org/post"
      />
    </div>
  </section>
</template>
<script>
import ExampleForm from '../components/ExampleForm.vue';

export default {
  components: {
    ExampleForm,
  },
};
</script>
