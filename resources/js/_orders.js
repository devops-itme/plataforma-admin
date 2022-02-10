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
        this.selectCustomer();
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
