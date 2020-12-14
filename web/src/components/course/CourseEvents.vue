<template>
  <div>
    <div class="position-relative">
      <h4
        class="mb-4"
      >Termíny
      </h4>
      <form-edit-button
        :is-editing="isEditing"
        @edit="isEditing = true"
        @cancel="isEditing = false"
      />
    </div>
    <div
      v-if="!isEditing"
    >
      <course-events-row
        v-for="(event, index) in eventList"
        :key="`event_${index}`"
        :event="event"
      />
    </div>
    <div
      v-else
    >
      <course-events-form
        v-model="eventList"
        @synchronize="isEditing = false"
      />
    </div>
  </div>
</template>
<script>
import CourseEventsRow from './CourseEventsRow.vue';
import FormEditButton from '../forms/FormEditButton.vue';
import CourseEventsForm from './CourseEventsForm.vue';

export default {
  components: { CourseEventsForm, FormEditButton, CourseEventsRow },
  props: {
    events: { type: Array, required: true },
  },
  data() {
    return {
      isEditing: false,
      subscribed: [],
      eventList: this.events,
    };
  },
};
</script>
