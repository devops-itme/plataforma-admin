require('./bootstrap');

import swal from 'sweetalert';

import Messengers from './_messengers';
import Addresses from './_addresses';
import Customers from './_customers';

let messengers = new Messengers();
let addresses = new Addresses();
let customers = new Customers();

document.addEventListener("DOMContentLoaded", function (event) {
    messengers.initialize();
    addresses.initialize();
    customers.initialize();
});
