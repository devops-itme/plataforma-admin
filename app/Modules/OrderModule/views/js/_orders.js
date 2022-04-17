
let count = 0;
let boxes = [
    {
        number: 0,
        weight: 0,
        long: 0,
        broad: 0,
        high: 0,
        vol_weight: 0,
        description: '',
    }
];

export default class Orders {
    constructor(){
        this.guideId = '';
        this.boxes = boxes;
    }
    initialize() {
        this.instantiateBoxes();
        this.addbox();
        this.loadBranches();
        this.loadCustomerModal();
        this.removeBox();
        this.loadOrderNumber();
        this.saveGuides();
        this.createAddress();
        this.listGuides();
        this.porDespacharOndemand();
        this.porDespacharPackaging();
        this.customerAddresses();
        this.loadPickupHours();
        this.loadHoursInEditOrShow();
        this.importModal();
    }

    setInput() {
        const inputs = [
            'number[]',
            'weight[]',
            'long[]',
            'broad[]',
            'high[]',
            'vol_weight[]',
            'description[]',
        ];

        [].forEach.call(inputs, input => {
            let elements = document.getElementsByName(input);

            if (elements == null) {
                return
            }
            [].forEach.call(elements, el => {
                el.addEventListener('keyup', () => {

                    let parent = el.parentNode.parentNode.parentNode;
                    // console.log('parent', parent);
                    let children = el.parentNode.parentNode;
                    // console.log("children", children);

                    let index = Array.prototype.indexOf.call(parent.children, children);
                    // console.log('index', index);

                    let name = input.replace('[]', '');
                    // console.log('name', name);

                    // console.log('el', el.value);
                    boxes[index][name] = el.value;
                });
            });
        });
    }

    instantiateBoxes(container = 'box-container', boxes = this.boxes) {
        let boxContainer = document.getElementById(container);
        if (boxContainer == null) {
            return
        }
        boxContainer.innerHTML = ``;
        [].forEach.call(boxes, box => {
            let row = document.createElement("tr");
            row.className = `row border mt-0 text-center box-register col-md-13 "`;

            let numberCell = document.createElement("td");
            numberCell.className = `col-1 py-4 border-right`;
            numberCell.innerHTML = `<input type="number" name="id[]" class="form-control" min="0" value="${box.number}">`;
            row.appendChild(numberCell);

            let weightCell = document.createElement("td");
            weightCell.className = `col-1 py-4 border-right`;
            weightCell.innerHTML = `<input type="number" name="weight[]" class="form-control" min="0" value="${box.weight}">`;
            row.appendChild(weightCell);

            let longCell = document.createElement("td");
            longCell.className = `col-1 py-4 border-right`;
            longCell.innerHTML = `<input type="number" name="long[]" class="form-control" min="0" value="${box.long}">`;
            row.appendChild(longCell);

            let broadCell = document.createElement("td");
            broadCell.className = `col-1 py-4 border-right`;
            broadCell.innerHTML = `<input type="number" name="broad[]" class="form-control" min="0" value="${box.broad}">`;
            row.appendChild(broadCell);

            let highCell = document.createElement("td");
            highCell.className = `col-1 py-4 border-right`;
            highCell.innerHTML = `<input type="number" name="high[]" class="form-control" min="0" value="${box.high}">`;
            row.appendChild(highCell);

            let volWeightCell = document.createElement("td");
            volWeightCell.className = `col-1 py-4 border-right`;
            volWeightCell.innerHTML = `<input type="number" name="vol_weight[]" class="form-control" min="0" value="${box.vol_weight}">`;
            row.appendChild(volWeightCell);



            let descriptionCell = document.createElement("td");
            descriptionCell.className = `col-2 py-4 border-right`;
            descriptionCell.innerHTML = `<input type="text" name="description[]" class="form-control" placeholder="comentarios" value="${box.description}">`;
            row.appendChild(descriptionCell);

            let btnCell = document.createElement("td");
            btnCell.className = `col-1 py-4`;
            btnCell.innerHTML = ` <div class="d-flex flex-row flex-wrap justify-content-center"></div>`;

            let removeBoxBtn = document.createElement("a");
            removeBoxBtn.className = 'btn btn-icon btn-light-danger btn-sm mr-2 remove-box-btn';
            removeBoxBtn.id = `remove-box-btn`;
            removeBoxBtn.title = 'Borrar';
            removeBoxBtn.setAttribute('data-tooltip', '');
            removeBoxBtn.innerHTML = `<i class="fad fa-minus-circle"></i>`;

            btnCell.children[0].appendChild(removeBoxBtn);
            row.appendChild(btnCell);

            boxContainer.appendChild(row);
        });
        this.setInput();
        this.removeBox();
    };

