import Vue from 'vue';
import App from './App.vue';
import Store from './store/store';
import router from './router';
import VeeValidate from 'vee-validate'
import config from './validate/setupVeeValidate'
Vue.use(VeeValidate, config)
new Vue({
  el: '#app',
  router,
  Store,
  render: h => h(App)
})