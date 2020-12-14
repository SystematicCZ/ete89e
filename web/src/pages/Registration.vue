<template>
  <div>
    <page-header
      heading="Pojď mezi nás"
      lead="Mohli bychom ti slibovat hory doly. Ale ty sem prostě chceš."
    />
    <b-container class="rounded py-5 rounded mt--3 bg-white">
      <b-container class="inner-container">
        <h2 class="mb-5">Registrace</h2>
        <profile-form
          v-model="user"
          registration
          @synchronize="modalVisible = true"
        />
        <b-modal
          v-model="modalVisible"
          title="Vyplněná data"
          centered
          hide-footer
          @close="modalVisible = false"
        >
          <p>{{ user }}</p>
        </b-modal>
      </b-container>
    </b-container>
  </div>
</template>
<script>
import PageHeader from '../components/PageHeader.vue';
import ProfileForm from '../components/profile/ProfileForm.vue';

export default {
  components: { ProfileForm, PageHeader },
  data() {
    return {
      user: null,
      modalVisible: false,
    };
  },
};
</script>
