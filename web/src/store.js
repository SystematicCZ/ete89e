import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: {
      token: localStorage.getItem('token') || null,
      expiryDate: localStorage.getItem('tokenExpiry') || null,
    },
  },
  mutations: {
    login(state, loginData) {
      state.user = loginData.user;
      state.token = loginData.token;
    },
    logout(state) {
      state.user = null;
      state.token = { token: null };
    },
  },
  getters: {
    isLoggedIn: state => state.token.token !== null && state.token.expiryDate > (new Date()).getTime(),
  },
  actions: {
    logout({ commit }) {
      localStorage.removeItem('token');
      commit('logout');
    },
    login({ commit }, user) {
      console.log(user);
      const now = new Date();
      const token = now.getTime();
      const expiryDate = new Date(now.getTime() + ((60 * 60 * 24) * 1000)).getTime();
      localStorage.setItem('token', token);
      localStorage.setItem('tokenExpiry', expiryDate);
      localStorage.setItem('user', JSON.stringify(user));

      commit('login', { user, token: { token, expiryDate } });
    },
  },
});

export default store;
