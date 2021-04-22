<template>
  <div>
    <page-header
      heading="Přidat kurz"
      lead="Máš informace o novém bojišti?"
    />
    <b-container class="shadow py-5 rounded mt--3 bg-white">
      <b-container class="inner-container">
        <h2 class="mb-5">Přidat kurz</h2>
        <course-description-form
          @synchronize="(event) => $router.push({name: 'course', params: { id: event.id, slug: event.slug}})"
        />
      </b-container>
    </b-container>
  </div>
</template>
<script>
import PageHeader from '../components/PageHeader.vue';
import CourseDescriptionForm from '../components/course/CourseDescriptionForm.vue';

export default {
  components: {
    CourseDescriptionForm,
    PageHeader,
  },
};
</script>
