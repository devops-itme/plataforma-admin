require('./bootstrap');

window.Vue = require('vue');

import swal from 'sweetalert';
import bootstrapSelect from 'bootstrap-select';

import Messengers from './_messengers';
import Addresses from './_addresses';
import Customers from './_customers';
import Orders from './_orders';
import General from './_general';
import BranchOffices from './_branchOffice';

//Vue Components
Vue.component('example-component', require('./components/exampleComponent.vue'));

let messengers = new Messengers();
let addresses = new Addresses();
let customers = new Customers();
let orders = new Orders();
let general = new General();
let branchOffice = new BranchOffices();

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
    branchOffice.initialize();

});
