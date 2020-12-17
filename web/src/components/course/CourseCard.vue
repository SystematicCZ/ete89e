<template>
  <b-link :to="{name: 'course', params: {id: course.id, slug: course.slug}}">
    <b-card
      :title="course.name"
      class="h-100 border-0 shadow"
    >
      <b-card-text>
        <p class="text-secondary">{{ course.professor.title }} {{ course.professor.name }}</p>
        <b-row>
          <b-col
            cols="6"
          >
            <span><b-icon icon="chat-right-text" class="mr-2"></b-icon>34</span>
          </b-col>
          <b-col
            cols="6"
          >
            <span><b-icon icon="calendar-event" class="mr-2"></b-icon>{{ numOfEvents }}</span>
          </b-col>
        </b-row>
      </b-card-text>
    </b-card>
  </b-link>
</template>
<script>
export default {
  props: {
    course: { type: Object, required: true },
  },
  data() {
    return {};
  },
  computed: {
    numOfEvents() {
      return this.course.events.length;
    },
  },
};
</script>
