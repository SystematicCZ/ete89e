<template>
  <b-row>
    <b-col
      cols="12"
      md="4"
      order-md="2"
    >
      <professor-card
        :professor="course.professor"
        class="mb-3"
      />

      <div class="rounded p-3 bg-white mb-3">
        <course-events :events="course.events"/>
      </div>
    </b-col>
    <b-col
      cols="12"
      md="8"
      order-md="1"
    >
      <div class="rounded p-3 bg-white mb-3">
        <course-description
          :course="course"
          class="mb-3"

          v-on="$listeners"
        />
      </div>
      <div class="rounded p-3 bg-white mb-3">
        <course-discussion/>
      </div>
    </b-col>
  </b-row>
</template>
<script>
import CourseEvents from './CourseEvents.vue';
import CourseDescription from './CourseDescription.vue';
import CourseDiscussion from './CourseDiscussion.vue';
import ProfessorCard from '../professor/ProfessorCard.vue';

export default {
  components: { ProfessorCard, CourseDescription, CourseEvents, CourseDiscussion },
  props: {
    course: { type: Object, required: true },
  },
};
</script>
