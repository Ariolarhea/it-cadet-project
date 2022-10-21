require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('reports', require('./components/reports/Index.vue').default);


const app = new Vue({
    el: '#app',
});
