<template>
  <div class="d-flex flex-row border-bottom p-3 profile-row">
    <div
    >
      <img
        src="build/images/svg/icons/professor.svg"
        alt="Professor profile picture"
        class="rounded-circle profile-image mr-4"
        width="50"
      >
    </div>
    <div class="my-auto flex-grow-1">
      <p class="mb-0">
        {{ professor.title }} {{ professor.name }}
        <br>
      </p>
    </div>
    <div class="text-right my-auto">
      <b-button
        :id="`professor_card_${professor.id}`"
        variant="outline-warning"
      >
        <b-icon icon="book"/>
        Vyučuje
      </b-button>
    </div>
    <b-popover
      :target="`professor_card_${professor.id}`"
      triggers="hover"
      placement="left"
    >
      <professor-card
        :professor="professor"
      />
    </b-popover>
  </div>
</template>
<script>
import ProfessorCard from './ProfessorCard.vue';

export default {
  components: { ProfessorCard },
  props: {
    professor: { type: Object, required: true },
  },
};
</script>
<style scoped lang="scss">
.profile-row:hover {
  background-color: $color-shades-light;
}
</style>
