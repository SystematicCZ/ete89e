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
import axios from 'axios';
import { required } from 'vuelidate/lib/validators';
import formMixin from '../forms/formMixin';
import InputWrapper from '../forms/InputWrapper.vue';
import InputText from '../forms/InputText.vue';
import FormButtons from '../forms/FormButtons.vue';
import InputTextarea from '../forms/InputTextarea.vue';
import InputMultiselect from '../forms/InputMultiselect.vue';
import RequiredTip from '../forms/RequiredTip.vue';

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
      professors: [],
    };
  },
  created() {
    axios.get(`${this.$root.$options.vars.API_URL}professors/`, { withCredentials: true }).then((response) => {
      this.professors = response.data;
    }).catch((error) => {
      console.log(error);
    });
  },
  methods: {
    getPayload() {
      const payload = {
        name: '',
        description: '',
        professor: null,
      };

      if (this.course) {
        payload.name = this.course.name;
        payload.description = this.course.description;
        payload.professor = this.course.professor.id;
      }

      return payload;
    },
    save() {
      if (this.course) {
        this.update();
        return;
      }

      this.add();
    },
    update() {
      axios.put(`${this.$root.$options.vars.API_URL}courses/${this.course.id}`, this.payload, { withCredentials: true }).then((response) => {
        this.$toasted.success('Změny uloženy');
        this.$emit('synchronize', response.data);
      }).catch((error) => {
        console.log(error);
      });
    },
    add() {
      axios.post(`${this.$root.$options.vars.API_URL}courses`, this.payload, { withCredentials: true }).then((response) => {
        this.$toasted.success('Kurz přidán');
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
