<template>
  <div class="d-flex flex-column align-items-end">
    <div
      :style="{'width': width}"
      :class="{'border-left': level > 0}"
      class="p-3 d-flex flex-row"
    >
      <div
      >
        <img
          src="http://placekitten.com/70"
          class="rounded-circle profile-image mr-2"
        >
      </div>
      <div>
        <header
          class="d-flex flex-row justify-content-between mb-2 bg-transparent"
        >
          <h6
            class="d-inline-block my-auto "
          >
            Name Namevi4
          </h6>
          <b-button
            variant="outline-primary"
          >
            Odpovědět
          </b-button>
        </header>
        <section>
          <p>
            Divadlo, velkopanskou slouží a jenže. Třas pohodlná vousy má zahraničních až nedopustil
            porota těm mísí. Noci to být sahal sedmičku o muselo
            fuk vidíš přestalo brzdu skok ó zafrkl he drážďanským prince.
            Nejvzácnější, se střední z podrbáním, boj úmysl o nemocí.
          </p>
          <div class="pt-1">
            <p>23. 12. 2020 22:11</p>
          </div>
        </section>
      </div>
    </div>
    <discussion-entry
      v-if="replies"
      :level="level + 1"
    />
  </div>
</template>
<script>
import ProfilePicture from '../profile/ProfilePicture.vue';

export default {
  name: 'DiscussionEntry',
  components: { ProfilePicture },
  props: {
    level: { type: Number, default: 0 },
  },
  data() {
    return {
      // fake
      replies: Math.random() < 0.5,
    };
  },
  computed: {
    width() {
      return `${Math.max(60, 100 - (10 * this.level))}%`;
    },
  },
};
</script>
<style scoped>
.chat-entry .profile-image {
  min-width: 3rem;
  width: 3rem;
}

</style>
