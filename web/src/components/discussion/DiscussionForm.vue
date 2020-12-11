<template>
  <div>
    <input-wrapper
      label="Zapojit se do diskuze"
    >
      <input-textarea
        v-model="payload.text"
      />
    </input-wrapper>
    <b-button
      variant="primary"
      class="ml-auto d-block"
    >
      Odeslat
    </b-button>
  </div>
</template>
<script>
import { required } from 'vuelidate/lib/validators';
import InputTextarea from '../forms/InputTextarea.vue';
import InputWrapper from '../forms/InputWrapper.vue';

export default {
  components: { InputWrapper, InputTextarea },
  data() {
    return {
      payload: {
        text: '',
      },
    };
  },
  validations: {
    payload: {
      text: { required },
    },
  },
};
</script>
