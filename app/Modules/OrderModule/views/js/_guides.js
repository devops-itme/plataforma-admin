//requests
import { requestGuide } from "./request/requestGuide.js";
import { requestGuides } from "./request/requestGuides.js";
import { requestValidateGuide } from "./request/requestValidateGuide.js";

//src
import { months } from "./src/months.js";

//functions
import { calculateRate } from "./calculateRate";
import { listener } from "./listener";

//classes
import Boxes from "./_boxes";

let destination_rate_id = null;
let source_rate_id = null;


export default class Guides {

    guides = [];
    constructor(guides = []) {
        if (guides.length != 0) {
            this.guides = guides;
        }
    }

    initialize() {
        this.listGuides();
        // this.listenRateVariables(true);
        // this.listenRateVariables(false);
    }

    async addGuide() {

        let guide_address = document.getElementById("guide_address");
        let contact = document.getElementById("contact");
        let phone_contact = document.getElementById("phone_contact");
        let email_contact = document.getElementById("email_contact");
        let same_day_delivery = document.getElementById("same_day_delivery");
        let sign = document.getElementById("sign");
        let take_photo = document.getElementById("take_photo");
        let guide_description = document.getElementById("guide_description");

        if (guide_address == null || contact == null || phone_contact == null || email_contact == null) {
            return;
        }
        if (same_day_delivery == null || sign == null || take_photo == null || guide_description == null) {
            return;
        }

        guide_address = guide_address.value;
        contact = contact.value;
        phone_contact = phone_contact.value;
        email_contact = email_contact.value;
        same_day_delivery = same_day_delivery.checked ? 1 : 0;
        sign = sign.checked ? 1 : 0;
        take_photo = take_photo.checked ? 1 : 0;
        guide_description = guide_description.value;

        let guide = {
            address_id: guide_address,
            contact,
            phone_contact,
            email_contact,
            same_day_delivery,
            sign,
            take_photo,
            description: guide_description
        };

        let response = await requestValidateGuide(JSON.stringify(guide));
        if (response.state != 200) {
            return alert(response.message);
        }
        this.guides.push(response.data)
        console.log(this.guides);
        this.listGuides();
    }

    async listGuides() {
        let tbody = document.querySelector("#guidesTable tbody");
        if (tbody == null) {
            return;
        }
        tbody.innerHTML = "";
        // let response = await requestGuides();
        // let data = response.data;
        let data = this.guides;
        if (data.length > 0) {
            [].forEach.call(data, (key) => {
                let row = tbody.insertRow();
                row.setAttribute("corp_value", key?.corp_value);
                row.setAttribute("boxes", key?.boxes);
                row.setAttribute("same_day_delivery", key?.same_day_delivery);
                row.setAttribute("value", key?.value);

                let idCell = row.insertCell(0);
                idCell.innerHTML = key.id ?? "";

                let contactCell = row.insertCell(1);
                contactCell.innerHTML = key.contact ?? "";

                let phoneCell = row.insertCell(2);
                phoneCell.innerHTML = key.phone_contact ?? "";

                let emailCell = row.insertCell(3);
                emailCell.innerHTML = key.email_contact ?? "";

                let rateCell = row.insertCell(4);
                rateCell.innerHTML = key.rate ?? "";

                let selectCell = row.insertCell(5);

                // //DELETE
                const guideDelete = document.createElement("button");
                guideDelete.setAttribute("class", "btn btn-icon btn-light-danger btn-sm mr-2 remove-guide-btn");
                guideDelete.setAttribute("type", "button");
                guideDelete.innerHTML = '<i class="fas fa-trash-alt"></i>';
                //Div
                const buttonsDiv = document.createElement("div");
                buttonsDiv.setAttribute(
                    "class",
                    "d-flex justify-content-around aling-items-center flex-wrap flex-row"
                );
                // buttonsDiv.appendChild(guideEdit);
                buttonsDiv.appendChild(guideDelete);
                selectCell.appendChild(buttonsDiv);

                tbody.appendChild(row);
            });
        }
        this.removeGuide();
        // this.editGuide();
        // this.listenGuideCheck();
    }

