export default class General {
    initialize() {
        this.general();
    }

    general() {

        $('.btn-filter').click(() => $('.form-filter').toggle('slow'));
        // document.getElementById('alerta').onclick = function() {
        //     alert("button was clicked");
        //  };
         $(function () {
            $('[data-toggle="popover"]').popover()
          });

          $('.popover-dismiss').popover({
            trigger: 'focus'
          });

    }
}
