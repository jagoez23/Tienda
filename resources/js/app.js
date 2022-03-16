

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('user', require('./components/User.vue').default);
Vue.component('product', require('./components/Product.vue').default);


const app = new Vue({
    el: '#app',
});