    removeGuide() {
        let removeGuideBtn = document.getElementsByClassName("remove-guide-btn");
        if (removeGuideBtn == null) {
            return;
        }

        const removeGuideBtnHandler = (btn) => {
            btn.addEventListener('click', () => {
                let guide = btn.parentNode.parentNode.parentNode;
                let parent = guide.parentNode;
                let index = Array.prototype.indexOf.call(parent.children, guide);
                this.guides.splice(index, 1);
                guide.remove();
            });
        }

        [].forEach.call(removeGuideBtn, (btn) =>  removeGuideBtnHandler(btn));
    }
    //////////////////////////////////
    listenGuideCheck() {
        const setValue = async () => {
            if (source_address.value == "") {
                return;
            }
            let total = 0;
            await [].forEach.call(guideCheck, async function (guide) {
                let corp_value =
                    guide.parentNode?.parentNode?.parentNode?.getAttribute(
                        "corp_value"
                    ) ?? 0;

                let boxes =
                    guide.parentNode?.parentNode?.parentNode?.getAttribute(
                        "boxes"
                    ) ?? [];
                let immediate_delivery =
                    guide.parentNode?.parentNode?.parentNode?.getAttribute(
                        "same_day_delivery"
                    ) ?? 0;
                boxes = JSON.parse(boxes);
                let source_rate = 0;
                await [].forEach.call(boxes, async (box) => {
                    let lbs = box?.weight;
                    let vol = box?.long * box?.broad * box?.high;
                    console.log(lbs);
                    let response = await requestCalculatePackingRates(
                        source_rate_id,
                        lbs,
                        vol,
                        immediate_delivery
                    );
                    if (response.state == 200) {
                        source_rate =
                            parseFloat(source_rate) + parseFloat(response.data);
                    }
                });

                let higher_rate =
                    parseFloat(source_rate) > parseFloat(corp_value)
                        ? parseFloat(source_rate)
                        : parseFloat(corp_value);
                guide.checked &&
                    (total = parseFloat(total) + parseFloat(higher_rate));
            });
            let full_tax = (total * tax_percentage.value) / 100;
            tax_total.setAttribute("value", full_tax);
            total = total + full_tax;
            order_value.setAttribute("value", total);
        };

        let source_address = document.getElementById("address");
        let guideCheck = document.getElementsByClassName("guideCheck");
        let order_value = document.getElementById("order_value");
        let tax_percentage = document.getElementById("tax_percentage");
        let tax_total = document.getElementById("tax_total");

        if (
            guideCheck == null ||
            order_value == null ||
            tax_percentage == null ||
            tax_total == null
        ) {
            return;
        }

        order_value.setAttribute("value", 0);
        setValue();

        [].forEach.call(guideCheck, function (guide) {
            guide.addEventListener("change", async () => {
                order_value.setAttribute("value", 0);
                setValue();
            });
        });

        source_address.addEventListener("change", async () => {
            if (source_address.value == "") {
                return;
            }
            let response = await requestSearchZone(source_address.value);

            if (response.state == 200) {
                source_rate_id = response.data?.zone_id;
            }
            order_value.setAttribute("value", 0);
            setValue();
        });
    }

    async listenRateVariables() {
        let rate = document.getElementById("rate");
        let zone = document.getElementById("zone_id");
        let same_day_delivery = document.getElementById("same_day_delivery");
        let source_address = document.getElementById("address");

        if (
            rate == null ||
            zone == null ||
            same_day_delivery == null ||
            source_address == null
        ) {
            return;
        }

        const action = async () => {
            if (zone.value == "") {
                return;
            }
            let response = await requestRate(zone.value);
            console.log("listener", response);
            if (response.state == 200) {
                destination_rate_id = response.data?.id;
            }
            calculateRate(edit, boxes, destination_rate_id);
        };

        listener(rate, action);
        listener(zone, action);
        listener(same_day_delivery, action, "click");
    }


    editGuide() {
        let guides = document.getElementsByClassName("btnEditGuide");
        if (guides == null) {
            return;
        }
        [].forEach.call(guides, (guide) => {
            guide.addEventListener("click", async () => {
                this.guideId = guide["id"].split("-")[1];
                let response = await requestGuide(this.guideId);
                let data = response.data;
                console.log(data)
                let branch_office = document.getElementById("branch_off_edit");
                branch_office.value = data.branch_office;
                let customer_address = document.getElementById("customer_address_edit").options;
                if (customer_address.length < 2) {
                    let option = document.createAttribute('option');
                    // option.name = guide.
                };
                [].forEach.call(customer_address, (key) => {
                    key.text == data.address_name
                        ? (key.selected = true)
                        : (key.selected = false);
                });
                // customer_address.value = data.customer_address;
                // let dispatched = document.getElementById("dispatched_edit").value = data.dispatched;
                // let address_name = document.getElementById("address_edit").value = data.address_name;
                // let address_lat = document.getElementById("lat_edit").value = data.address_lat;
                // let address_lng = document.getElementById("lng_edit").value = data.address_lng;
                let guide_description = (document.getElementById(
                    "address_description_edit"
                ).value = data.address_description);
                let concept = (document.getElementById("concept_edit").value =
                    data.concept);
                let rate = (document.getElementById("rate").value =
                    data.rate);
                let value = (document.getElementById("value_edit").value =
                    data.value);
                let corp_value = (document.getElementById(
                    "corp_value"
                ).value = data.corp_value);
                let customer_document_type = (document.getElementById(
                    "customer_document_type_edit"
                ).value = data.customer_document_type);
                let contact = (document.getElementById("contact_edit").value =
                    data.contact);
                let phone_contact = (document.getElementById(
                    "phone_contact_edit"
                ).value = data.phone_contact);
                let email_contact = (document.getElementById(
                    "email_contact_edit"
                ).value = data.email_contact);
                let invoice_contact = (document.getElementById(
                    "invoice_contact_edit"
                ).value = data.invoice_contact);
                let zones = document.getElementById("zone_id");
                [].forEach.call(zones, (key) => {
                    key.value == data.zone
                        ? (key.selected = true)
                        : (key.selected = false);
                });
                let same_day_delivery = document.getElementById(
                    "same_day_delivery"
                );
                data.same_day_delivery == 0
                    ? (same_day_delivery.checked = true)
                    : "";
                let sign = document.getElementById("sign_edit");
                data.sign == 0 ? (sign.checked = true) : "";
                let take_photo = document.getElementById("take_photo_edit");
                data.take_photo == 0 ? (take_photo.checked = true) : "";
                let boxes = JSON.parse(data.boxes);
                const BoxesClass = new Boxes(boxes, "box-container-edit");
                BoxesClass.instantiateBoxes();
                calculateRate(true, boxes, destination_rate_id);
                calculateRate(false, boxes, destination_rate_id);
                BoxesClass.addBox("add-box-btn-edit");
            });
        });
        this.updateGuide();
    }

