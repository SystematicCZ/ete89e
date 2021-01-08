<template>
  <div>
    <slot name="reply"/>
    <input-wrapper
      :validations="validations.text"
      label="Text zprávy"
    >
      <input-textarea
        v-model="payload.text"
        :validations="validations.text"
        wysiwyg
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
      this.$toasted.success('Příspěvek přidán');
      this.$emit('new-message', message);
      this.payload.text = '';
    },
  },
  validations: {
    payload: {
      text: { required },
    },
  },
};
</script>
