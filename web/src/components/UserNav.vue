<template>
  <b-navbar>
    <b-navbar-nav
      class="align-items-center"
      right
    >
      <b-nav-item-dropdown
        class="mr-2 p-0"
        toggle-class="nav-link-custom p-0"
        no-caret
        right
      >
        <template
          v-slot:button-content
        >
          <div
            class="bg-accent-light d-inline-block p-2"
          >
            <img
              src="build/images/logo.png"
              width="0.1"
              height="38"
              alt="helper"
            >
            <b-icon icon="bell-fill"/>
            <b-badge
              variant="danger"
              pill
            > {{ notifications.length }}
            </b-badge>
          </div>
        </template>
        <b-dropdown-text
          v-for="(notification, index) in notifications"
          :key="`${index}_notification`"
          class="border-bottom notifications"
        >
          {{ notification }}
        </b-dropdown-text>
      </b-nav-item-dropdown>
      <b-nav-item-dropdown
        text="Charlie Shark"
        toggle-class="nav-link-custom p-0"
        no-caret
        right
      >
        <template v-slot:button-content>
          <div class="d-inline-block p-2 bg-accent-light">
            <img
              :src="$store.state.user.profilePicture"
              :alt="`${$store.state.user.fullName} profile picture`"
              class="rounded-circle mr-1"
              width="38"
            >
            <span> {{ $store.state.user.fullName }}</span>
          </div>
        </template>
        <b-dropdown-item
          to="/profile"
        >
          <b-icon
            icon="person-fill"
            aria-hidden="true"
          />
          Upravit profil
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
import axios from 'axios';

export default {
  data() {
    return {
      notifications: ['Some notification 1', 'Some notification 2'],
    };
  },
  methods: {
    logout() {
      axios.post(`${this.$root.$options.vars.API_URL}logout`, null, { withCredentials: true }).then((response) => {
        this.$store.dispatch('logout')
          .then(() => {
            this.$router.push('/login');
          });
      }).catch((error) => {
        console.log(error);
      });
    },
  },
};
</script>
<style scoped lang="scss">
.nav-link-custom {
  padding: 0 !important;
}

.notifications {
  min-width: 240px;
}
</style>
