<template>
  <header>
    <b-container
      fluid
      class="pb-5"
    >
      <user-bar/>
      <b-container class="py-3">
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
            lg="6"
            md="10"
          >
            <div
              class="py-3 text-inverted"
            >
              <h1
                v-text="$route.meta.heading"
              />
              <p
                class="pt-4"
                v-text="$route.meta.perex"
              />
            </div>
          </b-col>
        </b-row>
      </b-container>
    </b-container>
  </header>
</template>

<script>
import UserBar from './UserBar.vue';

export default {
  components: {
    UserBar,
  },
};
</script>
