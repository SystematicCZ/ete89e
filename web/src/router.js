import Vue from 'vue';
import Router from 'vue-router';
import Home from './pages/Home.vue';
import About from './pages/About.vue';
import Dashboard from './pages/Dashboard.vue';

Vue.use(Router);

export default new Router({
  routes: [
    // {
    //   // path: '/',
    //   // name: 'home',
    //   // component: Home,
    // },
    {
      path: '/about',
      name: 'about',
      component: About,
    },
    {
      path: '/',
      name: 'dashboard',
      component: Dashboard,
    },
  ],
});
