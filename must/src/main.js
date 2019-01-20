import Vue from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate)
new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})