    addbox(button = 'add-box-btn', boxes = this.boxes, container = 'box-container') {
        let addBoxBtn = document.getElementById(button);

        if (addBoxBtn == null) {
            return
        }

        addBoxBtn.addEventListener('click', () => {
            boxes.push({
                number: 0,
                weight: 0,
                long: 0,
                broad: 0,
                high: 0,
                vol_weight: 0,
                description: '',
            });
            this.instantiateBoxes(container, boxes);
        });
    }

    removeBox() {
        let removeBoxBtn = document.getElementsByClassName("remove-box-btn");
        if (removeBoxBtn == null) {
            return;
        }

        [].forEach.call(removeBoxBtn, function (btn) {
            btn.addEventListener('click', () => {

                let box = btn.parentNode.parentNode.parentNode;
                let parent = box.parentNode;
                let index = Array.prototype.indexOf.call(parent.children, box);
                boxes.splice(index, 1);
                box.remove();
            });
        });
    }

    loadCustomerModal(){
        let btnDetailCustomer = document.getElementById("btnDetailCustomer");
        if(btnDetailCustomer == null){
            return;
        }
        btnDetailCustomer.addEventListener('click', () => {
            this.searchCustomerData();
        });
    }

    async requestSearchCustomer(query) {
        let response = {
            'state': 500
        };
        await fetch("/search_customers?value=" + query)
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    searchCustomerData() {
        let btnSearch = document.getElementById("btnSearch");

        if (btnSearch == null) {
            return;
        }
        btnSearch.addEventListener('click', async () => {
            let tbody = document.querySelector("#table_customers tbody");
            tbody.innerHTML = '';
            let inputValue = document.getElementById("search_customer").value;
            tbody.innerHTML = '';
            let response = await this.requestSearchCustomer(inputValue);
            let data = response.data;
            let type = response.type;

            if (response.state != 200 || data.length == 0) {
                let row = tbody.insertRow(0);
                let cell = row.insertCell(0);
                cell.innerHTML = "No se encontraron registros";
                cell.colSpan = 3;
                cell.setAttribute('class', 'text-center font-weight-bold');
            }
            if (data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    let row = tbody.insertRow(i);

                    let idCell = row.insertCell(0);
                    idCell.innerHTML = type == 1 ? data[i].id : data[i].get_user.id;

                    let phoneCell = row.insertCell(1);
                    phoneCell.innerHTML = type == 1 ? data[i].phone : data[i].get_user.phone;

                    let tradenameCell = row.insertCell(2);
                    if(type == 1){
                        tradenameCell.innerHTML = (data[i].name != null) ? data[i].name + " " + data[i].last_name : data[i].get_customer.tradename;
                    } else {
                        tradenameCell.innerHTML = (data[i].name != null) ? data[i].name + " " + data[i].last_name : data[i].tradename;
                    }

                    let selectCell = row.insertCell(3);
                    const userCheck = document.createElement("input");
                    userCheck.setAttribute('class', 'btn btn-success customerCheck');
                    userCheck.setAttribute('type', 'radio');
                    userCheck.setAttribute('name', 'customerCheck');
                    userCheck.setAttribute('id', 'customerCheck');
                    userCheck.setAttribute('value', type == 1 ? data[i].id : data[i].get_user.id);
                    selectCell.appendChild(userCheck);

                    tbody.appendChild(row);
                }
            }
            this.selectCustomer();
        });
    }

