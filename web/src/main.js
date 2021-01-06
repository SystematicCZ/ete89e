import { upperFirst } from 'lodash';
import Vue from 'vue';
import VueMeta from 'vue-meta';
import Vuelidate from 'vuelidate';
import Toasted from 'vue-toasted';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import router from './router';
import App from './App.vue';
import 'froala-editor/css/froala_editor.pkgd.min.css';
import VueFroala from 'vue-froala-wysiwyg';
import store from './store';

require('froala-editor/js/froala_editor.pkgd.min.js');
require('froala-editor/js/plugins/image.min.js');
require('froala-editor/js/plugins/video.min.js');
require('froala-editor/js/plugins/link.min.js');
require('froala-editor/js/plugins/lists.min.js');
require('froala-editor/js/plugins/emoticons.min.js');
require('froala-editor/js/languages/cs.js');

Vue.use(VueMeta);
Vue.use(VueFroala);
Vue.config.productionTip = false;

Object.defineProperty(Vue.prototype, '$sleep', { value: (ms => new Promise(res => setTimeout(res, ms, ms))) });

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Toasted, { duration: 5000 });
Vue.use(Vuelidate);

Vue.filter('capitalize', value => upperFirst(value));

window.validationErrorTranslations = {
  email: 'Toto není e-mail',
  required: 'Toto pole je povinné',
  sameAs: 'Pole nejsou stejná',
};

const app = new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App),
});
