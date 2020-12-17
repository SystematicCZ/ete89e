<template>
  <b-container
    fluid
    class="pb-5 background-paper"
  >
    <b-container
      class="mb-5"
    >
      <b-row>
        <b-col
          cols="12"
        >
          <div>
            <b-breadcrumb
              v-if="$route.meta.breadcrum"
              :items="$route.meta.breadcrum"
              class="bg-shades-light"
            />
          </div>
        </b-col>
        <b-col
          cols="12"
          md="7"
        >
          <div
            class="py-3"
          >
            <div class="d-inline-block bg-accent-light">
              <slot name="heading">
                <h1
                  v-if="heading"
                  class="m-2"
                  v-text="heading"
                />
              </slot>
            </div>
            <br>
            <div class="mt-4 bg-accent-light d-inline-block h6">
              <slot name="lead">
                <p
                  v-if="lead"
                  class="m-2 mb-0"
                  v-text="lead"
                />
              </slot>
            </div>
          </div>
        </b-col>
        <b-col
          cols="12"
          md="5"
          class="pt-5 px-0 align-self-end text-right"
        >
          <slot name="controls"/>
        </b-col>
      </b-row>
    </b-container>
  </b-container>
</template>
<script>
export default {
  props: {
    heading: { type: String, default: '' },
    lead: { type: String, default: '' },
  },

};
</script>
