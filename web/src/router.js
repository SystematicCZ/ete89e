import Vue from 'vue';
import Router from 'vue-router';
import About from './pages/About.vue';
import Dashboard from './pages/Dashboard.vue';
import Profile from './pages/Profile.vue';
import Course from './pages/Course.vue';
import UserList from './pages/UserList.vue';
import ProfessorList from './pages/ProfessorList.vue';
import Registration from './pages/Registration.vue';

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
      path: '/registration',
      name: 'registration',
      component: Registration,
    },
    {
      path: '/',
      name: 'dashboard',
      component: Dashboard,
      props: route => ({ query: route.query.query }),
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
      props: route => ({ query: route.query.query }),
    },
    {
      path: '/professors',
      name: 'professors',
      component: ProfessorList,
      props: route => ({ query: route.query.query }),
    },
  ],
});
