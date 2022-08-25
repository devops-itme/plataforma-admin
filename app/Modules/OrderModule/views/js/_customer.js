import { requestCustomerData } from "./request/requestCustomerData";

export default class Customer {

    constructor(customer, order) {
        this.user_id = customer;
        if (order) {
            this.order = order;
        }
    }

    async initialize() {
        if (this.user_id) {
            let customer_id = this.user_id;
            let response = await requestCustomerData(customer_id);
            if (response.state != 200) {
                return;
            }

            this.user = response.data.customer;
            this.branches = response.data.branches;
            this.departments = response.data.departments;
            this.addresses = response.data.addresses;

            let address = document.getElementById("address");
            let guide_address = document.getElementById("guide_address");
            loadSelect(this.addresses, address, this.order?.address_id);
            loadSelect(this.addresses, guide_address);

            let user_departments = document.getElementById("user_departments");
            loadSelect(this.departments, user_departments, this.order?.department_id);

            let user_branch_office = document.getElementById("user_branch_office");
            loadSelect(this.branches, user_branch_office, this.order?.branch_office);
        }
        this.changeCustomerId();
    }

    changeCustomerId() {
        let customer = document.getElementById("customer");

        if (customer == null) {
            return;
        }

        $('.select2-customers').on('change', async function (e) {
            let customer_id = customer.value;

            let response = await requestCustomerData(customer_id);
            if (response.state != 200) {
                return;
            }
            this.user = response.data.customer;
            this.branches = response.data.branches;
            this.departments = response.data.departments;
            this.addresses = response.data.addresses;

            let address = document.getElementById("address");
            let guide_address = document.getElementById("guide_address");
            loadSelect(this.addresses, address);
            loadSelect(this.addresses, guide_address);

            let user_departments = document.getElementById("user_departments");
            loadSelect(this.departments, user_departments);

            let user_branch_office = document.getElementById("user_branch_office");
            loadSelect(this.branches, user_branch_office);
        });
    }

}

const loadSelect = (data, element, selected = null) => {
    if (element == null) {
        return;
    }
    element.innerHTML = '<option value="" disabled selected>Seleccione </option>';
    [].forEach.call(data, async (item) => {
        let option = document.createElement('option');
        option.value = item.id;
        option.label = item.name;
        option.selected = item.id == selected;
        element.appendChild(option);
    });
}
