<template>
  <b-container class="rounded bg-white py-5">
    <b-container class="inner-container">
      <h2>Vyučující</h2>
      <professor-list
        :professors="professors"
      />
    </b-container>
  </b-container>
</template>
<script>
import professors from '../_data/teachers.json';
import ProfessorList from '../components/professor/ProfessorList.vue';

export default {
  components: { ProfessorList },
  data() {
    return {
      professors,
    };
  },
};
</script>
<style scoped>

</style>
