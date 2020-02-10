window.Vue = require('vue');

Vue.component('car-form', require('./components/CarForm.vue').default);

const app = new Vue({
    el: '#app'
});