<template>
  <div>
    <input-wrapper
      :validations="validations.name"
      label="Název"
    >
      <input-text
        v-model="payload.name"
        :validations="validations.name"
      />
    </input-wrapper>

    <input-wrapper
      label="Popis"
    >
      <input-textarea
        v-model="payload.description"
        wysiwyg
      />
    </input-wrapper>
    <form-buttons
      @save="save"
    />
  </div>
</template>
<script>
import { cloneDeep } from 'lodash';
import { required } from 'vuelidate/lib/validators';
import formMixin from '../forms/formMixin';
import InputWrapper from '../forms/InputWrapper.vue';
import InputText from '../forms/InputText.vue';
import FormButtons from '../forms/FormButtons.vue';
import InputTextarea from '../forms/InputTextarea.vue';

export default {
  components: { InputTextarea, FormButtons, InputText, InputWrapper },
  mixins: [formMixin],
  model: {
    prop: 'course',
    event: 'synchronize',
  },
  props: {
    course: { type: Object, default: null },
  },
  data() {
    return {
      payload: this.getPayload(),
    };
  },
  methods: {
    getPayload() {
      const payload = {
        name: '',
        description: '',
      };

      if (this.course) {
        payload.name = this.course.name;
        payload.description = this.course.description;
      }

      return payload;
    },
    save() {
      // fake
      const course = cloneDeep(this.course);
      course.name = this.payload.name;
      course.description = this.payload.description;

      this.$toasted.success('Změny uloženy');
      this.$emit('synchronize', course);
    },
  },
  validations: {
    payload: {
      name: { required },
    },
  },
};
</script>
