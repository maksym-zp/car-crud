window.Vue = require('vue');

Vue.component('car-form', require('./components/CarForm.vue').default);
import * as Tabs from 'vue-slim-tabs'
Vue.use(Tabs)
const app = new Vue({
    el: '#app'
});