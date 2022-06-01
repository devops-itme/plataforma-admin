require('./bootstrap');

window.Vue = require('vue');

import Users from '../../app/Modules/UserModule/views/js/_users';
import Messengers from '../../app/Modules/MessengerModule/views/js/_messengers';
import Addresses from '../../app/Modules/AddressModule/views/js/_addresses';
import Customers from '../../app/Modules/CustomerModule/views/js/_customers';
import Orders from '../../app/Modules/OrderModule/views/js/_orders';
import General from './_general';
import Permissions from '../../app/Modules/PermissionModule/views/js/_permissions';
import Zones from '../../app/Modules/ZoneModule/views/js/_zones';
import BranchOffices from '../../app/Modules/BranchOfficeModule/views/js/_branchOffice';
import Parameters from '../../app/Modules/ParametersModule/views/js/_parameters';
import Hours from '../../app/Modules/PickupHourModule/views/js/_hours';
import Plans from '../../app/Modules/PlanModule/views/js/_plans';
import Notifications from './_notifications';
import Rates from '../../app/Modules/RateModule/views/js/_rates';
import Guides from '../../app/Modules/OrderModule/views/js/_guides';

//Vue Components
Vue.component('deliveries-ondemand', require('./components/deliveries/deliveriesOndemand.vue').default);
Vue.component('example-component', require('./components/exampleComponent.vue').default);
Vue.component('department-tab', require('./components/department/department.vue').default);
Vue.component('status-matrix', require('./components/statusMatrix/statusMatrix.vue').default);
Vue.component('deliveries', require('./components/deliveries/deliveries.vue').default);
Vue.component('modal', require('./components/modal.vue').default);

let users = new Users();
let messengers = new Messengers();
let addresses = new Addresses();
let customers = new Customers();
let orders = new Orders();
let guides = new Guides();
let general = new General();
let permissions = new Permissions();
let zones = new Zones();
let rates = new Rates();
let branchOffice = new BranchOffices();
let parameters = new Parameters();
let hours = new Hours();
let plans = new Plans();
let notifications = new Notifications();
const app = new Vue({
    el: '#app'
});

document.addEventListener("DOMContentLoaded", function (event) {
    // bootstrapSelect.initialize();
    users.initialize();
    orders.initialize();
    guides.initialize();
    messengers.initialize();
    addresses.initialize();
    customers.initialize();
    general.initialize();
    permissions.initialize();
    zones.initialize();
    rates.initialize();
    branchOffice.initialize();
    parameters.initialize();
    hours.initialize();
    plans.initialize();
    notifications.initialize();
});
