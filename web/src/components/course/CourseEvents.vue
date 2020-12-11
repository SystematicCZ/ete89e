<template>
  <div>
    <h4
      class="mb-4"
    >Termíny</h4>
    <course-events-row
      v-for="(event, index) in events"
      :key="`event_${index}`"
      :event="event"
    />
  </div>
</template>
<script>
import CourseEventsRow from './CourseEventsRow.vue';

export default {
  components: { CourseEventsRow },
  props: {
    events: { type: Array, required: true },
  },
  data() {
    return {
      subscribed: [],
    };
  },
};
</script>
