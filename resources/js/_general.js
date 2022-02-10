export default class General {
    initialize() {
        this.general();
    }

    general() {

        $('.btn-filter').click(() => $('.form-filter').toggle('slow'))

    }
}
