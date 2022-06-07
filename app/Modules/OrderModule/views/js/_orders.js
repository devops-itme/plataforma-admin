//requests
import { requestRate } from "./request/requestRate.js";
import { requestBranches } from "./request/requestBranches.js";
import { requestSearchZone } from "./request/requestSearchZone";
import { requestCalculatePackingRates } from "./request/requestCalculatePackingRates";
import { requestPickupHours } from "./request/requestPickupHours.js";
import { requestGetOrder } from "./request/requestGetOrder.js";


//functions
import { importModal } from "./importModal";
import { getDayReference } from "./src/getDayReference.js";

//classes
import Customer from "./_customer";
import Guides from "./_guides.js";



export default class Orders {

    order = null;
    pathname = window.location.pathname;
    constructor() {

    }

    async initialize() {
        if (this.pathname.includes('edit')) {
            let regex = /(\d+)/g;
            let order_id = this.pathname.match(regex);
            let response = await requestGetOrder(order_id);

            if (response.state == 200) {
                this.order = response.data;
            }
        }

        this.porDespacharOndemand();
        this.porDespacharPackaging();

        this.loadCustomer();
        this.loadGuides();



        this.loadBranches();

        this.createAddress();
        this.customerAddresses();
        this.loadPickupHours();
        this.loadHoursInEditOrShow();
        this.sendPushNotification();
        importModal();
    }

    loadCustomer() {
        let customer = document.getElementById("customer_id");
        let CustomerClass;
        if (customer != null) {
            let customer_id = customer.value;
            CustomerClass = new Customer(customer_id, this.order);
        } else {
            let customer = document.getElementById("customer");
            if (customer == null) {
                return;
            }
            let customer_id = customer.value;
            CustomerClass = new Customer(customer_id, this.order);
        }
        CustomerClass.initialize();
    }

    loadGuides() {
        let addGuideBtn = document.getElementById("add-guide-btn");
        if (addGuideBtn == null) {
            return;
        }

        let createOrderBtn = document.getElementById("create-order-btn");
        let order_form = document.getElementById("order-form");
        let guides = document.getElementById("guides");
        if (createOrderBtn == null || order_form == null || guides == null) {
            return;
        }

        let guidesArr = this.order?.get_guides;
        let scope = this.pathname.includes('edit') ? 'edition' : 'creation';
        let GuidesClass = new Guides(guidesArr, scope);
        GuidesClass.initialize();
        GuidesClass.sourceAddressHandler();

        addGuideBtn.addEventListener('click', async function () {
            GuidesClass.addGuide();
        });

        createOrderBtn.addEventListener('click', async function () {
            guides.value = JSON.stringify(GuidesClass.guides);
            order_form.submit();
        });
    }



    /////////////////////////////////////

