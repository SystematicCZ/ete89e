<template>
  <div>
    <profile-list-row
      v-for="(user, index) in users"
      :key="`user_${index}`"
      :user="user"
    />
  </div>
</template>
<script>
import ProfileListRow from './ProfileListRow.vue';

export default {
  components: { ProfileListRow },
  props: {
    users: { type: Array, required: true },
  },
};
</script>
