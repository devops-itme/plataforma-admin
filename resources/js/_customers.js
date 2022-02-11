export default class Customers {
    initialize() {
        this.customerFeatures();
    }

    customerFeatures() {

        let typeSelected = document.getElementById("customer_type_edit");
        let option = document.getElementById("slc_type");
        let naturalCustomer = document.getElementById("naturalCustomer");
        let legalCustomer = document.getElementById("legalCustomer");
        if(option == null){
            return;
        }
        if(typeSelected != null){
            if (typeSelected.value == 1) {
                legalCustomer.className = 'd-none'
                naturalCustomer.className = 'col-md-7 d-flex px-0';
            } else if (typeSelected.value == 2) {
                naturalCustomer.className = 'd-none'
                legalCustomer.className = 'col-md-7 d-flex px-0'
            }
        }
        option.addEventListener('change', (event) => {
            if (option.value == 1) {
                legalCustomer.className = 'd-none'
                naturalCustomer.className = 'col-md-7 d-flex px-0';
            } else if (option.value == 2) {
                naturalCustomer.className = 'd-none'
                legalCustomer.className = 'col-md-7 d-flex px-0'
            }
        })
    }
}
