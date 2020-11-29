<template>
  <b-card
  >
    <div class="card-profile-img text-center">
      <img
        :src="user.profilePicture"
        width="170"
        class="rounded-circle"
      >
    </div>
    <b-card-text
      class="text-center"
    >
      <h5>{{ user.fullName }}</h5>
      <p class="text-secondary mb-3">{{ user.university }}</p>
      <p>{{ user.aboutMe }}</p>
    </b-card-text>
  </b-card>
</template>
<script>
export default {
  props: {
    user: { type: Object, required: true },
  },
};
</script>
