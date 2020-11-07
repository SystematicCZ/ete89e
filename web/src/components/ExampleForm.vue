<template>
  <form>
    <h3>
      This is an example form
    </h3>
    <input-wrapper
      :validations="validations.sampleText"
      label="Some text"
      label-extra="This is a tip"
    >
      <input-text
        v-model="payload.sampleText"
        :validations="validations.sampleText"
      />
    </input-wrapper>

    <input-wrapper
      label="Some select"
    >
      <input-select
        v-model="payload.sampleSelect"
        :options="[{value: 'option1', text: 'Option 1'}, {value: 'option2', text: 'Option 2'}]"
      />
    </input-wrapper>

    <button
      class="btn btn-primary"
      type="submit"
      @click.prevent="onSubmit"
    >
      Odeslat
    </button>

    <div>
      <code>
        {{ submittedData }}
      </code>
    </div>
  </form>
</template>
<script>
import { required } from 'vuelidate/lib/validators';
import FormMixin from './forms/formMixin';
import InputWrapper from './forms/InputWrapper.vue';
import InputText from './forms/InputText.vue';
import InputSelect from './forms/InputSelect.vue';

export default {
  components: {
    InputSelect,
    InputText,
    InputWrapper,
  },

  mixins: [FormMixin],

  props: {},

  data() {
    return {
      payload: {
        sampleText: '',
        sampleSelect: '',
      },
      submittedData: null,
    };
  },

  mounted() {
    console.log(this.submitButton);
  },

  methods: {
    onSubmit() {
      this.submittedData = this.payloadAsJson;
    },
  },

  validations: {
    payload: {
      sampleText: { required },
    },
  },
};
</script>
