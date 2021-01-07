import Vue from 'vue';
import Router from 'vue-router';
import About from './pages/About.vue';
import Dashboard from './pages/Dashboard.vue';
import Profile from './pages/Profile.vue';
import Course from './pages/Course.vue';
import UserList from './pages/UserList.vue';
import ProfessorList from './pages/ProfessorList.vue';
import Registration from './pages/Registration.vue';
import Login from './pages/Login.vue';
import store from './store';

Vue.use(Router);

const router = new Router({
  //mode: 'history',
  //base: '/2021zs/ete89e/07/',
  routes: [
    {
      path: '/profile',
      name: 'profile',
      component: Profile,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: '/about',
      name: 'about',
      component: About,
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
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
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: '/course/:id/:slug',
      name: 'course',
      component: Course,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: '/users',
      name: 'users',
      component: UserList,
      props: route => ({ query: route.query.query }),
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: '/professors',
      name: 'professors',
      component: ProfessorList,
      props: route => ({ query: route.query.query }),
      meta: {
        requiresAuth: true,
      },
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters.isLoggedIn) {
      next();
      return;
    }
    next('/login');
  } else {
    next();
  }
});

export default router;
