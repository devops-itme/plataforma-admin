export default class Orders {
    initialize() {
        this.addbox();
        this.removeBox();
        this.searchCustomerData();
    }

    addbox() {

        let boxes = document.getElementById("add_box");
        let div = document.createElement("div");
        // console.log('gola');
        let x = 0;
        if (boxes == null) {
            return;
        }

        boxes.addEventListener("click", function (e) {
            e.preventDefault();
            x++
            div.className = 'row border mt-0 text-center';
            div.innerHTML = `
            <div class="col-1 py-4 border-right"><input type="number" name="id[]"class="form-control" min="0" value="0"></div>
            <div class="col-1 py-4 border-right"><input type="number" name="weight[]" class="form-control" min="0" value="0"></div>
            <div class="col-1 py-4 border-right"><input type="number" name="long[]" class="form-control" min="0" value="0"></div>
            <div class="col-1 py-4 border-right"><input type="number" name="broad[]"class="form-control" min="0" value="0"></div>
            <div class="col-1 py-4 border-right"><input type="number" name="high[]"class="form-control" min="0" value="0"></div>
            <div class="col-1 py-4 border-right"><input type="number" name="vol_weight[]"class="form-control" min="0" value="0"></div>
            <div class="col-3 py-4 border-right"><input type="text" name="description[]" class="form-control" placeholder="comertarios"></div>
            <div class="col-2 py-4">
                <div class="d-flex flex-row flex-wrap justify-content-center">
                    <a  class="btn btn-icon btn-light-danger btn-sm mr-2" data-tooltip title="Borrar">
                        <i class="fad fa-minus-circle"></i>
                    </a>
                    <a role="button" id="add_box" class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip title="Agregar">
                        <i class="fad fa-plus-circle"></i>
                    </a>
                </div>
            </div>`;
            document.getElementById('box_list').appendChild(div);

        });

    }

    removeBox() {
        let boxes = document.getElementById("remove_box");
        if (boxes == null) {
            return;
        }
        boxes.addEventListener("click", function (e) {
            e.preventDefault();
            document.getElementById('box_list').removeChild(a.parentNode);

        });


    }

    searchCustomerData(){
        let actualLocation = window.location['origin'];
        let btnSearch = document.getElementById("btnSearch");

        if(btnSearch == null){
            return;
        }
        btnSearch.addEventListener("click", async function(){
            var tbody = document.querySelector("#table_customers tbody");
            tbody.innerHTML = '';
            let inputValue = document.getElementById("search_customer").value;
            await fetch(actualLocation+"/search_customers?value="+inputValue)
                .then(response => response.json())
                .then(data => {
                    tbody.innerHTML = '';
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
                    } else {
                        let row = tbody.insertRow(0);
                        let cell = row.insertCell(0);
                        cell.innerHTML = "No se encontraron registros";
                        cell.colSpan = 3;
                        cell.setAttribute('class', 'text-center font-weight-bold');
                    }
                })
        });
    }

    selectCustomer(){
        // $('slc-Customers').selectpicker();
        let slcCustomer = document.getElementById("slc-Customers");
        let btnCustomerData = document.getElementById("btn-customerData");
        if (btnCustomerData == null) {
            return;
        }
        btnCustomerData.addEventListener("click", async function (e) {
            let actualLocation = window.location['origin'];

            await fetch(actualLocation+"/customer_data/"+slcCustomer.value)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("customer_modal_name").innerHTML = (data[0]['business_name'] == null) ? data[0]['get_user']['name'] : data[0]['business_name'];
                    document.getElementById("customer_modal_last_name").innerHTML = (data[0]['business_name'] == null) ? data[0]['get_user']['last_name'] : '----';
                    document.getElementById("customer_modal_contact").innerHTML = data[0]['contact'];
                    document.getElementById("customer_modal_branch_office").innerHTML = (data[1] != null) ? data[1]['name'] : '----';
                    document.getElementById("customer_modal_deparment").innerHTML = (data[2] != null) ? data[2]['name'] : '----';
                    $("#detailCustomer").modal('show');
                });
        })

    }
}
