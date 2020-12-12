import Vue from 'vue';
import Router from 'vue-router';
import About from './pages/About.vue';
import Dashboard from './pages/Dashboard.vue';
import Profile from './pages/Profile.vue';
import Course from './pages/Course.vue';
import UserList from './pages/UserList.vue';

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
    {
      path: '/course/:id/:slug',
      name: 'course',
      component: Course,
    },
    {
      path: '/users',
      name: 'users',
      component: UserList,
    },
  ],
});
