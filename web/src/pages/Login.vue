<template>
  <div>
    <page-header
      heading="Tohle není holubník"
      lead="Dřív než tě pustíme do hlavního stanu, musíme se zeptat na pár věcí"
    />
    <b-container class="py-5 mt--3 rounded shadow bg-white">
      <b-container class="inner-container">
        <h2 class="mb-5 text-center">Přihlášení</h2>
        <div class="w-50 mx-auto text-center">
          <login-form
            @logged-in="$router.push('/')"
          />
          <p class="mt-2">Neznáme se? Tak se <router-link to="/registration">představ.</router-link></p>
        </div>
      </b-container>
    </b-container>
  </div>
</template>
<script>
import PageHeader from '../components/PageHeader.vue';
import LoginForm from '../components/LoginForm.vue';

export default {
  components: { LoginForm, PageHeader },
  metaInfo: {
    title: 'Přihlaš se',
    meta: [
      {
        vmid: 'description',
        name: 'description',
        content: 'Vítej zpátky u nás. A kdo že jsi? Neznáme se? Omrkni to a už ti nikdy neuteče žádný info o studiu.',
        template: '%s',
      },
    ],
  },
};
</script>