    updateGuide() {
        let btnUpdateGuide = document.getElementById("btnUpdateGuide");
        if (btnUpdateGuide == null) {
            return;
        }
        btnUpdateGuide.addEventListener("click", async () => {
            let branch_off_edit =
                document.getElementById("branch_off_edit").value;
            // let dispatched = document.getElementById("dispatched_edit").value;
            let address_name = document.getElementById("customer_address_edit").value;
            // let address_lat = document.getElementById("lat_edit").value;
            // let address_lng = document.getElementById("lng_edit").value;
            let guide_description = document.getElementById(
                "address_description_edit"
            ).value;
            let concept = document.getElementById("concept_edit").value;
            let rate = document.getElementById("rate").value;
            let value = document.getElementById("value_edit").value;
            let corp_value = document.getElementById("corp_value").value;
            let customer_document_type = document.getElementById(
                "customer_document_type_edit"
            ).value;
            let contact = document.getElementById("contact_edit").value;
            let phone_contact =
                document.getElementById("phone_contact_edit").value;
            let email_contact =
                document.getElementById("email_contact_edit").value;
            let invoice_contact = document.getElementById(
                "invoice_contact_edit"
            ).value;
            let zone = document.getElementById("zone_id").value;
            let same_day_delivery = document.getElementById(
                "same_day_delivery"
            );
            same_day_delivery.checked == true
                ? (same_day_delivery = 1)
                : (same_day_delivery = 0);
            let sign = document.getElementById("sign_edit");
            sign.checked == true ? (sign = 1) : (sign = 0);
            let take_photo = document.getElementById("take_photo_edit");
            take_photo.checked == true ? (take_photo = 1) : (take_photo = 0);
            let customer_address = document.getElementById("customer_address_edit").value;

            //Boxes
            let ids = document.getElementsByName("id[]");
            let weights = document.getElementsByName("weight[]");
            let longs = document.getElementsByName("long[]");
            let broads = document.getElementsByName("broad[]");
            let highs = document.getElementsByName("high[]");
            let vol_weights = document.getElementsByName("vol_weight[]");
            let descriptions = document.getElementsByName("description[]");
            let boxArr = [];
            for (let i = 1; i < ids.length; i++) {
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
            formData.append("branch_office", branch_off_edit);
            // formData.append("dispatched", dispatched);
            formData.append("address_name", address_name);
            // formData.append("address_lat", address_lat);
            // formData.append("address_lng", address_lng);
            formData.append("guide_description", guide_description);
            formData.append("concept", concept);
            formData.append("rate", rate);
            formData.append("value", value);
            formData.append("corp_value", corp_value);
            formData.append("customer_document_type", customer_document_type);
            formData.append("contact", contact);
            formData.append("phone_contact", phone_contact);
            formData.append("email_contact", email_contact);
            formData.append("same_day_delivery", same_day_delivery);
            formData.append("sign", sign);
            formData.append("take_photo", take_photo);
            formData.append("invoice_contact", invoice_contact);
            formData.append("zone", zone);
            formData.append("customer_address", customer_address);

            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
            myHeaders.append("Accept", "application/json");
            myHeaders.append("Access-Control-Allow-Origin", "*");
            myHeaders.append(
                "Content-Type",
                "application/x-www-form-urlencoded"
            );
            myHeaders.append("Content-Type", "application/json");
            myHeaders.append("Content-Type", "multipart/form-data");
            myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify(Object.fromEntries(formData)),
            };

            let response = await this.sendDataToUpdate(
                this.guideId,
                requestOptions
            );
            if (response.state == 200) {
                correct(response.message);
                let modal = document.getElementById("modalEdit");
                modal.click();
                this.listGuides();
            } else {
                error("Error al crear la guía.");
                console.log("Error: " + response.error);
            }
        });
    }
}