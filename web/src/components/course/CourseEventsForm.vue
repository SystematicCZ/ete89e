<template>
  <div>
    <course-events-form-row
      v-for="(event, index) in eventList"
      :key="`event_edit_${event.id}`"
      v-model="eventList[index]"
      @delete="deleteEvent"
      @is-valid-change="changeEventValidity(event, $event)"
    />
    <course-events-form-row
      add-new
      @new="eventList.push($event)"
    />

    <form-buttons
      :submit-disabled="!canSubmit"
      class="mt-3 text-center"
      @save="submit"
    />
  </div>
</template>
<script>
import CourseEventsFormRow from './CourseEventsFormRow.vue';
import FormButtons from '../forms/FormButtons.vue';

export default {
  components: { FormButtons, CourseEventsFormRow },
  model: {
    prop: 'events',
    event: 'synchronize',
  },
  props: {
    events: { type: Array, default: () => [] },
  },
  data() {
    return {
      eventList: this.events,
      eventValidityList: this.getValidityList(),
      canSubmit: true,
    };
  },
  methods: {
    deleteEvent(event) {
      // fake
      this.eventList = this.eventList.filter(item => item.id !== event.id);
    },
    getValidityList() {
      const list = new Map();
      this.events.forEach(item => list.set(item.id, true));
      return list;
    },
    submit() {
      this.$toasted.success('Termíny uloženy');
      this.$emit('synchronize', this.eventList);
    },
    changeEventValidity(event, isValid) {
      this.eventValidityList.set(event.id, isValid);
      for (let value of this.eventValidityList.values()) {
        if (value === false) {
          this.canSubmit = false;
          return;
        }
      }
      this.canSubmit = true;
    },
  },
};
</script>
