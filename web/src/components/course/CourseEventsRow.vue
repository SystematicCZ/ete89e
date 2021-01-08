<template>
  <div class="d-flex flex-wrap align-items-start">
    <span
      class="col-8 "
    >
      {{ event.name }}
      <span
        v-b-tooltip.hover
        v-show="event.subscription !== null && event.subscription.includes('email')"
        title="Upozornění e-mailem"
        class="ml-2"
      >
        <b-icon
          icon="envelope-fill"
        />
      </span>
      <br>
      <span class="text-secondary"> {{ parseDate(event.date.date) }} {{ event.date.time }}</span>
    </span>
    <span
      class="col-4 text-center mb-3"
    >
      <b-button
        v-b-tooltip.hover
        v-if="event.subscription !== null"
        variant="link"
        title="Zrušit upozornění"
        class="zoom"
        @click="unsubscribeEvent"
      >
        <b-icon
          variant="warning"
          icon="bell-fill"
        />
      </b-button>
      <b-button
        v-b-modal="`modal-subscribe-${_uid}`"
        v-b-tooltip.hover
        v-else
        variant="link"
        title="Upozornit na termín"
        class="zoom"
      >
        <b-icon icon="bell"/>
      </b-button>
      <b-modal
        :id="`modal-subscribe-${_uid}`"
        title="Upozornit na termín"
        centered
        hide-footer
      >
        <p class="my-4">
          V aplikaci budeš upozorněn na blížící se termín.
          Upozornění dostaneš týden a také jeden den před termínem.
        </p>
        <input-checkbox
          id="event_subscribe_email"
          v-model="subscribedByEmail"
          label="Upozornit také e-mailem"
        />
        <br>
        <b-button
          @click="() => { subscribeEvent(); $bvModal.hide(`modal-subscribe-${_uid}`); }"
        >
          Upozornit
        </b-button>
      </b-modal>
    </span>
  </div>
</template>
<script>
import InputCheckbox from '../forms/InputCheckbox.vue';

export default {
  components: {
    InputCheckbox,
  },
  props: {
    event: { type: Object, required: true },
  },
  data() {
    return {
      subscribedByEmail: false,
    };
  },
  methods: {
    parseDate(date) {
      return (new Date(date)).toLocaleDateString('cs-CZ');
    },
    subscribeEvent() {
      // fake
      this.event.subscription = [];
      this.event.subscription.push('notification');
      if (this.subscribedByEmail) {
        this.event.subscription.push('email');
      }

      this.$toasted.success('Upozornění nastaveno');
    },
    unsubscribeEvent() {
      // fake
      this.event.subscription = null;
      this.subscribedByEmail = false;
      this.$toasted.success('Upozornění zrušeno');
    },
  },
};
</script>
<style scoped>
.zoom svg {
  transition: transform .1s; /* Animation */
  cursor: pointer;
}

.zoom:hover svg {
  transform: scale(1.2);
}
</style>
