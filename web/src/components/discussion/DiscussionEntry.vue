<template>
  <div
    :style="{'width': width}"
    class="d-flex flex-column align-items-end"
  >
    <div
      :class="{'border-left': level > 0}"
      class="p-3 d-flex flex-row w-100"
    >
      <div
      >
        <img
          :src="entry.user.profilePicture"
          class="rounded-circle profile-image mr-2"
        >
      </div>
      <div class="flex-grow-1">
        <header
          class="d-flex flex-row justify-content-between mb-2 bg-transparent"
        >
          <h6
            class="d-inline-block my-auto "
          >
            {{ entry.user.fullName }}
          </h6>
          <b-button
            v-b-toggle="`${_uid}_reply_form`"
            variant="outline-primary"
            @click="replyFormVisible = !replyFormVisible"
          >
            Odpovědět
          </b-button>
        </header>
        <section>
          <p v-html="entry.text" />
          <div class="pt-1">
            <span class="text-secondary">{{ parseDate(entry.date) }}</span>
          </div>
        </section>
      </div>
    </div>
    <b-collapse
      v-model="replyFormVisible"
      class="w-100 my-3"
    >
      <discussion-form
        class="border-bottom border-top p-3"
        @new-message="replies.push($event); replyFormVisible = false;"
      >
        <template v-slot:reply>
          <div class="position-relative">
            <h5 class="text-center">
              Odpovědět uživateli {{ entry.user.fullName }}
              <b-button
                variant="link"
                class="cancel-button"
                @click="replyFormVisible = false"
              >
                <b-icon icon="x" />
              </b-button>
            </h5>
          </div>
        </template>
      </discussion-form>
    </b-collapse>
    <discussion-entry
      v-for="(entry, index) in replies"
      :key="`${_uid}_entry_reply_${index}`"
      :level="level + 1"
      :entry="entry"
      class="flex-grow-1"
    />
  </div>
</template>
<script>
import entries from '../../_data/discussion.json';
import ProfilePicture from '../profile/ProfilePicture.vue';
import DiscussionForm from './DiscussionForm.vue';

export default {
  name: 'DiscussionEntry',
  components: { DiscussionForm, ProfilePicture },
  props: {
    level: { type: Number, default: 0 },
    entry: { type: Object, required: true },
  },
  data() {
    return {
      replies: [],
      replyFormVisible: false,
    };
  },
  computed: {
    width() {
      return this.level === 0 ? '100%' : '90%';
      //return `${Math.max(60, 100 - (10 * this.level))}%`;
    },
  },
  created() {
    this.load();
  },
  methods: {
    load() {
      // fake
      this.replies = entries.splice(0, Math.floor(Math.random() * (entries.length + 1)));
    },
    parseDate(date) {
      return (new Date(date)).toLocaleString('cs-CZ');
    },
  },
};
</script>
<style scoped lang="scss">
.profile-image {
  min-width: 3rem;
  width: 3rem;
}

.cancel-button {
  position: absolute;
  right: 0;
}

</style>
