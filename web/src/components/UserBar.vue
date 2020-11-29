<template>
  <b-navbar
    class="border-bottom"
  >
    <b-navbar-nav
      class="ml-auto"
      right
    >
      <b-nav-item-dropdown
        id="user-dropdown"
        text="Charlie Shark"
        toggle-class="nav-link-custom"
        no-caret
        right
      >
        <template v-slot:button-content>
          <img class="rounded-circle mr-1" src="http://placekitten.com/170" width="38"/>
          <span>Charlie Shark</span>
        </template>
        <b-dropdown-item
          to="/profile"
        >
          <b-icon
            icon="person-fill"
            aria-hidden="true"
          />
          Profil
        </b-dropdown-item>
        <b-dropdown-divider/>
        <b-dropdown-item>
          <b-icon
            icon="box-arrow-right"
            aria-hidden="true"
          />
          Odhlásit se
        </b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </b-navbar>
</template>
<script>
export default {};
</script>
