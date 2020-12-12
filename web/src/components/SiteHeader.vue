<template>
  <header>
    <b-container
      fluid
    >
      <user-bar/>
    </b-container>
  </header>
</template>

<script>
import UserBar from './UserBar.vue';

export default {
  components: {
    UserBar,
  },
};
</script>
