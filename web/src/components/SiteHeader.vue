<template>
  <header>
    <b-container
      fluid
    >
      <div class="d-flex flex-row justify-content-between border-bottom">
        <slot name="menu-toggle" />
        <user-nav
          v-if="$store.getters.isLoggedIn"
          class="ml-auto"
        />
      </div>
    </b-container>
  </header>
</template>

<script>
import UserNav from './UserNav.vue';

export default {
  components: {
    UserNav,
  },
};
</script>
