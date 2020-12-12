<template>
  <div>
    <professor-list-row
      v-for="(professor, index) in professors"
      :key="`professor_${index}`"
      :professor="professor"
    />
  </div>
</template>
<script>
import ProfessorListRow from './ProfessorListRow.vue';

export default {
  components: { ProfessorListRow },
  props: {
    professors: { type: Array, required: true },
  },
};
</script>
