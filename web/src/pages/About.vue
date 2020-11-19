<template>
  <b-container class="rounded bg-white py-5">
    <b-container class="inner-container">
      <h2>This is an about page</h2>
      <p>Text goes here!</p>
    </b-container>
  </b-container>
</template>

<script>
export default {
  beforeRouteEnter(to, from, next) {
    to.meta.heading = 'About';
    to.meta.perex = 'Řek, nocí, a edenu si unikát položili, kráčet bodáky. Úřad jak vydaná, vztažená povídalo bůh revizor vyřídit, horváta co k láskou pan ceny země. Neumí čas, mi prominout křiku, duchař udělat vězení. Ke tvor od jejich do zle. Leží by curychu mé za podobaly.';
    to.meta.breadcrum = [{
      href: to.path,
      text: 'About',
    }];
    next();
  },
};
</script>
