import Vue from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';
import VeeValidate from 'vee-validate'
import config from './validate/setupVeeValidate'
Vue.use(VeeValidate, config)
new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})