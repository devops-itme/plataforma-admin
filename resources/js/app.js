require('./bootstrap');

import swal from 'sweetalert';
import bootstrapSelect from 'bootstrap-select';

import Messengers from './_messengers';
import Addresses from './_addresses';
import Customers from './_customers';
import Orders from './_orders';

let messengers = new Messengers();
let addresses = new Addresses();
let customers = new Customers();
let orders = new Orders();

document.addEventListener("DOMContentLoaded", function (event) {
    // bootstrapSelect.initialize();
    orders.initialize();
    messengers.initialize();
    addresses.initialize();
    customers.initialize();
});
