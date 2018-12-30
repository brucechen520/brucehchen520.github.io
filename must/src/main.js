import Vue from 'vue';
import App from './App.vue';
import Store from './store/store';
import router from './router';
new Vue({
  el: '#app',
  router,
  Store,
  render: h => h(App)
})