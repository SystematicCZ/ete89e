<template>
  <div>
    <input-wrapper
      :validations="validations.email"
      label="E-mail"
    >
      <input-text
        v-model="payload.email"
        :validations="validations.password"
      />
    </input-wrapper>

    <input-wrapper
      :validations="validations.password"
      label="Heslo"
    >
      <input-text
        v-model="payload.password"
        :validations="validations.password"
      />
    </input-wrapper>

    <form-buttons
      submit-text="Přihlásit"
      @save="submit"
    />
  </div>
</template>
<script>
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
      this.$store.dispatch('login').then(() => {
        this.$emit('logged-in');
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
