import Vue from 'vue';
import Router from 'vue-router';
import Home from './pages/Home.vue';
import About from './pages/About.vue';
import Dashboard from './pages/Dashboard.vue';
import Profile from './pages/Profile.vue';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/profile',
      name: 'profile',
      component: Profile,
    },
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
