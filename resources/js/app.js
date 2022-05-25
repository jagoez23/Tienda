

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('user', require('./components/User.vue').default);
Vue.component('product', require('./components/Product.vue').default);
Vue.component('order', require('./components/Order.vue').default);
Vue.component('order_detail', require('./components/OrderDetail.vue').default);
Vue.component('format_import', require('./components/FormatImport.vue').default);

const app = new Vue({
    el: '#app',
});
