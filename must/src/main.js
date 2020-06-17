import Vue from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';
import axios from 'axios'
import VueAxios from 'vue-axios'
import api from './components/lib/api'
import { ValidationObserver, ValidationProvider, extend } from 'vee-validate';
import { required, email } from 'vee-validate/dist/rules';
import zh_TW from 'vee-validate/dist/locale/zh_TW';
import jquery from 'jquery'
import VModal from 'vue-js-modal' 
Vue.use(VModal, { dialog: true })
import VueCookies from 'vue-cookies'
Vue.use(VueCookies)
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Install BootstrapVue
Vue.use(BootstrapVue)
//style
import './assets/css/global.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import AppPlugin from './assets/app-plugin.js'
// Vue.use(VeeValidate, {
//   validity: true,
//   fieldsBagName: 'vvFields',
// })

// Add a rule.
extend('email', {
  ...email,
  message: '請輸入正確的信箱'
});
extend('required', {
  ...required,
  message: '必填'
});


// Register it globally
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

Vue.use(VueAxios, axios)
Vue.use(AppPlugin)
new Vue({
  el: '#app',
  api,
  router,
  store,
  jquery,
  render: h => h(App)
})