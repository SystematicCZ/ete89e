<template>
  <div>
    <b-navbar
      variant="faded"
      type="dark"
    >
      <b-navbar-brand href="/" class="pb-3 mb-3 border-bottom">
        <img src="/build/images/logo.png" width="200" alt="Team 7 logo">
      </b-navbar-brand>
    </b-navbar>
    <b-nav
      vertical
    >
      <b-nav-item to="/">
        <b-icon icon="briefcase" class="mr-2"/>
        Kurzy
      </b-nav-item>
      <b-nav-item
        v-b-toggle.nav-subscribed-courses
      >
        <b-icon icon="bag-check" class="mr-2"/>
        Moje kurzy
        <b-collapse
          id="nav-subscribed-courses"
          is-nav
        >
          <b-nav-item
            v-for="(course) in $store.state.user.courses"
            :key="`${course.id}_user_course_link`"
            :to="{ name: 'course', params:{id: course.id, slug: course.slug }}"
          >
            {{ course.name }}
          </b-nav-item>
        </b-collapse>
      </b-nav-item>
      <b-nav-item to="/users">
        <b-icon icon="person-badge" class="mr-2"/>
        Uživatelé
      </b-nav-item>
      <b-nav-item to="/professors">
        <b-icon icon="people" class="mr-2"/>
        Vyučující
      </b-nav-item>
    </b-nav>
  </div>
</template>
<script>
export default {
};
</script>
<style scoped lang="scss">
.nav {
  li {
    padding: .4rem 0;

    & > a {
      color: $color-text-inverted-secondary;

      &.router-link-exact-active {
        color: $color-text-accent-light;
      }
    }

    &:hover > a:not(.router-link-exact-active) {
      color: $color-text-inverted;
    }
  }
}

</style>
