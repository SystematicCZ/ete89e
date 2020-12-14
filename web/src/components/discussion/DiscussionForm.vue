<template>
  <div>
    <slot name="reply" />
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
      type="submit"
      @click="send"
    >
      Odeslat
    </b-button>
  </div>
</template>
<script>
import { required } from 'vuelidate/lib/validators';
import formMixin from '../forms/formMixin';
import InputTextarea from '../forms/InputTextarea.vue';
import InputWrapper from '../forms/InputWrapper.vue';

export default {
  components: { InputWrapper, InputTextarea },
  mixins: [formMixin],
  data() {
    return {
      payload: {
        text: '',
      },
    };
  },
  methods: {
    send() {
      // fake
      const message = {
        date: (new Date()).toISOString().slice(0, 19).replace('T', ' '),
        text: this.payload.text,
        user: this.$store.state.user,
      };
      this.$emit('new-message', message);
    },
  },
  validations: {
    payload: {
      text: { required },
    },
  },
};
</script>
