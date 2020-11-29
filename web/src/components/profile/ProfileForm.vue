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
        <b-button
          variant="primary">
          <b-icon icon="check" /> Uložit
        </b-button>
        <b-button
          variant="warning"
          @click="cancel"
        >
          <b-icon icon="x" /> Zrušit
        </b-button>
      </b-col>
    </b-row>
  </div>
</template>
<script>
import { required, email } from 'vuelidate/lib/validators';
import { cloneDeep } from 'lodash';
import formMixin from '../forms/formMixin';
import InputWrapper from '../forms/InputWrapper.vue';
import InputText from '../forms/InputText.vue';
import InputTextarea from '../forms/InputTextarea.vue';

export default {
  components: {
    InputText,
    InputWrapper,
    InputTextarea,
  },
  mixins: [formMixin],
  methods: {
    cancel() {
      this.payload = cloneDeep(this.form.payload);
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
