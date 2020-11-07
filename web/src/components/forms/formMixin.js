import axios from 'axios';
import validationMixin from './validationMixin';

export default {
  mixins: [validationMixin],

  props: {
    submitUrl: { type: String, required: true },
  },

  data() {
    return {
      submitButton: null,
    };
  },
  mounted() {
    this.trackUserInteraction();
    this.submitButton = this.$el.querySelector('button[type=submit]');
    if (this.submitButton) {
      this.submitButton.disabled = !this.isReadyToSubmit();
    }
  },

  watch: {
    validations: {
      deep: true,
      handler() {
        if (this.submitButton) {
          this.submitButton.disabled = !this.isReadyToSubmit();
        }
      },
    },
  },

  computed: {
    payloadAsJson() {
      return JSON.stringify(this.payload);
    },
  },

  methods: {
    submit(payload = this.payload, method = 'post', submitUrl = this.submitUrl) {
      // We submit data as `application/x-www-form-urlencoded` because we want both classic
      // and AJAX forms to submit interchangeable requests (from the perspective of Symfony).
      const params = new URLSearchParams();
      params.append('payload', JSON.stringify(payload));

      return axios[method](submitUrl, params)
        .then((response) => {
          this.renderMessagesForSuccess(response);

          if (response.data.form) {
            this.$emit('synchronize-form', response.data.form);
          }

          return response; // to enable further Promise chaining
        })
        .catch((error) => {
          this.renderMessagesForFailure(error);

          throw error; // to enable further Promise chaining
        });
    },

    renderMessagesForSuccess(response) {
      if (response.data && response.data.messages) {
        this.renderMessages(response.data.messages);
      }
    },

    renderMessagesForFailure(error) {
      if (error.response && error.response.data && error.response.data.messages) {
        this.renderMessages(error.response.data.messages);
        return;
      }

      // In case we did not even get a "server understood" JSON response - i.e. 500 error.
      this.$toasted.error(window.generalPurposeErrorMessage);
    },

    renderMessages(messages) {
      messages.forEach((message) => {
        this.$toasted[message.type](message.body);
      });
    },
    createPayloadInput() {
      const input = document.createElement('INPUT');
      input.setAttribute('type', 'hidden');
      input.setAttribute('name', 'payload');
      input.setAttribute('value', this.payloadAsJson);

      return input;
    },
  },
};
