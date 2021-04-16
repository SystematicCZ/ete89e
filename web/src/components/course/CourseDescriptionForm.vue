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
      :validations="validations.professor"
      label="Vyučující"
    >
      <input-multiselect
        v-model="payload.professor"
        :options="professors"
        :validations="validations.professor"
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
    <required-tip/>
    <form-buttons
      @save="save"
    />
  </div>
</template>
<script>
import { required } from 'vuelidate/lib/validators';
import professors from '../../_data/teachers.json';
import formMixin from '../forms/formMixin';
import InputWrapper from '../forms/InputWrapper.vue';
import InputText from '../forms/InputText.vue';
import FormButtons from '../forms/FormButtons.vue';
import InputTextarea from '../forms/InputTextarea.vue';
import InputMultiselect from '../forms/InputMultiselect.vue';
import RequiredTip from '../forms/RequiredTip.vue';
import axios from 'axios';

export default {
  components: { RequiredTip, InputMultiselect, InputTextarea, FormButtons, InputText, InputWrapper },
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
      professors,
    };
  },
  methods: {
    getPayload() {
      const payload = {
        name: '',
        description: '',
        professor: {},
      };

      if (this.course) {
        payload.name = this.course.name;
        payload.description = this.course.description;
        payload.professor = this.course.professor.name;
      }

      return payload;
    },
    save() {
      const params = new URLSearchParams();
      params.append('payload', JSON.stringify(this.payload));

      axios.post(`${this.$root.$options.vars.API_URL}courses/${this.course.id}`, params).then((response) => {
        this.$toasted.success('Změny uloženy');
        this.$emit('synchronize', response.data);
      }).catch((error) => {
        console.log(error);
      });
    },
  },
  validations: {
    payload: {
      name: { required },
      professor: { required },
    },
  },
};
</script>
