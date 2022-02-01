require('./bootstrap');

import swal from 'sweetalert';

import Messengers from './_messengers';
import Addresses from './_addresses';

let messengers = new Messengers();
let addresses = new Addresses();

document.addEventListener("DOMContentLoaded", function (event) {
    messengers.initialize();
    addresses.initialize();
});
