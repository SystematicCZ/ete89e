<template>
  <div>
    <div class="position-relative">
      <h3
        class="mb-4"
      >Informace o předmětu</h3>
      <form-edit-button
        :is-editing="isEditing"
        @edit="isEditing = true"
        @cancel="isEditing = false"
      />
    </div>
    <div
      v-if="!isEditing">
      <p v-html=" course.description" />
    </div>
    <div
      v-else
    >
      <course-description-form
        v-model="courseData"
      />
    </div>
  </div>
</template>
<script>
import CourseDescriptionForm from './CourseDescriptionForm.vue';
import FormEditButton from '../forms/FormEditButton.vue';

export default {
  components: { FormEditButton, CourseDescriptionForm, },
  props: {
    course: { type: Object, required: true },
  },
  data() {
    return {
      isEditing: false,
      courseData: this.course,
    };
  },
  watch: {
    courseData() {
      this.isEditing = false;
      this.emitChange();
    },
  },
  methods: {
    emitChange() {
      this.$emit('course-changed', this.courseData);
    },
  },
};
</script>
