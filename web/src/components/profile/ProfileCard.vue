<template>
  <b-card
    class="border-0 shadow"
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
      <p class="text-secondary mb-3">
        {{ user.faculty.name }}
        <br>
        <b-icon
          icon="envelope"
          class="mr-1"
        />
        {{ user.email }}
      </p>
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
<style scoped lang="scss">
.card-profile-img {
  margin-bottom: -40px;

  img {
    border: 5px solid #ffffff;
    width: 170px;
    transform: translate(0, -40%);
    border-radius: .375rem;
  }
}
</style>
