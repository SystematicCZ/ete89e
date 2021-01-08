<template>
  <div class="input-group">
    <b-form-datepicker
      v-model="datetime.date"
      :state="datetime.date !== null"
      locale="cs"
      class="form-control"
    />
    <b-form-timepicker
      v-model="datetime.time"
      :state="datetime.time !== null"
      locale="cs"
      class="form-control"
    />
  </div>
</template>

<script>

export default {
  props: {
    validations: { type: Object, default: null },
    value: {
      type: Object, default: () => ({ time: null, date: null }),
    },
  },

  data() {
    return {
      datetime: {
        time: this.value.time,
        date: this.value.date,
      },
    };
  },
  watch: {
    datetime: {
      handler() {
        this.update();
      },
      deep: true,
    },
  },
  methods: {
    update() {
      if (this.datetime.time !== null && this.datetime.date !== null) {
        this.$emit('input', this.datetime);
      }
    },
  },
};
</script>