    async requestSelectedCustomerData(query) {
        let response = {
            'state': 500
        };
        await fetch("/customer_data/" + query)
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    selectCustomer() {
        let allCustomerChecks = document.getElementsByClassName("customerCheck");
        for (let i = 0; i < allCustomerChecks.length; i++) {
            allCustomerChecks[i].addEventListener('click', async () => {
                let response = await this.requestSelectedCustomerData(allCustomerChecks[i].value);
                let data = response.data;
                document.getElementById("user_code").value = data[0]['id'];
                document.getElementById("user_name").value = data[0]['name'] ? data[0]['name'] + " " + data[0]['last_name'] : data[0]['get_customer']['tradename'];
                document.getElementById("user_contact").value = data[0]['get_customer']['contact'];
                let branches = data[1];
                let branchSlc = document.getElementById("user_branch_office");
                    branchSlc.selectedIndex = 0;
                    removeOptions(branchSlc);
                    for (let i = 0; i < branches.length; i++) {
                        let element = branches[i];
                        let branchOpt = '<option value="'+element.id+'"> '+element.name+' </option>';
                        branchSlc.insertAdjacentHTML('beforeend', branchOpt);
                    }
                let departments = data[2];
                let departmentSlc = document.getElementById("user_departments");
                    departmentSlc.selectedIndex = 0;
                    removeOptions(departmentSlc);
                    for (let i = 0; i < departments.length; i++) {
                        let element = departments[i];
                        let departmentOpt = '<option value="'+element.id+'"> '+element.name+' </option>';
                        departmentSlc.insertAdjacentHTML('beforeend', departmentOpt);
                    }
                document.getElementById("user_document_type").value = data[0]['get_document_type'] ? data[0]['get_document_type']['name'] : '';

                let modal = document.getElementById("detailCustomer");
                modal.click();
                if(document.getElementById("user_code").value != null){
                    this.customerAddresses(document.getElementById("user_code").value);
                }

            })
        }
    }

    async requestOrderNumber(){
        let response = {
            'state': 500
        };
        await fetch("/order_number")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    async loadOrderNumber(){
        let orderNumber = document.getElementById("order_number");
        if(orderNumber == null){
            return;
        }
        let response = await this.requestOrderNumber();
        orderNumber.setAttribute('value', response.data);
    }

    saveGuides(){
        let btnStoreGuide = document.getElementById("btnStoreGuide");
        if(btnStoreGuide == null){
            return;
        }
        btnStoreGuide.addEventListener('click', async () => {
            let branch_office = document.getElementById("branch_off").value;
            let transport_type = document.getElementById("trans_type").value;
            // let dispatched = document.getElementById("dispatched").value;
            let address_name = document.getElementById("address").value;
            // let address_lat = document.getElementById("lat").value;
            // let address_lng = document.getElementById("lng").value;
            let guide_description = document.getElementById("guide_description").value;
            let concept = document.getElementById("concept").value;
            let rate = document.getElementById("rate").value;
            let value = document.getElementById("value").value;
            let corp_value = document.getElementById("corp_value").value;
            let customer_document_type = document.getElementById("customer_document_type").value;
            let contact = document.getElementById("contact").value;
            let phone_contact = document.getElementById("phone_contact").value;
            let email_contact = document.getElementById("email_contact").value;
            let invoice_contact = document.getElementById("invoice_contact").value;
            let zone = document.getElementById("zone_id").value;
            let same_day_delivery = document.getElementById("same_day_delivery").value;
            let sign = document.getElementById("sign").value;
            let take_photo = document.getElementById("take_photo").value;
            // let customer_address = document.getElementById("customer_address").value;
            //Boxes
            let ids = document.getElementsByName('id[]');
            let weights = document.getElementsByName('weight[]');
            let longs = document.getElementsByName('long[]');
            let broads = document.getElementsByName('broad[]');
            let highs = document.getElementsByName('high[]');
            let vol_weights = document.getElementsByName('vol_weight[]');
            let descriptions = document.getElementsByName('description[]');
            let boxArr = [];
            for (let i = 0; i < ids.length; i++) {
                let individualBoxArr = {
                    'number' : ids[i].value,
                    'weight' : weights[i].value,
                    'long' : longs[i].value,
                    'broad' : broads[i].value,
                    'high' : highs[i].value,
                    'vol_weight' : vol_weights[i].value,
                    'description' : descriptions[i].value
                };
                boxArr.push(individualBoxArr);
            }
            let formData = new FormData();
            formData.append('boxes', JSON.stringify(boxArr));
            formData.append('branch_office', branch_office);
            formData.append('transport_type',transport_type);
            // formData.append('dispatched',dispatched);
            formData.append('address_name',address_name);
            // formData.append('address_lat',address_lat);
            // formData.append('address_lng',address_lng);
            formData.append('guide_description',guide_description);
            formData.append('concept',concept);
            formData.append('rate',rate);
            formData.append('value',value);
            formData.append('corp_value',corp_value);
            formData.append('customer_document_type',customer_document_type);
            formData.append('contact',contact);
            formData.append('phone_contact',phone_contact);
            formData.append('email_contact',email_contact);
            formData.append('invoice_contact',invoice_contact);
            formData.append('zone',zone);
            formData.append('same_day_delivery',same_day_delivery);
            formData.append('sign',sign);
            formData.append('take_photo',take_photo);
            // formData.append('customer_address',customer_address);

            let response = await this.sendGuideData(formData);
            if(response.state == 200){
                correct(response.message);
                let modal = document.getElementById("modalCreate");
                modal.click();
                this.listGuides();
            } else {
                error('Error al crear la guía.')
                console.log('Error: '+response.error);
            }
        })
    }

    async sendGuideData(formData){
        let response = {
            'state': 500
        };

        response = await fetch("/guias/store", {
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            body: formData
        })
        return response.json();
    }

    async listGuides(){
        let tbody = document.querySelector("#guidesTable tbody");
        if(tbody == null){
            return;
        }
        tbody.innerHTML = '';
        let response = await this.requestGuides();
        let data = response.data;
        if(data.length > 0){
            [].forEach.call(data, key => {
                let row = tbody.insertRow();

                let idCell = row.insertCell(0);
                idCell.innerHTML = key.id??'';

                let contactCell = row.insertCell(1);
                contactCell.innerHTML = key.contact??'';

                let phoneCell = row.insertCell(2);
                phoneCell.innerHTML = key.phone_contact??'';

                let emailCell = row.insertCell(3);
                emailCell.innerHTML = key.email_contact??'';

                let dateCell = row.insertCell(4);
                let allDate = new Date((key.created_at).split(' ')[0]);
                let month = allDate.getMonth();
                dateCell.innerHTML = allDate.getDate()+"-"+this.months(month)+"-"+allDate.getFullYear();

                let rateCell = row.insertCell(5);
                rateCell.innerHTML = key.rate??'';

                let stateCell = row.insertCell(6);
                stateCell.innerHTML = key.get_state?.name;
                let selectCell = row.insertCell(7);
                //CHECK
                const guideCheck = document.createElement("input");
                guideCheck.setAttribute('class', 'checkbox-inline mt-3')
                guideCheck.setAttribute('type', 'checkbox');
                guideCheck.setAttribute('name', 'guideCheck[]');
                guideCheck.setAttribute('value', key.id);
                let check = guideCheck.checked = true;
                key.order_id??check;
                //EDIT
                const guideEdit = document.createElement("button");
                guideEdit.setAttribute('class', 'btn btnEditGuide btn-icon btn-light-success btn-sm mr-2');
                guideEdit.setAttribute('data-toggle', 'modal');
                guideEdit.setAttribute('data-target', '#modalEdit');
                guideEdit.setAttribute('id', 'guide-'+key.id);
                guideEdit.setAttribute('type', 'button');
                guideEdit.innerHTML = '<i class="fas fa-edit"></i>';
                //DELETE
                const guideDelete = document.createElement("button");
                guideDelete.onclick = function(){deleteResource('/guias/'+key.id)};
                guideDelete.setAttribute('class', 'btn btn-icon btn-light-danger btn-sm mr-2');
                guideDelete.setAttribute('type', 'button');
                guideDelete.innerHTML = '<i class="fas fa-trash-alt"></i>';
                //Div
                const buttonsDiv = document.createElement("div");
                buttonsDiv.setAttribute('class', 'd-flex justify-content-around aling-items-center flex-wrap flex-row');
                buttonsDiv.appendChild(guideCheck);
                buttonsDiv.appendChild(guideEdit);
                buttonsDiv.appendChild(guideDelete);
                selectCell.appendChild(buttonsDiv);

                tbody.appendChild(row);
            });
        }
        this.editGuide();
    }

    async requestGuides(){
        let orderNumber = document.getElementsByName("order_number")[0]
        if(orderNumber == null){
            orderNumber = null;
        } else {
            orderNumber = orderNumber.value;

        }
        let path = window.location.pathname.split('/');
        let response = {
            'state': 500
        };
        await fetch("/guias?order="+orderNumber+"&path="+path)
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    editGuide(){
        let guides = document.getElementsByClassName("btnEditGuide");
        if(guides == null){
            return;
        }
        [].forEach.call(guides, guide => {
            guide.addEventListener('click', async () => {
                this.guideId = guide['id'].split('-')[1];
                let response = await this.requestGuide(this.guideId);
                let data = response.data;

                let branch_office = document.getElementById("branch_off_edit");
                branch_office.value = data.branch_office;
                let customer_address = document.getElementById('customer_address_edit').options;
                [].forEach.call(customer_address, key => {
                    key.text == data.address_name ? key.selected=true : key.selected=false;
                });
                // customer_address.value = data.customer_address;
                // let dispatched = document.getElementById("dispatched_edit").value = data.dispatched;
                // let address_name = document.getElementById("address_edit").value = data.address_name;
                // let address_lat = document.getElementById("lat_edit").value = data.address_lat;
                // let address_lng = document.getElementById("lng_edit").value = data.address_lng;
                let guide_description = document.getElementById("address_description_edit").value = data.guide_description;
                let concept = document.getElementById("concept_edit").value = data.concept;
                let rate = document.getElementById("rate_edit").value = data.rate;
                let value = document.getElementById("value_edit").value = data.value;
                let corp_value = document.getElementById("corp_value_edit").value = data.corp_value;
                let customer_document_type = document.getElementById("customer_document_type_edit").value = data.customer_document_type;
                let contact = document.getElementById("contact_edit").value = data.contact;
                let phone_contact = document.getElementById("phone_contact_edit").value = data.phone_contact;
                let email_contact = document.getElementById("email_contact_edit").value = data.email_contact;
                let invoice_contact = document.getElementById("invoice_contact_edit").value = data.invoice_contact;
                let zones = document.getElementById("zone_edit");
                [].forEach.call(zones, key => {
                    key.value == data.zone ? key.selected=true : key.selected=false;
                });
                let same_day_delivery = document.getElementById("same_day_delivery_edit");
                data.same_day_delivery == 1 ? same_day_delivery.checked = true : '';
                let sign = document.getElementById("sign_edit");
                data.sign == 1 ? sign.checked = true : '';
                let take_photo = document.getElementById("take_photo_edit");
                data.take_photo == 1 ? take_photo.checked = true : '';
                let boxes = JSON.parse(data.boxes);
                this.instantiateBoxes('box-container-edit', (boxes??this.boxes));
                this.addbox('add-box-btn-edit', (boxes??[]), 'box-container-edit');
            });
        })
        this.updateGuide();
    }

    async requestGuide(id){
        let response = {
            'state': 500
        };
        await fetch("/guias/"+id+"/edit")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    updateGuide(){
        let btnUpdateGuide = document.getElementById("btnUpdateGuide");
        if(btnUpdateGuide == null){
            return;
        }
        btnUpdateGuide.addEventListener("click", async () => {
            let branch_off_edit = document.getElementById("branch_off_edit").value;
            // let dispatched = document.getElementById("dispatched_edit").value;
            let address_name = document.getElementById("customer_address_edit").value;
            // let address_lat = document.getElementById("lat_edit").value;
            // let address_lng = document.getElementById("lng_edit").value;
            let guide_description = document.getElementById("address_description_edit").value;
            let concept = document.getElementById("concept_edit").value;
            let rate = document.getElementById("rate_edit").value;
            let value = document.getElementById("value_edit").value;
            let corp_value = document.getElementById("corp_value_edit").value;
            let customer_document_type = document.getElementById("customer_document_type_edit").value;
            let contact = document.getElementById("contact_edit").value;
            let phone_contact = document.getElementById("phone_contact_edit").value;
            let email_contact = document.getElementById("email_contact_edit").value;
            let invoice_contact = document.getElementById("invoice_contact_edit").value;
            let zone = document.getElementById("zone_edit").value;
            let same_day_delivery = document.getElementById("same_day_delivery_edit");
            same_day_delivery.checked == true ? same_day_delivery = 1 : same_day_delivery = 0;
            let sign = document.getElementById("sign_edit");
            sign.checked == true ? sign = 1 : sign = 0;
            let take_photo = document.getElementById("take_photo_edit");
            take_photo.checked == true ? take_photo = 1 : take_photo = 0;
            let customer_address = document.getElementById("customer_address_edit").value;

            //Boxes
            let ids = document.getElementsByName('id[]');
            let weights = document.getElementsByName('weight[]');
            let longs = document.getElementsByName('long[]');
            let broads = document.getElementsByName('broad[]');
            let highs = document.getElementsByName('high[]');
            let vol_weights = document.getElementsByName('vol_weight[]');
            let descriptions = document.getElementsByName('description[]');
            let boxArr = [];
            for (let i = 1; i < ids.length; i++) {
                let individualBoxArr = {
                    'number' : ids[i].value,
                    'weight' : weights[i].value,
                    'long' : longs[i].value,
                    'broad' : broads[i].value,
                    'high' : highs[i].value,
                    'vol_weight' : vol_weights[i].value,
                    'description' : descriptions[i].value
                };
                boxArr.push(individualBoxArr);
            }

            let formData = new FormData();
            formData.append('boxes', JSON.stringify(boxArr));
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
                myHeaders.append('Content-Type', "application/x-www-form-urlencoded");
                myHeaders.append('Content-Type', "application/json");
                myHeaders.append('Content-Type', "multipart/form-data");
                myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify(Object.fromEntries(formData))
            };

            let response = await this.sendDataToUpdate(this.guideId, requestOptions);
            if(response.state == 200){
                correct(response.message);
                let modal = document.getElementById("modalEdit");
                modal.click();
                this.listGuides();
            } else {
                error('Error al crear la guía.')
                console.log('Error: '+response.error);
            }
        });
    }

    async sendDataToUpdate(id, requestOptions){
        let response = {
            'state': 500
        };
        await fetch("/guias/"+id, requestOptions)
            .then((response) => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    loadBranches(){
        let branchesSlc = document.getElementsByName("branch_office");
        if(branchesSlc == null){
            return;
        }
        [].forEach.call(branchesSlc, async branch  => {
            branch.selectedIndex = 0;
            removeOptions(branch);

            let response = await this.requestBranches();
            let data = response.data;

            for (var i = 0; i < data.length; i++) {
                let element = data[i];
                let branchOffice = '<option value="'+element.id+'"> '+element.name+' </option>';
                branch.insertAdjacentHTML('beforeend', branchOffice);
            }
        });
    }

    async requestBranches(){
        let response = {
            'state': 500
        };
        await fetch("/allBranches")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    async customerAddresses(customerId = null){
        let slcAddresses = document.getElementsByName("customer_address");
        if(customerId == ''){
            return;
        }
        if(slcAddresses == null){
            return;
        }
        let response = await this.requestCustomerAddresses(customerId);
        if(response == null){
            return;
        }
        let data = response.data;

        [].forEach.call(slcAddresses, slcAddress => {
            if(!(typeof(parseInt(location.pathname.split('/')[2])) == 'number' && location.pathname.includes('edit'))){
                if(!slcAddress.id != 'order_customer_address'){
                    slcAddress.selectedIndex = 0;
                    removeOptions(slcAddress);

                    for (var i = 0; i < data.length; i++) {
                        let element = data[i];
                        let optAddress = '<option value="'+element.id+'" name="'+element.name+'"> '+element.name+' </option>';
                        slcAddress.insertAdjacentHTML('beforeend', optAddress);
                    }
                }
            }
        });
    }

    async requestCustomerAddresses(id = null){
        let route = window.location.pathname.split('/');
        if(document.getElementById("user_code") == null){
            return;
        }
        route.includes('edit') ? id = document.getElementById("user_code").value : '';
        let response = {
            'state': 500
        };
        await fetch("/customer_addresses/"+id)
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    createAddress(){
        let btnSaveAddress = document.getElementById("saveAddress");
        if(btnSaveAddress == null){
            return;
        }
        btnSaveAddress.addEventListener('click', async () => {
            let formData = new FormData();
            let description = document.getElementById("add_description").value;
            let address = document.getElementById("add_name").value;
            let lat = document.getElementById("add_lat").value;
            let lng = document.getElementById("add_lng").value;
            let user_id = document.getElementById("user_code").value;

            formData.append('user_id', user_id);
            formData.append('address', address);
            formData.append('lat', lat);
            formData.append('lng', lng);
            formData.append('description', description);
            formData.append('requestByJs', 1);

            let response = await this.sendAddressData(formData);
            if(response.state == 200){
                correct(response.message);
                let modal = document.getElementById("modalCreateAddress");
                modal.click();
                this.listGuides();
                this.customerAddresses(document.getElementById("user_code").value);
            } else {
                error('Error al crear la guía.')
                console.log('Error: '+response.error);
            }
        });
    }

    async sendAddressData(formData){
        let response = {
            'state': 500
        };

        response = await fetch("/direcciones", {
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            body: formData
        })
        return response.json();
    }

    months(month){
        const months = {
            0: 'Enero',
            1: 'Febrero',
            2: 'Marzo',
            3: 'Abril',
            4: 'Mayo',
            5: 'Junio',
            6: 'Julio',
            7: 'Agosto',
            8: 'Septiembre',
            9: 'Octubre',
            10: 'Noviembre',
            11: 'Diciembre'
        }
        return months[month];
    }
    async porDespacharOndemand(){

        let button = document.getElementById('porDespacharOndemand');
        if(button == null){
            return;
        }

        button.addEventListener("click", async () => {
            let order_id = button.value;
            let result = await confirmation("¿Esta seguro?", "Se pasara a orden a por despachar", 'info');
            if (result == true) {
                let req = await fetch(`/pordespachar/ondemand/${order_id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        accept: "application/json",
                    },
                });
                if (req.ok) {
                    correct("Estado actualizado!");
                    window.location.reload()
                } else {
                    error("Error al actualizar estado");

                }
            }
        });
    }

    async porDespacharPackaging(){

        let button = document.getElementById('porDespacharPackaging');
        if(button == null){
            return;
        }
        button.addEventListener("click", async () => {
            let order_id = button.value;
            let result = await porDespacharPackagingAlert();
            if (result == 3 || result == 7) {
                let formData = new FormData();
                formData.append('type', result);
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
                var data = {type: result};
                let req = await fetch(`/pordespachar/packaging/${order_id}`, requestOptions);
                if (req.ok) {
                    correct("Estado actualizado!");
                    window.location.reload()
                } else {
                    error("Error al actualizar estado");

                }
            }
        });
    }

    async loadPickupHours(){
        let date_selector = document.getElementById("schedule_date");
        if(date_selector == null){
            return;
        }
        let response = await this.requestPickupHours();
        let days = response.data;
        date_selector.addEventListener('change', () => {
            let day = this.getDayReference(date_selector.value);
            let day_data = days[day];

            let schedule_time_range = document.getElementById("schedule_time_range");
                schedule_time_range.selectedIndex = 0;
                removeOptions(schedule_time_range);

                if(day_data){
                    for (let i = 0; i < day_data.length; i++) {
                        let element = day_data[i];
                        let text = formatAMPM(element.init_time)+" - "+formatAMPM(element.end_time)
                        let option = '<option value="'+text+'" id="'+element.id+'"> '+text+' </option>';
                        schedule_time_range.insertAdjacentHTML('beforeend', option);
                    }
                    schedule_time_range.addEventListener('change', () => {
                        let id = schedule_time_range.options[schedule_time_range.selectedIndex].id;
                        let schedule_time = document.getElementById("schedule_time");
                        schedule_time.value = id;
                    })

                }

        });
    }

    async requestPickupHours(){
        let response = {
            'state': 500
        };
        await fetch("/getPickupHours")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    getDayReference(day){
        let days = [
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sábado',
            'Domingo'
        ];
        day = new Date(day).getDay();
        return days[day];
    }

    async loadHoursInEditOrShow(){
        let route = window.location.pathname;
        if(!(route.includes('ordenes') && route.includes('edit'))){
            return;
        }
        let date_selector = document.getElementById("schedule_date");
        let response = await this.requestPickupHours();
        let days = response.data;
        let day = this.getDayReference(date_selector.value);
        let day_data = days[day];

        if(day_data){
            let schedule_time_range = document.getElementById("schedule_time_range");
                schedule_time_range.selectedIndex = 0;
                removeOptions(schedule_time_range);

            for (let i = 0; i < day_data.length; i++) {
                let element = day_data[i];
                let text = formatAMPM(element.init_time)+" - "+formatAMPM(element.end_time)
                let option = '<option value="'+text+'" id="'+element.id+'"> '+text+' </option>';
                schedule_time_range.insertAdjacentHTML('beforeend', option);
            }
            schedule_time_range.addEventListener('change', () => {
                let id = schedule_time_range.options[schedule_time_range.selectedIndex].id;
                let schedule_time = document.getElementById("schedule_time");
                schedule_time.value = id;
            })
        }
    }

    async sendImportModalData(formData){
        let response = {
            'state': 500
        };

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
        
        response = await fetch(`/guias/import`, requestOptions)
        return response.json();
    }

    importModal(){
        let btnImportGuide = document.getElementById("btnImportGuide");
        if(btnImportGuide == null){
            return;
        }
        btnImportGuide.addEventListener('click', async () => {
            let formData = new FormData();
            let file = document.getElementById("file_import_guide");
            let order_id = document.getElementById("order_id").value;

            if(!file.files[0]){
               return error('Debe cargar el archivo para proceder con la importación')
            }
    
            formData.append('file', file.files[0]);
            formData.append('order_id', order_id);  
           
            let response = await this.sendImportModalData(formData);
            if(response.state == 200){
                correct(response.message);
                location.reload()
            } else {
                error('Error al importar guías.')
                console.log('Error: '+response.error);
            }
        });
    }


}

$("#tabListOrders").DataTable();
