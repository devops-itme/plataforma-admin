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
]

export default class Orders {
    initialize() {
        this.instantiateBoxes();
        this.addbox();
        this.removeBox();
        this.searchCustomerData();
        // this.requestSearchCustomer();
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
            weightCell.innerHTML = `<input type="number" name="weight[]" class="form-control" min="0" value="0">`;
            row.appendChild(weightCell);

            let longCell = document.createElement("td");
            longCell.className = `col-1 py-4 border-right`;
            longCell.innerHTML = `<input type="number" name="long[]" class="form-control" min="0" value="0">`;
            row.appendChild(longCell);

            let broadCell = document.createElement("td");
            broadCell.className = `col-1 py-4 border-right`;
            broadCell.innerHTML = `<input type="number" name="broad[]" class="form-control" min="0" value="0">`;
            row.appendChild(broadCell);

            let highCell = document.createElement("td");
            highCell.className = `col-1 py-4 border-right`;
            highCell.innerHTML = `<input type="number" name="high[]" class="form-control" min="0" value="0">`;
            row.appendChild(highCell);

            let volWeightCell = document.createElement("td");
            volWeightCell.className = `col-1 py-4 border-right`;
            volWeightCell.innerHTML = `<input type="number" name="vol_weight[]" class="form-control" min="0" value="0">`;
            row.appendChild(volWeightCell);

            let descriptionCell = document.createElement("td");
            descriptionCell.className = `col-3 py-4 border-right`;
            descriptionCell.innerHTML = `<input type="text" name="description[]" class="form-control" placeholder="comertarios">`;
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
                box.remove();
            });
        });
    }

    async requestSearchCustomer(query){
        let actualLocation = window.location['origin'];
        let response = {
            'state' : 500
        };
        await fetch(actualLocation+"/search_customers?value="+query)
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    searchCustomerData(){
        let btnSearch = document.getElementById("btnSearch");

        if(btnSearch == null){
            return;
        }
        btnSearch.addEventListener('click', async () => {
            let tbody = document.querySelector("#table_customers tbody");
            tbody.innerHTML = '';
            let inputValue = document.getElementById("search_customer").value;
            tbody.innerHTML = '';
            let response = await this.requestSearchCustomer(inputValue);
            let data = response.data;
            if(response.state != 200 || data.length == 0){
                let row = tbody.insertRow(0);
                let cell = row.insertCell(0);
                cell.innerHTML = "No se encontraron registros";
                cell.colSpan = 3;
                cell.setAttribute('class', 'text-center font-weight-bold');
            }
            if(data.length > 0){
                for (let i = 0; i < data.length; i++) {
                    let row = tbody.insertRow(i);

                    let idCell = row.insertCell(0);
                    idCell.innerHTML = data[i]['name'] ? data[i]['id'] : data[i]['get_user']['id'];

                    let phoneCell = row.insertCell(1);
                    phoneCell.innerHTML = data[i]['name'] ? data[i]['phone'] : data[i]['get_user']['phone'];

                    let tradenameCell = row.insertCell(2);
                    tradenameCell.innerHTML = data[i]['name'] ? data[i]['name']+" "+data[i]['last_name'] : data[i]['tradename'];

                    let selectCell = row.insertCell(3);
                    const userCheck = document.createElement("input");
                    userCheck.setAttribute('class', 'btn btn-success customerCheck');
                    userCheck.setAttribute('type', 'radio');
                    userCheck.setAttribute('name', 'customerCheck');
                    userCheck.setAttribute('id', 'customerCheck');
                    userCheck.setAttribute('value', data[i]['name'] ? data[i]['id'] : data[i]['get_user']['id']);
                    selectCell.appendChild(userCheck);

                    tbody.appendChild(row);
                }
            }
            this.selectCustomer();
        });
    }

    async requestSelectedCustomerData(query){
        let actualLocation = window.location['origin'];
        let response = {
            'state' : 500
        };
        await fetch(actualLocation+"/customer_data/"+query)
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    selectCustomer(){
        let allCustomerChecks = document.getElementsByClassName("customerCheck");
        for (let i = 0; i < allCustomerChecks.length; i++) {
            allCustomerChecks[i].addEventListener('click', async () => {
                let response = await this.requestSelectedCustomerData(allCustomerChecks[i].value);
                let data = response.data;
                document.getElementById("user_code").value = data[0]['id'];
                document.getElementById("user_name").value = data[0]['name'] ? data[0]['name']+" "+data[0]['last_name'] : data[0]['get_customer']['tradename'];
                document.getElementById("user_contact").value = data[0]['get_customer']['contact'];
                document.getElementById("user_department").value = data[2] != null ? data[2]['name'] : '';
                document.getElementById("user_branch_office").value = data[1] != null ? data[1]['name'] : '';
                document.getElementById("user_document_type").value = data[0]['get_document_type']['name'];

                let modal = document.getElementById("detailCustomer");
                modal.click();
            })
        }
    }
}
