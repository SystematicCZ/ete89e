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
        clss="mb-2"
      >
        <div class="rounded p-3 bg-white">
          <profile-form
            :form="form"
            submit-url=""
          />
        </div>
      </b-col>
      <b-col
        cols="12"
        class="d-md-none text-center mt-2"
      >
        <b-button
          variant="danger"
        >
          <b-icon
            icon="trash"
          />
          Smazat účet
        </b-button>
      </b-col>
    </b-row>
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
      form: {
        payload: {
          email: user.email,
          firstName: user.firstName,
          lastName: user.lastName,
          university: user.university,
          aboutMe: user.aboutMe,
        },
      },
    };
  },
  created() {
    this.$route.meta.heading = this.user.fullName;
  },
  methods: {},
  beforeRouteEnter(to, from, next) {
    //to.meta.heading = 'Courses';
    next();
  },
};
</script>
