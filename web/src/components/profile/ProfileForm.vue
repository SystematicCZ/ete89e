<template>
  <div>
    <h3>Upravit profil</h3>
    <b-row>
      <b-col
        cols="12"
        md="6"
      >
        <input-wrapper
          :validations="validations.firstName"
          label="Jméno"
        >
          <input-text
            :validations="validations.firstName"
            v-model="payload.firstName"
          />
        </input-wrapper>
      </b-col>
      <b-col
        cols="12"
        md="6"
      >
        <input-wrapper
          label="Příjmení"
        >
          <input-text
            v-model="payload.lastName"
          />
        </input-wrapper>
      </b-col>

      <b-col
        cols="12"
      >
        <input-wrapper
          :validations="validations.email"
          label="E-mail"
        >
          <input-text
            :validations="validations.email"
            v-model="payload.email"
          />
        </input-wrapper>
      </b-col>

      <b-col
        cols="12"
      >
        <input-wrapper
          label="Univerzita"
        >
          <input-text
            v-model="payload.university"
          />
        </input-wrapper>
      </b-col>

      <b-col
        cols="12"
      >
        <input-wrapper
          label="O mně"
        >
          <input-textarea
            v-model="payload.aboutMe"
          />
        </input-wrapper>
      </b-col>
      <b-col
        cols="12"
      >
        <form-buttons
          @save="update"
          @cancel="cancel"
        />
      </b-col>
    </b-row>
  </div>
</template>
<script>
import { email, required } from 'vuelidate/lib/validators';
import { cloneDeep } from 'lodash';
import formMixin from '../forms/formMixin';
import InputWrapper from '../forms/InputWrapper.vue';
import InputText from '../forms/InputText.vue';
import InputTextarea from '../forms/InputTextarea.vue';
import user from '../../_data/charlie.json';
import FormButtons from '../forms/FormButtons.vue';

export default {
  components: {
    FormButtons,
    InputText,
    InputWrapper,
    InputTextarea,
  },
  mixins: [formMixin],
  model: {
    prop: 'user',
    event: 'synchronize',
  },
  data() {
    return {
      payload: this.getPayload(),
      originalPayload: this.getPayload(),
    };
  },
  methods: {
    cancel() {
      this.payload = cloneDeep(this.originalPayload);
    },
    getPayload() {
      return {
        email: user.email,
        firstName: user.firstName,
        lastName: user.lastName,
        university: user.university,
        aboutMe: user.aboutMe,
      };
    },
    update() {
      // fake
      const updated = cloneDeep(user);
      updated.email = this.payload.email;
      updated.firstName = this.payload.firstName;
      updated.lastName = this.payload.lastName;
      updated.university = this.payload.university;
      updated.fullName = `${this.payload.firstName} ${this.payload.lastName}`;

      this.originalPayload = cloneDeep(this.payload);

      this.$emit('synchronize', updated);
      this.$toasted.success('Změny uloženy');
    },
  },
  validations: {
    payload: {
      email: { required, email },
      firstName: { required },
    },
  },
};
</script>
