console.log('rofl');

import Vue from 'vue';
import Vuelidate from 'vuelidate';
import Toasted from 'vue-toasted';
import router from './router';

const $ = require('jquery');
require('bootstrap');

Vue.use(Toasted, { duration: 5000 });
Vue.use(Vuelidate);


const app = new Vue({
  el: '#app',
  router,
});
