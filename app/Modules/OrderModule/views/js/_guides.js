//requests
import { requestGuide } from "./request/requestGuide.js";
import { requestValidateGuide } from "./request/requestValidateGuide.js";
import { requestCalculatePackingRates } from "./request/requestCalculatePackingRates";

//src
import { months } from "./src/months.js";

//functions
import { listener } from "./listener";

//classes
import Boxes from "./_boxes";
import { requestSearchZone } from "./request/requestSearchZone.js";
import { requestRate } from "./request/requestRate.js";

let destination_rate_id = null;
let source_rate_id = null;


export default class Guides {
    boxes = new Boxes();
    guides = [];
    rateId;
    constructor(guides = null, scope = 'creation') {
        if (guides) {
            this.guides = guides;
        }
        this.scope = scope;
    }

    initialize() {
        this.listGuides();
        this.boxes.initialize();
    }

    async sourceAddressHandler() {
        let guide_address = document.getElementById("guide_address");
        if (guide_address == null) {
            return;
        }

        const setRateId = async () => {
            this.boxes.rateId = null;
            let response = await requestSearchZone(guide_address.value);
            if (response.state == 200) {
                let zone_id = response.data.zone_id;
                let responseRate = await requestRate(zone_id);
                if (responseRate.state == 200 && response.data != null) {
                    this.boxes.rateId = responseRate.data.id;
                }
            }
            this.boxes.calculateRate();
        }

        guide_address.addEventListener('change', () => setRateId());
    }

    async addGuide() {
        if (this.scope == 'edition') {
            let guide_return_last_destination = document.getElementById("guide_return_last_destination");
            let return_last_destination = document.getElementById("return_last_destination");
            if (guide_return_last_destination == null || return_last_destination == null) {
                return;
            }
            guide_return_last_destination.value = return_last_destination.checked ? 1 : 0;
            return;
        }

        let guide_address = document.getElementById("guide_address");
        let contact = document.getElementById("contact");
        let phone_contact = document.getElementById("phone_contact");
        let email_contact = document.getElementById("email_contact");
        let same_day_delivery = document.getElementById("same_day_delivery");
        let sign = document.getElementById("sign");
        let take_photo = document.getElementById("take_photo");
        let guide_description = document.getElementById("guide_description");
        let value = document.getElementById("value");
        let corp_value = document.getElementById("corp_value");
        let guide_form = document.getElementById("guide_form");

        if (guide_address == null || contact == null || phone_contact == null || email_contact == null) {
            return;
        }
        if (same_day_delivery == null || sign == null || take_photo == null || guide_description == null) {
            return;
        }
        if (value == null || corp_value == null || guide_form == null) {
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
        value = value.value;
        corp_value = corp_value.value;
        let boxes = this.boxes.boxes;

        let guide = {
            address_id: guide_address,
            contact,
            phone_contact,
            email_contact,
            same_day_delivery,
            sign,
            take_photo,
            description: guide_description,
            value,
            corp_value,
            boxes
        };

        let response = await requestValidateGuide(JSON.stringify(guide));
        if (response.state != 200) {
            return alert(response.message);
        }
        this.guides.push(response.data);
        this.listGuides();
        guide_form.reset();
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
                row.setAttribute("guide_id", key?.id);
                row.setAttribute("corp_value", key?.corp_value);
                row.setAttribute("boxes", key?.boxes);
                row.setAttribute("same_day_delivery", key?.same_day_delivery);
                row.setAttribute("value", key?.value);

                let idCell = row.insertCell(0);
                idCell.innerHTML = key.id ?? "";

                let addressCell = row.insertCell(1);
                addressCell.innerHTML = key.address_name ?? "";

                let contactCell = row.insertCell(2);
                contactCell.innerHTML = key.contact ?? "";

                let phoneCell = row.insertCell(3);
                phoneCell.innerHTML = key.phone_contact ?? "";

                let emailCell = row.insertCell(4);
                emailCell.innerHTML = key.email_contact ?? "";

                let rateCell = row.insertCell(5);
                rateCell.innerHTML = key.rate ?? "";

                let selectCell = row.insertCell(6);

                const createBtn = (color, icon, className = '') => {
                    const btn = document.createElement("button");
                    btn.setAttribute("type", "button");
                    btn.setAttribute("class", `btn btn-icon btn-light-${color} btn-sm mr-2 ${className}`);
                    btn.innerHTML = `<i class="fas ${icon}"></i>`;
                    return btn;
                }

                const guideDetail = createBtn('primary', 'fa-folder-open',);

                const guideEdit = createBtn('success', 'fa-edit', 'edit-guide-btn');

                const guideDelete = createBtn('danger', 'fa-trash-alt', 'remove-guide-btn');
                //Div
                const buttonsDiv = document.createElement("div");
                buttonsDiv.setAttribute(
                    "class",
                    "d-flex justify-content-around align-items-center flex-wrap flex-row"
                );
                buttonsDiv.appendChild(guideDetail);
                this.scope == 'edition' && buttonsDiv.appendChild(guideEdit);
                buttonsDiv.appendChild(guideDelete);
                selectCell.appendChild(buttonsDiv);

                tbody.appendChild(row);
            });
        }
        this.editGuide();
        this.removeGuide();
    }

    removeGuide() {
        let removeGuideBtn = document.getElementsByClassName("remove-guide-btn");
        if (removeGuideBtn == null) {
            return;
        }

        const removeGuideBtnHandler = (btn) => {
            btn.addEventListener('click', async () => {
                let guide = btn.parentNode.parentNode.parentNode;
                let parent = guide.parentNode;
                let index = Array.prototype.indexOf.call(parent.children, guide);
                let guide_id = guide.getAttribute('guide_id');
                let response = true;
                if (this.scope == 'edition') {
                    response = await deleteResource('/guias/' + guide_id);
                }
                if (!response) {
                    return;
                }
                this.guides.splice(index, 1);
                guide.remove();
            });
        }

        [].forEach.call(removeGuideBtn, (btn) => removeGuideBtnHandler(btn));
    }

    editGuide() {
        let editGuideBtn = document.getElementsByClassName("edit-guide-btn");
        if (editGuideBtn == null) {
            return;
        }

        [].forEach.call(editGuideBtn, (btn) => {
            btn.addEventListener("click", async () => {
                let guide = btn.parentNode.parentNode.parentNode;
                let guide_id = guide.getAttribute('guide_id');
                let origin = window.location.origin;
                window.location.replace(`${origin}/guias/${guide_id}/edit`);
            });
        });
    }
}