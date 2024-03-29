

require('./bootstrap');

window.Vue = require('vue').default;

import VueSweetalert2 from "vue-sweetalert2"
Vue.use(VueSweetalert2)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('user', require('./components/User.vue').default);
Vue.component('product', require('./components/Product.vue').default);
Vue.component('order', require('./components/Order.vue').default);
Vue.component('order_detail', require('./components/OrderDetail.vue').default);

const app = new Vue({
    el: '#app',
});
