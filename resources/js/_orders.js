let count = 0;
let boxes = [
    {
        weight: 0,
        long: 0,
        broad: 0,
        high: 0,
        vol_weight: 0,
        description: '',
    }
];

export default class Orders {
    initialize() {
        this.instantiateBoxes();
        this.addbox();
        this.removeBox();
        this.loadCustomerModal();
        this.loadOrderNumber();
        this.saveGuides();
    }

    setInput() {
        const inputs = [
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

    instantiateBoxes() {
        let boxContainer = document.getElementById('box-container');
        if (boxContainer == null) {
            return
        }
        boxContainer.innerHTML = ``;
        [].forEach.call(boxes, box => {
            let row = document.createElement("tr");
            row.className = `row border mt-0 text-center box-register`;

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
            descriptionCell.className = `col-3 py-4 border-right`;
            descriptionCell.innerHTML = `<input type="text" name="description[]" class="form-control" placeholder="comertarios" value="${box.description}">`;
            row.appendChild(descriptionCell);

            let btnCell = document.createElement("td");
            btnCell.className = `col-3 py-4 border-right`;
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

    addbox() {
        let addBoxBtn = document.getElementById("add-box-btn");

        if (addBoxBtn == null) {
            return
        }

        addBoxBtn.addEventListener('click', () => {
            boxes.push({
                weight: 0,
                long: 0,
                broad: 0,
                high: 0,
                vol_weight: 0,
                description: '',
            });
            this.instantiateBoxes();
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
                document.getElementById("user_department").value = data[2] != null ? data[2]['name'] : '';
                document.getElementById("user_branch_office").value = data[1] != null ? data[1]['name'] : '';
                document.getElementById("user_document_type").value = data[0]['get_document_type']['name'];
                document.getElementById("id_branch_office").value = data[1] != null ? data[1].id : null;

                let modal = document.getElementById("detailCustomer");
                modal.click();
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
            let branch_office = document.getElementById("id_branch_office").value;
            let transport_type = document.getElementById("trans_type").value;
            let dispatched = document.getElementById("dispatched").value;
            let address_name = document.getElementById("address").value;
            let address_lat = document.getElementById("lat").value;
            let address_lng = document.getElementById("lng").value;
            let address_description = document.getElementById("address_description").value;
            let concept = document.getElementById("concept").value;
            let rate = document.getElementById("rate").value;
            let value = document.getElementById("value").value;
            let corp_value = document.getElementById("corp_value").value;
            let document_type_customes = document.getElementById("document_type_customes").value;
            let contact = document.getElementById("contact").value;
            let phone_contact = document.getElementById("phone_contact").value;
            let email_contact = document.getElementById("email_contact").value;
            let invoice_contact = document.getElementById("invoice_contact").value;
            let same_day_delivery = document.getElementById("same_day_delivery").value;
            let sign = document.getElementById("sign").value;
            let take_photo = document.getElementById("take_photo").value;

            let formData = new FormData();
            formData.append('branch_office', branch_office);
            formData.append('transport_type',transport_type);
            formData.append('dispatched',dispatched);
            formData.append('address_name',address_name);
            formData.append('address_lat',address_lat);
            formData.append('address_lng',address_lng);
            formData.append('address_description',address_description);
            formData.append('concept',concept);
            formData.append('rate',rate);
            formData.append('value',value);
            formData.append('corp_value',corp_value);
            formData.append('document_type_customes',document_type_customes);
            formData.append('contact',contact);
            formData.append('phone_contact',phone_contact);
            formData.append('email_contact',email_contact);
            formData.append('invoice_contact',invoice_contact);
            formData.append('same_day_delivery',same_day_delivery);
            formData.append('sign',sign);
            formData.append('take_photo',take_photo);

            let response = await this.sendGuideData(formData);
            if(response.state == 200){
                alert(response.message);
                let modal = document.getElementById("modalCreate");
                modal.click();
            } else {
                alert('Ha ocurrido un error al crear la guia.');
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
}
