<template>
  <div class="d-flex flex-column border-bottom py-3">
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
      :validations="validations.date"
      label="Čas"
    >
      <input-date-time
        v-model="payload.date"
      />
    </input-wrapper>
    <b-button
      v-b-tooltip
      v-if="!addNew"
      variant="link"
      title="Smazat"
      @click="$emit('delete', event);"
    >
      <b-icon icon="trash"/>
    </b-button>
    <b-button
      v-if="addNew"
      type="submit"
      variant="warning"
      @click="emitNew"
    >
      Přidat
    </b-button>
  </div>
</template>
<script>
import { required } from 'vuelidate/lib/validators';
import formMixin from '../forms/formMixin';
import InputWrapper from '../forms/InputWrapper.vue';
import InputText from '../forms/InputText.vue';
import InputDateTime from '../forms/InputDateTime.vue';

const validDate = value => value.time !== null && value.date !== null;


export default {
  components: { InputDateTime, InputText, InputWrapper },
  mixins: [formMixin],
  model: {
    prop: 'event',
    event: 'synchronize',
  },
  props: {
    event: { type: Object, default: null },
    addNew: { type: Boolean, default: false },
  },
  data() {
    return {
      payload: this.getPayload(),
    };
  },
  watch: {
    payload: {
      deep: true,
      handler() {
        this.$emit('is-valid-change', this.isReadyToSubmit());
        if (this.isReadyToSubmit()) {
          this.emitChanged();
        }
      },
    },
  },
  methods: {
    getPayload() {
      const payload = {
        id: this.uuidv4(),
        name: '',
        date: { time: null, date: null },
        subscription: null,
      };

      if (this.event) {
        payload.id = this.event.id;
        payload.name = this.event.name;
        payload.date = { time: this.event.date.time, date: this.event.date.date };
        payload.subscription = this.event.subscription;
      }

      return payload;
    },
    emitChanged() {
      this.$emit('synchronize', this.payload);
    },
    emitNew() {
      this.$emit('new', this.payload);
      this.payload = this.getPayload();
    },
    uuidv4() {
      return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, (c) => {
        const r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
      });
    },
  },
  validations: {
    payload: {
      name: { required },
      date: { validDate },
    },
  },
};
</script>
