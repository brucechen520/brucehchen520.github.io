import Vue from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';
import axios from 'axios'
import VueAxios from 'vue-axios'
import api from './components/lib/api'
Vue.use(VueAxios, axios)
new Vue({
  el: '#app',
  api,
  router,
  store,
  render: h => h(App)
})