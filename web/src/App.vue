<template>
  <div class="d-flex wrapper">
    <div
      v-if="$store.getters.isLoggedIn"
      ref="sidebar"
      class="sidebar-wrapper vh-100 overflow-auto sticky-top background-rhombus d-md-block shadow"
    >
      <site-navigation/>
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
      >
        <router-view/>
      </main>
      <site-footer/>
    </div>
  </div>
</template>
<script>
import SiteHeader from './components/SiteHeader.vue';
import SiteFooter from './components/SiteFooter.vue';
import SiteNavigation from './components/SiteNavigation.vue';

export default {
  components: {
    SiteNavigation,
    SiteHeader,
    SiteFooter,
  },
  metaInfo: {
    title: 'Informace o studiu',
    titleTemplate: '%s | Team 7 app',
    meta: [
      { charSet: 'utf-8' },
      { viewport: 'width=device-width, initial-scale=1, shrink-to-fit=no' },
      {
        vmid: 'description',
        name: 'description',
        template: 'Unavuje tě neustále hledat informace o studiu? %s Pojď mezi nás, s námi ti žádné info neuteče!',
        content: '',
      },
      { keywords: 'Termín odevzdání, projekt, požadavky na zápočet, zkouška, zápočet, semestrální práce' },
      { author: 'author' },
    ],
  },
  methods: {
    toggleSideBar() {
      if (this.$refs.sidebar.classList.contains('shown')) {
        this.$refs.sidebar.classList.remove('shown');
        return;
      }

      this.$refs.sidebar.classList.add('shown');
    },
    replaceStringWildCard(template, content = '', wildCard = '%s') {
      return template.replace(wildCard, content);
    }
  },
};
</script>
<style lang="scss">
.sidebar-wrapper {
  min-width: 15rem;
  display: none;

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
