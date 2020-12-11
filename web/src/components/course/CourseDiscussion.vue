<template>
  <div>
    <h4
      class="mb-4"
    >
      Diskuze
    </h4>
    <discussion-entry />
    <discussion-entry />
    <discussion-form
      class="my-4"
    />
  </div>
</template>
<script>
import DiscussionEntry from '../discussion/DiscussionEntry.vue';
import DiscussionForm from '../discussion/DiscussionForm.vue';

export default {
  components: {
    DiscussionForm,
    DiscussionEntry,
  },
};
</script>
