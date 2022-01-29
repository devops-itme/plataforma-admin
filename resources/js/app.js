require('./bootstrap');

import swal from 'sweetalert';

import Messengers from './_messengers';

let messengers = new Messengers();

document.addEventListener("DOMContentLoaded", function (event) {
    messengers.initialize();
});
