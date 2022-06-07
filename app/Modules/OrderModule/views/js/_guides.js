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
    pathname = window.location.pathname;

    constructor(guides = null, scope = '') {
        if (guides) {
            this.guides = guides;
        }
        this.scope = scope;
    }

    initialize() {
        if (this.pathname.includes('edit') && this.pathname.includes('guias')) {
            this.editGuide();
            return;
        }
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

        setRateId();
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

    async editGuide() {
        let boxes_element = document.getElementById("boxes");
        let updateGuideBtn = document.getElementById("update-guide-btn");
        let updateGuideForm = document.getElementById("update-guide-form");

        if (updateGuideBtn == null || boxes_element == null || updateGuideForm == null) {
            return;
        }
        
        let boxes = JSON.parse(boxes_element.value);
        this.boxes.boxes = boxes;

        this.sourceAddressHandler();
        this.boxes.initialize();

        updateGuideBtn.addEventListener('click', () => {
            boxes_element.value = JSON.stringify(this.boxes.boxes);
            updateGuideForm.submit();
        })
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

                const guideDetail = createBtn('primary', 'fa-folder-open','show-guide-btn');

                const guideEdit = createBtn('success', 'fa-edit', 'edit-guide-btn');

                const guideDelete = createBtn('danger', 'fa-trash-alt', 'remove-guide-btn');
                //Div
                const buttonsDiv = document.createElement("div");
                buttonsDiv.setAttribute(
                    "class",
                    "d-flex justify-content-around align-items-center flex-wrap flex-row"
                );
                this.scope == 'edition' && buttonsDiv.appendChild(guideEdit);
                buttonsDiv.appendChild(guideDetail);
                selectCell.appendChild(buttonsDiv);
                this.scope == 'edition' && buttonsDiv.appendChild(guideEdit);
                buttonsDiv.appendChild(guideDelete);
                selectCell.appendChild(buttonsDiv);

                tbody.appendChild(row);
            });
        }
        this.goToShowGuide();
        this.goToEditGuide();
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

    goToEditGuide() {
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


/*      goToShowGuide() {
        let showGuideBtn = document.getElementsByClassName("show-guide-btn");
        if (showGuideBtn == null) {
            return;
        }

        [].forEach.call(showGuideBtn, (btn) => {
            btn.addEventListener("click", async () => {
                let guide = btn.parentNode.parentNode.parentNode;
                let guide_id = guide.getAttribute('guide_id');
                let origin = window.location.origin;
                let response = true;
                if (this.scope == 'edition') {
                    response = await showResource('/guias/' + guide_id);
                }
                if (!response) {
                    window.location.replace(`${origin}/details/${guide_id}/show`);
                }
               
            });
        });
    } */ 



    goToShowGuide() {
        let showGuideBtn = document.getElementsByClassName("show-guide-btn");
        if (showGuideBtn == null) {
            return;
        }

        const showGuideBtnHandler = (btn) => {
            btn.addEventListener('click', async () => {
                let guide = btn.parentNode.parentNode.parentNode;
                let parent = guide.parentNode;
                let index = Array.prototype.indexOf.call(parent.children, guide);
                let guide_id = guide.getAttribute('guide_id');
                let response = true;
                let guia = await this.guides[index];
                
                if (this.scope == 'creation') {

                    
                $('#modalDestino').modal('show');
                
                
                document.querySelector('#modalDestino #description').value = guia.description;
                document.querySelector('#modalDestino #guide_address').value = guia.guide_address;
                console.log(guide_address);
                document.querySelector('#modalDestino #email_contact').value = guia.email_contact;
                document.querySelector('#modalDestino #rate').value = guia.rate;
                document.querySelector('#modalDestino #take_photo').value = guia.take_photo;
                document.querySelector('#modalDestino #sign').value = guia.sign;
                document.querySelector('#modalDestino #same_day_delivery').value = guia.same_day_delivery;
                document.querySelector('#modalDestino #contact').value = guia.contact;
                document.querySelector('#modalDestino #value').value = guia.value;
                document.querySelector('#modalDestino #phone_contact').value = guia.phone_contact;
                document.querySelector('#modalDestino #corp_value').value = guia.corp_value;
                document.querySelector('#modalDestino #boxes').value = guia.boxes;
                document.querySelector('#modalDestino #address_id').value = guia.address_id;
                
/*                 console.log(guia.boxes); */
                
                
                
                
                }
                if (!response) {
                    return;
                }
                if (this.scope == 'edition') {

                 this.guides.splice(index, 1);
                  window.location.replace(`${origin}/details/${guide_id}/show`);
                }
            });
        }

        [].forEach.call(showGuideBtn, (btn) => showGuideBtnHandler(btn));
    }
}