import Vue from 'vue';
import Vuelidate from 'vuelidate';
import Toasted from 'vue-toasted';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import router from './router';
import { upperFirst } from 'lodash';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

const $ = require('jquery');
require('bootstrap');

Vue.use(Toasted, { duration: 5000 });
Vue.use(Vuelidate);

Vue.filter('capitalize', value => upperFirst(value));

window.validationErrorTranslations = {
  email: 'Toto není e-mail',
  required: 'Toto pole je povinné',
};


const app = new Vue({
  el: '#app',
  router,
  components: {
    'Navigation': () => import('./components/Navigation.vue'),
  },
});
