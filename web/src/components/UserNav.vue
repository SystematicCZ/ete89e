<template>
  <b-navbar>
    <b-navbar-nav
      right
    >
      <b-nav-item-dropdown
        class="user-navbar"
        text="Charlie Shark"
        toggle-class="nav-link-custom"
        no-caret
        right
      >
        <template v-slot:button-content>
          <img
            :src="$store.state.user.profilePicture"
            class="rounded-circle mr-1"
            width="38">
          <span>Charlie Shark</span>
        </template>
        <b-dropdown-item
          to="/profile"
        >
          <b-icon
            icon="person-fill"
            aria-hidden="true"
          />
          {{ $store.state.user.fullName }}
        </b-dropdown-item>
        <b-dropdown-divider/>
        <b-dropdown-item
          @click="logout"
        >
          <b-icon
            icon="box-arrow-right"
            aria-hidden="true"
          />
          Odhlásit se
        </b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </b-navbar>
</template>
<script>
export default {
  methods: {
    logout() {
      this.$store.dispatch('logout')
        .then(() => {
          this.$router.push('/login');
        });
    },
  },
};
</script>
<style scoped lang="scss">
.user-navbar {
  span {
    color: $color-text-inverted;

    &:hover {
      color: $color-shades-dark;
    }
  }
}
</style>
