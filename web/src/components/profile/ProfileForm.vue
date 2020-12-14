<template>
  <div>
    <b-row>
      <b-col
        cols="12"
        class="text-center mb-3"
      >
        <input-wrapper
          :validations="validations.profilePicture"
          label="Ksicht"
          class="position-relative d-inline-block"
        >
          <input-image
            v-model="payload.profilePicture"
            :image="payload.profilePicture"
            circle
            @file-size-exceeded="$toasted.error('Soubor je příliš velký')"
          />
        </input-wrapper>
      </b-col>
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
        v-if="registration"
        cols="12"
      >
        <b-row>
          <b-col
            cols="6"
          >
            <input-wrapper
              :validations="validations.password"
              label="Heslo"
            >
              <input-text
                :validations="validations.password"
                v-model="payload.password"
              />
            </input-wrapper>
          </b-col>
          <b-col
            cols="6"
          >
            <input-wrapper
              :validations="validations.passwordControl"
              label="Heslo znovu"
            >
              <input-text
                :validations="validations.passwordControl"
                v-model="payload.passwordControl"
              />
            </input-wrapper>
          </b-col>
        </b-row>
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
          cancel-button
          @save="submit"
          @cancel="cancel"
        />
      </b-col>
    </b-row>
  </div>
</template>
<script>
import { email, required, requiredIf, sameAs } from 'vuelidate/lib/validators';
import { cloneDeep } from 'lodash';
import formMixin from '../forms/formMixin';
import InputWrapper from '../forms/InputWrapper.vue';
import InputText from '../forms/InputText.vue';
import InputTextarea from '../forms/InputTextarea.vue';
import FormButtons from '../forms/FormButtons.vue';
import InputImage from '../forms/InputImage.vue';

export default {
  components: {
    InputImage,
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
  props: {
    user: { type: Object, default: null },
    registration: { type: Boolean, default: false },
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
      const payload = {
        email: '',
        firstName: '',
        lastName: '',
        university: '',
        aboutMe: '',
        password: '',
        passwordControl: '',
        profilePicture: '',
      };
      if (this.user) {
        payload.email = this.user.email;
        payload.firstName = this.user.firstName;
        payload.lastName = this.user.lastName;
        payload.university = this.user.university;
        payload.aboutMe = this.user.aboutMe;
        payload.profilePicture = this.user.profilePicture;
      }

      return payload;
    },
    submit() {
      // fake
      const updated = cloneDeep(this.payload);
      updated.fullName = `${this.payload.firstName} ${this.payload.lastName}`;

      this.originalPayload = cloneDeep(this.payload);

      this.$emit('synchronize', updated);
      this.$toasted.success('Změny uloženy');
    },
  },
  validations: {
    payload: {
      profilePicture: { required },
      email: { required, email },
      firstName: { required },
      password: {
        required: requiredIf('registration'),
      },
      passwordControl: {
        sameAs: sameAs('password'),
        required: requiredIf('registration'),
      },
    },
  },
};
</script>
