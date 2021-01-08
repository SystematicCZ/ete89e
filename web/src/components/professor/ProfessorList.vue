<template>
  <div>
    <div
      v-if="professors.length === 0"
    >
      <p>Zdá se, že tu nikdo nění</p>
    </div>
    <div
      v-else
    >
      <professor-list-row
        v-for="(professor, index) in professors"
        :key="`professor_${index}`"
        :professor="professor"
      />
    </div>
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
