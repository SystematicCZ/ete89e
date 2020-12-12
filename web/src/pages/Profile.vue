<template>
  <b-container>
    <b-row>
      <b-col
        cols="12"
        md="4"
        order-lg="2"
        class="mb-2"
      >
        <profile-card
          :user="user"
        />

        <b-col
          cols="12"
          class="bv-d-md-down-none text-center mt-2"
        >
          <b-button
            v-b-modal.delete-profile-modal
            variant="danger"
          >
            <b-icon
              icon="trash"
            />
            Smazat účet
          </b-button>
        </b-col>
      </b-col>
      <b-col
        cols="12"
        md="8"
        class="mb-2"
      >
        <div class="rounded p-3 bg-white">
          <profile-form
            v-model="user"
          />
        </div>
      </b-col>
      <b-col
        cols="12"
        class="d-md-none text-center mt-2"
      >
        <b-button
          v-b-modal.delete-profile-modal
          variant="danger"
        >
          <b-icon
            icon="trash"
          />
          Smazat účet
        </b-button>
      </b-col>
    </b-row>

    <b-modal
      id="delete-profile-modal"
      centered
      hide-footer
    >
      <div class="text-center pb-5">
        <h4>To je konec</h4>
        <p>Je nám líto, že odcházíš. Opravdu si to nechceš rozmyslet?</p>
        <b-button
          variant="danger"
          @click="$bvModal.hide('delete-profile-modal')"
        >
          Jsem si jistý. Smažte mě
        </b-button>
      </div>
    </b-modal>
  </b-container>
</template>

<script>
import user from '../_data/charlie.json';
import ProfileForm from '../components/profile/ProfileForm.vue';
import ProfileCard from '../components/profile/ProfileCard.vue';

export default {
  components: {
    ProfileCard,
    ProfileForm,
  },
  data() {
    return {
      user,
    };
  },
  created() {
    this.$route.meta.heading = this.user.fullName;
  },
  methods: {},
};
</script>
