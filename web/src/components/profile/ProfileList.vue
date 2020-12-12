<template>
  <div>
    <div
      v-if="users.length === 0"
    >
      <p>Zdá se, že tu nikdo nění</p>
    </div>
    <div
      v-else
    >
      <profile-list-row
        v-for="(user, index) in users"
        :key="`user_${index}`"
        :user="user"
      />
    </div>
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
