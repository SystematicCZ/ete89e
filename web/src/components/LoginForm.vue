<template>
  <div>
    <input-wrapper
      :validations="validations.email"
      label="E-mail"
    >
      <input-text
        v-model="payload.email"
        :validations="validations.email"
      />
    </input-wrapper>

    <input-wrapper
      :validations="validations.password"
      label="Heslo"
    >
      <input-text
        v-model="payload.password"
        :validations="validations.password"
        type="password"
      />
    </input-wrapper>

    <form-buttons
      submit-text="Přihlásit"
      @save="submit"
    />
  </div>
</template>
<script>
import axios from 'axios';
import { required } from 'vuelidate/lib/validators';
import formMixin from './forms/formMixin';
import InputWrapper from './forms/InputWrapper.vue';
import InputText from './forms/InputText.vue';
import FormButtons from './forms/FormButtons.vue';

export default {
  components: { FormButtons, InputText, InputWrapper },
  mixins: [formMixin],
  data() {
    return {
      payload: {
        email: '',
        password: '',
      },
    };
  },
  methods: {
    submit() {
      axios.post(`${this.$root.$options.vars.API_URL}login`, this.payload, { withCredentials: true }).then((response) => {
        this.$store.dispatch('login', response.data).then(() => {
          this.$emit('logged-in');
        });
      }).catch((error) => {
        console.log(error);
      });
    },
  },
  validations: {
    payload: {
      email: { required },
      password: { required },
    },
  },
};
</script>
