require('./bootstrap');

import Messengers from './_messengers';

let messengers = new Messengers();

document.addEventListener("DOMContentLoaded", function (event) {
    messengers.initialize();
});
