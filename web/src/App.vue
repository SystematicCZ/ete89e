<template>
  <div class="d-flex wrapper">
    <div
      v-if="$store.getters.isLoggedIn"
      ref="sidebar"
      class="sidebar-wrapper vh-100 sticky-top bg-shades-dark d-md-block shadow"
    >
      <navigation/>
    </div>
    <div class="content-wrapper vw-100">
      <site-header>
        <template v-slot:menu-toggle>
          <b-button
            variant="link"
            class="navbar-toggler d-inline-block border bg-white d-md-none"
            @click="toggleSideBar"
          >
            <span class="navbar-toggler-icon"/>
          </b-button>
        </template>
      </site-header>
      <main
        role="main"
      >
        <router-view />
      </main>
      <site-footer/>
    </div>
  </div>
</template>
<script>
import Navigation from './components/Navigation.vue';
import SiteHeader from './components/SiteHeader.vue';
import SiteFooter from './components/SiteFooter.vue';

export default {
  components: {
    Navigation,
    SiteHeader,
    SiteFooter,
  },
  methods: {
    toggleSideBar() {
      if (this.$refs.sidebar.classList.contains('shown')) {
        this.$refs.sidebar.classList.remove('shown');
        return;
      }

      this.$refs.sidebar.classList.add('shown');
    },
  },
};
</script>
<style lang="scss">
.sidebar-wrapper {
  min-width: 15rem;
  display: none;
  transition: all 0.2s ease;

  &.shown {
    display: block !important;
  }

  &.showing {
    opacity: 0;
  }
}

.navbar-toggler-icon {
  background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30'%3E%3Cpath stroke='rgba(50, 50, 50, 0.5)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
}
</style>
