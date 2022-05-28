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

    constructor() {

    }

    async initialize() {
        let pathname = window.location.pathname;
        if (pathname.includes('edit')) {
            let regex = /(\d+)/g;
            let order_id = pathname.match(regex);
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

        this.saveGuides();
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
        if (createOrderBtn == null) {
            return;
        }
        let guides = document.getElementById("guides");
        if (guides == null) {
            return;
        }
        let guidesArr = this.order?.get_guides;
        let GuidesClass = new Guides(guidesArr);
        GuidesClass.initialize();
        GuidesClass.sourceAddressHandler();
        addGuideBtn.addEventListener('click', async function () {
            GuidesClass.addGuide();
        });
        createOrderBtn.addEventListener('click', async function () {
            guides.value = JSON.stringify(GuidesClass.guides);
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

    saveGuides() {
        let btnStoreGuide = document.getElementById("btnStoreGuide");
        if (btnStoreGuide == null) {
            return;
        }
        btnStoreGuide.addEventListener("click", async () => {
            let branch_office = document.getElementById("branch_off").value;
            let transport_type = document.getElementById("trans_type").value;
            // let dispatched = document.getElementById("dispatched").value;
            let address_name = document.getElementById("address").value;
            // let address_lat = document.getElementById("lat").value;
            // let address_lng = document.getElementById("lng").value;
            let guide_description =
                document.getElementById("guide_description").value;
            let concept = document.getElementById("concept").value;
            let rate = document.getElementById("rate").value;
            let value = document.getElementById("value").value;
            let corp_value = document.getElementById("corp_value").value;
            let customer_document_type = document.getElementById(
                "customer_document_type"
            ).value;
            let contact = document.getElementById("contact").value;
            let phone_contact = document.getElementById("phone_contact").value;
            let email_contact = document.getElementById("email_contact").value;
            let invoice_contact =
                document.getElementById("invoice_contact").value;
            let zone = document.getElementById("zone_id").value;
            let same_day_delivery =
                document.getElementById("same_day_delivery").value;
            let sign = document.getElementById("sign").value;
            let take_photo = document.getElementById("take_photo").value;
            // let customer_address = document.getElementById("customer_address").value;
            //Boxes
            let ids = document.getElementsByName("id[]");
            let weights = document.getElementsByName("weight[]");
            let longs = document.getElementsByName("long[]");
            let broads = document.getElementsByName("broad[]");
            let highs = document.getElementsByName("high[]");
            let vol_weights = document.getElementsByName("vol_weight[]");
            let descriptions = document.getElementsByName("description[]");
            let boxArr = [];
            for (let i = 0; i < ids.length; i++) {
                let individualBoxArr = {
                    number: ids[i].value,
                    weight: weights[i].value,
                    long: longs[i].value,
                    broad: broads[i].value,
                    high: highs[i].value,
                    vol_weight: vol_weights[i].value,
                    description: descriptions[i].value,
                };
                boxArr.push(individualBoxArr);
            }
            let formData = new FormData();
            formData.append("boxes", JSON.stringify(boxArr));
            formData.append("branch_office", branch_office);
            formData.append("transport_type", transport_type);
            // formData.append('dispatched',dispatched);
            formData.append("address_name", address_name);
            // formData.append('address_lat',address_lat);
            // formData.append('address_lng',address_lng);
            formData.append("guide_description", guide_description);
            formData.append("concept", concept);
            formData.append("rate", rate);
            formData.append("value", value);
            formData.append("corp_value", corp_value);
            formData.append("customer_document_type", customer_document_type);
            formData.append("contact", contact);
            formData.append("phone_contact", phone_contact);
            formData.append("email_contact", email_contact);
            formData.append("invoice_contact", invoice_contact);
            formData.append("zone", zone);
            formData.append("same_day_delivery", same_day_delivery);
            formData.append("sign", sign);
            formData.append("take_photo", take_photo);
            // formData.append('customer_address',customer_address);

            let response = await this.sendGuideData(formData);
            if (response.state == 200) {
                correct(response.message);
                let modal = document.getElementById("modalCreate");
                modal.click();
                this.initialize();
            } else {
                error("Error al crear la guía.");
                console.log("Error: " + response.error);
            }
        });
    }

    async sendGuideData(formData) {
        let response = {
            state: 500,
        };

        response = await fetch("/guias/store", {
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            method: "POST",
            body: formData,
        });
        return response.json();
    }

    async sendDataToUpdate(id, requestOptions) {
        let response = {
            state: 500,
        };
        await fetch("/guias/" + id, requestOptions)
            .then((response) => response.json())
            .then((data) => {
                response = data;
            })
            .catch((e) => (response.error = e));
        return response;
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
        console.log(11111);
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
                    );
                    if (req.ok) {
                        correct("Estado actualizado!");
                        window.location.reload();
                    } else {
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
                    );
                    if (req.ok) {
                        correct("Estado actualizado!");
                        window.location.reload();
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
                    console.log(1)

                    let id =
                        schedule_time_range.options[
                            schedule_time_range.selectedIndex
                        ].id;
                    let schedule_time =
                        document.getElementById("schedule_time");
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