    async sendPushNotification() {
        let state = document.getElementById("state");
        let notification_type = document.getElementById("notification_type");
        let fcm_token = document.getElementById("fcm_token");

        if (state == null || notification_type == null || fcm_token == null) {
            return;
        }

        state = state.value;
        notification_type = notification_type.value;
        fcm_token = fcm_token.value;

        let url = `${window.location.origin}/api/sendPushNotification?state=${state}&notification_type=${notification_type}&fcm_token=${fcm_token}`;
        await fetch(url)
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
            })
            .catch((e) => {
                console.log(e);
            });
    }


    loadBranches() {
        let branchesSlc = document.getElementsByName("branch_office");
        if (branchesSlc == null) {
            return;
        }
        [].forEach.call(branchesSlc, async (branch) => {
            branch.selectedIndex = 0;
            removeOptions(branch);

            let response = await requestBranches();
            let data = response.data;

            for (var i = 0; i < data.length; i++) {
                let element = data[i];
                let branchOffice =
                    '<option value="' +
                    element.id +
                    '"> ' +
                    element.name +
                    " </option>";
                branch.insertAdjacentHTML("beforeend", branchOffice);
            }
        });
    }

    async customerAddresses(customerId = null) {
        let slcAddresses = document.getElementsByName("customer_address");
        if (customerId == "") {
            return;
        }
        if (slcAddresses == null) {
            return;
        }
        let response = await this.requestCustomerAddresses(customerId);
        if (response == null) {
            return;
        }
        let data = response.data;

        [].forEach.call(slcAddresses, (slcAddress) => {
            if (
                !(
                    typeof parseInt(location.pathname.split("/")[2]) ==
                    "number" && location.pathname.includes("edit")
                )
            ) {
                if (!slcAddress.id != "order_customer_address") {
                    slcAddress.selectedIndex = 0;
                    removeOptions(slcAddress);

                    for (var i = 0; i < data.length; i++) {
                        let element = data[i];
                        let optAddress =
                            '<option value="' +
                            element.id +
                            '" name="' +
                            element.name +
                            '"> ' +
                            element.name +
                            " </option>";
                        slcAddress.insertAdjacentHTML("beforeend", optAddress);
                    }
                }
            }
        });
    }

    async requestCustomerAddresses(id = null) {
        let route = window.location.pathname.split("/");
        if (document.getElementById("user_code") == null) {
            return;
        }
        route.includes("edit")
            ? (id = document.getElementById("user_code").value)
            : "";
        let response = {
            state: 500,
        };
        await fetch("/customer_addresses/" + id)
            .then((response) => response.json())
            .then((data) => {
                response = data;
            })
            .catch((e) => (response.error = e));
        return response;
    }

    createAddress() {
        let btnSaveAddress = document.getElementById("saveAddress");
        if (btnSaveAddress == null) {
            return;
        }
        btnSaveAddress.addEventListener("click", async () => {
            let formData = new FormData();
            let description = document.getElementById("add_description").value;
            let address = document.getElementById("add_name").value;
            let lat = document.getElementById("add_lat").value;
            let lng = document.getElementById("add_lng").value;
            let user_id = document.getElementById("user_code").value;

            formData.append("user_id", user_id);
            formData.append("address", address);
            formData.append("lat", lat);
            formData.append("lng", lng);
            formData.append("description", description);
            formData.append("requestByJs", 1);

            let response = await this.sendAddressData(formData);
            if (response.state == 200) {
                correct(response.message);
                let modal = document.getElementById("modalCreateAddress");
                modal.click();
                this.listGuides();
                this.customerAddresses(
                    document.getElementById("user_code").value
                );
            } else {
                error("Error al crear la guía.");
                console.log("Error: " + response.error);
            }
        });
    }

    async sendAddressData(formData) {
        let response = {
            state: 500,
        };

        response = await fetch("/direcciones", {
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            body: formData,
        });
        return response.json();
    }

    async porDespacharOndemand() {
        let button = document.getElementsByClassName("porDespacharOndemand");
        if (button == null) {
            return;
        }
        [].forEach.call(button, function (btn) {
            btn.addEventListener("click", async () => {
                let order_id = btn.parentNode.parentNode;
                let result = await confirmation(
                    "¿Esta seguro?",
                    "Se pasara a orden a por despachar",
                    "info"
                );
                if (result == true) {
                    let req = await fetch(
                        `/pordespachar/ondemand/${order_id.id}`,
                        {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                                accept: "application/json",
                            },
                        }
                    )
                        .then(response => response.json());
                    if (req.state == 200) {
                        correct("Estado actualizado!");
                        window.location.reload();
                    } else {
                        console.log(req);
                        error("Error al actualizar estado");
                    }
                }
            });
        });
    }

    async porDespacharPackaging() {
        let button = document.getElementsByClassName("porDespacharPackaging");
        if (button == null) {
            return;
        }
        [].forEach.call(button, function (btn) {
            btn.addEventListener("click", async () => {
                let order_id = btn.parentNode.parentNode;
                let result = await porDespacharPackagingAlert();
                if (result == 3 || result == 7) {
                    let formData = new FormData();
                    formData.append("type", result);
                    let token = document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content");
                    let myHeaders = new Headers();
                    myHeaders.append("accept", "application/json");
                    myHeaders.append("Access-Control-Allow-Origin", "*");
                    myHeaders.append("X-CSRF-TOKEN", token);

                    let requestOptions = {
                        method: "POST",
                        headers: myHeaders,
                        body: formData,
                    };
                    var data = { type: result };
                    let req = await fetch(
                        `/pordespachar/packaging/${order_id.id}`,
                        requestOptions
                    )
                        .then(response => response.json());
                    console.log(req);
                    if (req.state == 200) {
                        correct("Estado actualizado!");
                        // window.location.reload();
                    } else {
                        error("Error al actualizar estado");
                    }
                }
            });
        });
    }

    async loadPickupHours() {
        let date_selector = document.getElementById("schedule_date");
        if (date_selector == null) {
            return;
        }
        let response = await requestPickupHours();
        let days = response.data;
        date_selector.addEventListener("change", () => {
            let day = getDayReference(date_selector.value);
            let day_data = days[day];

            let schedule_time_range = document.getElementById(
                "schedule_time_range"
            );
            schedule_time_range.selectedIndex = 0;
            removeOptions(schedule_time_range);

            if (day_data) {
                for (let i = 0; i < day_data.length; i++) {
                    let element = day_data[i];
                    let text =
                        formatAMPM(element.init_time) +
                        " - " +
                        formatAMPM(element.end_time);
                    let option =
                        '<option value="' +
                        text +
                        '" id="' +
                        element.id +
                        '"> ' +
                        text +
                        " </option>";
                    schedule_time_range.insertAdjacentHTML("beforeend", option);
                }
                schedule_time_range.addEventListener("change", () => {
                    let id = schedule_time_range.options[schedule_time_range.selectedIndex].id;
                    let schedule_time = document.getElementById("schedule_time");
                    if (schedule_time == null) {
                        return;
                    }
                    schedule_time.value = id;
                });
            }
        });
    }

    async loadHoursInEditOrShow() {
        let route = window.location.pathname;
        if (!(route.includes("create") && route.includes("edit"))) {
            return;
        }
        let date_selector = document.getElementById("schedule_date");
        let response = await this.requestPickupHours();
        let days = response.data;
        let day = getDayReference(date_selector.value);
        let day_data = days[day];

        if (day_data) {
            let schedule_time_range = document.getElementById(
                "schedule_time_range"
            );
            schedule_time_range.selectedIndex = 0;
            removeOptions(schedule_time_range);

            for (let i = 0; i < day_data.length; i++) {
                let element = day_data[i];
                let text =
                    formatAMPM(element.init_time) +
                    " - " +
                    formatAMPM(element.end_time);
                let option =
                    '<option value="' +
                    text +
                    '" id="' +
                    element.id +
                    '"> ' +
                    text +
                    " </option>";
                schedule_time_range.insertAdjacentHTML("beforeend", option);
            }
            schedule_time_range.addEventListener("change", () => {
                let id =
                    schedule_time_range.options[
                        schedule_time_range.selectedIndex
                    ].id;
                let schedule_time = document.getElementById("schedule_time");
                schedule_time.value = id;
            });
        }
    }

}
