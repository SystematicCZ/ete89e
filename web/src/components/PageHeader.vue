<template>
  <b-container
    fluid
    class="bg-primary pb-5"
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
            class="py-3 text-inverted"
          >
            <slot name="heading">
              <h1
                v-if="heading"
                v-text="heading"
              />
            </slot>
            <slot name="lead">
              <p
                v-if="lead"
                class="pt-4"
                v-text="lead"
              />
            </slot>
          </div>
        </b-col>
        <b-col
          cols="12"
          md="5"
          class="pt-5 px-0 align-self-end"
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
