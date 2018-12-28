import Vue from 'vue';
import App from './App.vue';
import BStore from './store/business-store';
import HPStore from './store/home-page-store';
import router from './router';
new Vue({
  el: '#app',
  router,
  BStore,HPStore,
  render: h => h(App)
})