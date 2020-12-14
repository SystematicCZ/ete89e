import 'froala-editor/js/plugins.pkgd.min.js';
import 'froala-editor/js/third_party/embedly.min';
import 'froala-editor/js/third_party/font_awesome.min';
import 'froala-editor/js/third_party/spell_checker.min';
import 'froala-editor/js/third_party/image_tui.min';
import 'froala-editor/css/froala_editor.pkgd.min.css';

import { upperFirst } from 'lodash';
import Vue from 'vue';
import Vuex from 'vuex';
import Vuelidate from 'vuelidate';
import Toasted from 'vue-toasted';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import VueFroala from 'vue-froala-wysiwyg';
import router from './router';
import App from './App.vue';

Vue.use(VueFroala);
Vue.config.productionTip = false;

Object.defineProperty(Vue.prototype, '$sleep', { value: (ms => new Promise(res => setTimeout(res, ms, ms))) });

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Vuex);
Vue.use(Toasted, { duration: 5000 });
Vue.use(Vuelidate);

Vue.filter('capitalize', value => upperFirst(value));

window.validationErrorTranslations = {
  email: 'Toto není e-mail',
  required: 'Toto pole je povinné',
};

import charlie from './_data/charlie.json';
const store = new Vuex.Store({
  state: {
    user: charlie,
  },
  mutations: {
    login() {},
  },
});

const app = new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App),
});
