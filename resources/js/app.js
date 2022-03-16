require('./bootstrap');

window.Vue = require('vue');

import Messengers from './_messengers';
import Addresses from './_addresses';
import Customers from './_customers';
import Orders from './_orders';
import General from './_general';
import Permissions from './_permissions';
import Zones from './_zones';
import BranchOffices from './_branchOffice';
import Parameters from './_parameters';
import Hours from './_hours';

//Vue Components
Vue.component('deliveries-ondemand', require('./components/deliveries/deliveriesOndemand.vue').default);
Vue.component('example-component', require('./components/exampleComponent.vue').default);
Vue.component('department-tab', require('./components/department/department.vue').default);
Vue.component('status-matrix', require('./components/statusMatrix/statusMatrix.vue').default);
Vue.component('deliveries', require('./components/deliveries/deliveries.vue').default);
Vue.component('modal', require('./components/modal.vue').default);

let messengers = new Messengers();
let addresses = new Addresses();
let customers = new Customers();
let orders = new Orders();
let general = new General();
let permissions = new Permissions();
let zones = new Zones();
let branchOffice = new BranchOffices();
let parameters = new Parameters();
let hours = new Hours();

const app = new Vue({
    el: '#app'
});

document.addEventListener("DOMContentLoaded", function (event) {
    // bootstrapSelect.initialize();
    orders.initialize();
    messengers.initialize();
    addresses.initialize();
    customers.initialize();
    general.initialize();
    permissions.initialize();
    zones.initialize();
    branchOffice.initialize();
    parameters.initialize();
    hours.initialize();
});
