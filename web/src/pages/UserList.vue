<template>
  <b-container class="rounded bg-white py-5">
    <b-container class="inner-container">
      <h2>Uživatelé</h2>
      <profile-list
        :users="users"
      />
    </b-container>
  </b-container>
</template>
<script>
import users from '../_data/users.json';
import ProfileList from '../components/profile/ProfileList.vue';

export default {
  components: { ProfileList },
  data() {
    return {
      users: [],
    };
  },
  created() {
    this.load();
  },
  methods: {
    load() {
      this.users = users;
    },
  },
};
</script>
