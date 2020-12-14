<template>
  <div>
    <h4
      class="mb-4"
    >
      Diskuze
    </h4>
    <discussion-entry
      v-for="(entry, index) in entries"
      :key="`course_entry_${index}`"
      :entry="entry"
    />
    <discussion-form
      class="my-4"
    />
  </div>
</template>
<script>
import entries from '../../_data/discussion.json';
import DiscussionEntry from '../discussion/DiscussionEntry.vue';
import DiscussionForm from '../discussion/DiscussionForm.vue';

export default {
  components: {
    DiscussionForm,
    DiscussionEntry,
  },
  data() {
    return {
      entries: [],
    };
  },
  created() {
    this.load();
  },
  methods: {
    load() {
      // fake
      this.entries = entries.splice(1, Math.floor(Math.random() * (entries.length)));
    },
  },
};
</script>
