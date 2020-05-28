import Vue from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';
import axios from 'axios'
import VueAxios from 'vue-axios'
import api from './components/lib/api'
import VeeValidate, { Validator } from 'vee-validate';
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

Validator.localize('zh_TW', zh_TW);
Vue.use(VeeValidate, {
  validity: true,
  fieldsBagName: 'vvFields',
})
Vue.use(VueAxios, axios)
new Vue({
  el: '#app',
  api,
  router,
  store,
  jquery,
  render: h => h(App)
})