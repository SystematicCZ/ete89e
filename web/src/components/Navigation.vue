<template>
  <div>
    <b-navbar
      variant="faded"
      type="dark"
    >
      <b-navbar-brand href="/" class="mb-5">
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
      <b-nav-item to="/users">
        <b-icon icon="person-badge" class="mr-2"/>
        Uživatelé
      </b-nav-item>
      <b-nav-item to="/professors">
        <b-icon icon="people" class="mr-2"/>
        Vyučující
      </b-nav-item>
      <b-nav-item
        v-for="(course) in $store.state.user.courses"
        :key="`${course.id}_user_course_link`"
        :to="{ name: 'course', params:{id: course.id, slug: course.slug }}"
      >
        {{ course.name }}
      </b-nav-item>
    </b-nav>
  </div>
</template>
<script>
export default {};
</script>
