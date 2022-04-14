export default class Users {
    initialize() {
        this.test();
    }

    test() {
        Vue.component('example-component', require('../../../../../resources/js/components/exampleComponent.vue').default);
        console.log('----------------------------------------------UserModule test----------------------------------------------');
    }
}
