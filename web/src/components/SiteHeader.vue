<template>
  <header class="bg-shades-light background-paper">
    <b-container
      fluid
    >
      <div class="d-flex flex-row justify-content-between align-items-center">
        <slot name="menu-toggle"/>
        <user-nav
          v-if="$store.getters.isLoggedIn"
          class="ml-auto"
        />
        <default-nav
          v-else
        />
      </div>
    </b-container>
  </header>
</template>

<script>
import UserNav from './UserNav.vue';
import DefaultNav from './DefaultNav.vue';

export default {
  components: {
    DefaultNav,
    UserNav,
  },
};
</script>
