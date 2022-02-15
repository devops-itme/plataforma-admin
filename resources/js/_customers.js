export default class Customers {
    initialize() {
        this.customerFeatures();
        this.saveBranchOffices();
        this.listBranchOffices();
    }

    customerFeatures() {

        let typeSelected = document.getElementById("customer_type_edit");
        let option = document.getElementById("slc_type");
        let naturalCustomer = document.getElementById("naturalCustomer");
        let legalCustomer = document.getElementById("legalCustomer");
        if(option == null){
            return;
        }
        if(typeSelected != null){
            if (typeSelected.value == 1) {
                legalCustomer.className = 'd-none'
                naturalCustomer.className = 'col-md-7 d-flex px-0';
            } else if (typeSelected.value == 2) {
                naturalCustomer.className = 'd-none'
                legalCustomer.className = 'col-md-7 d-flex px-0'
            }
        }
        option.addEventListener('change', (event) => {
            if (option.value == 1) {
                legalCustomer.className = 'd-none'
                naturalCustomer.className = 'col-md-7 d-flex px-0';
            } else if (option.value == 2) {
                naturalCustomer.className = 'd-none'
                legalCustomer.className = 'col-md-7 d-flex px-0'
            }
        })
    }

    saveBranchOffices(){
        let btnSendData = document.getElementById("saveBranchOffice");
        if(btnSendData == null){
            return;
        }
        btnSendData.addEventListener('click', async () => {
            let formData = new FormData();
            formData.append('branch_office_name', document.getElementById("branch_office_name").value);
            formData.append('branch_office_type', document.getElementById("branch_office_type").value);
            formData.append('branch_office_description', document.getElementById("branch_office_description").value);
            formData.append('branch_office_zone', document.getElementById("branch_office_zone").value);
            formData.append('branch_office_address', document.getElementById("branch_office_address").value);
            formData.append('branch_office_lat', document.getElementById("branch_office_lat").value);
            formData.append('branch_office_lng', document.getElementById("branch_office_lng").value);
            formData.append('branch_office_email', document.getElementById("branch_office_email").value);
            formData.append('branch_office_contact', document.getElementById("branch_office_contact").value);
            formData.append('branch_office_document_type', document.getElementById("branch_office_document_type").value);
            formData.append('branch_office_document_number', document.getElementById("branch_office_document_number").value);
            formData.append('branch_office_payment_method', document.getElementById("branch_office_payment_method").value);
            formData.append('branch_office_phone', document.getElementById("branch_office_phone").value);
            formData.append('branch_office_usage_mode', document.getElementById("branch_office_usage_mode").value);
            formData.append('branch_office_default', document.getElementById("branch_office_default").value);

            let response = await this.sendBranchOfficeData(formData);
            if(response['state'] == 200){
                alert('Sucursal creada exitosamente.');
                let modal = document.getElementById("modalCreate");
                modal.click();
            } else {
                alert('Ocurrió un error al crear la sucursal.');
                console.log('Error ocurrido: '+response['error']);
            }
        });
    }

    async sendBranchOfficeData(formData){
        let response = {
            'state': 500
        };

        response = await fetch("/sucursales/null/store", {
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            body: formData
        })
        return response.json();
    }

    async listBranchOffices(){
        let tbody = document.querySelector("#branch_offices_table tbody");
        tbody.innerHTML = '';
        let assignedBranchOffices = await this.requestBranchOffices();
        if(assignedBranchOffices['state'] == 200){
            let data = assignedBranchOffices['data'];
            if(data.length > 0){
                for (let i = 0; i < data.length; i++) {
                    let row = tbody.insertRow();

                    let nameCell = row.insertCell(0);
                    nameCell.innerHTML = data[i].name;

                    let typeCell = row.insertCell(1);
                    typeCell.innerHTML = data[i].get_type.name;

                    let zoneCell = row.insertCell(2);
                    zoneCell.innerHTML = data[i].get_zone.name;

                    let contactCell = row.insertCell(3);
                    contactCell.innerHTML = data[i].contact;

                    let stateCell = row.insertCell(4);
                    if(data[i].state == 1){
                        stateCell.innerHTML =   '<span class="label label-inline label-light-success font-weight-bold">\
                                                    Activo\
                                                </span>';
                    } else {
                        stateCell.innerHTML =   '<span class="label label-inline label-light-danger font-weight-bold">\
                                                    Inactivo\
                                                </span>';
                    }
                    let selectCell = row.insertCell(5);
                    const branchCheck = document.createElement("input");
                    branchCheck.setAttribute('class', 'checkbox-inline mt-3')
                    branchCheck.setAttribute('type', 'checkbox');
                    branchCheck.setAttribute('name', 'branchCheck');
                    branchCheck.setAttribute('value', data[i].id);
                    //Show button
                    const showBranch = document.createElement("button");
                    showBranch.setAttribute('class', 'btn btn-icon btn-light-primary btn-sm mr-2');
                    showBranch.setAttribute('type', 'button');
                    showBranch.innerHTML = '<i class="far fa-folder-open"></i>';
                    //Edit button
                    const branchEdit = document.createElement("button");
                    branchEdit.setAttribute('class', 'btn btn-icon btn-light-success btn-sm mr-2');
                    branchEdit.setAttribute('type', 'button');
                    branchEdit.innerHTML = '<i class="fas fa-edit"></i>';
                    //Delete button
                    const branchDelete = document.createElement("button");
                    branchDelete.setAttribute('class', 'btn btn-icon btn-light-danger btn-sm mr-2');
                    branchDelete.setAttribute('type', 'button');
                    branchDelete.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    //Div
                    const buttonsDiv = document.createElement("div");
                    buttonsDiv.setAttribute('class', 'd-flex justify-content-around aling-items-center flex-wrap flex-row');
                    buttonsDiv.appendChild(branchCheck);
                    buttonsDiv.appendChild(showBranch);
                    buttonsDiv.appendChild(branchEdit);
                    buttonsDiv.appendChild(branchDelete);
                    selectCell.appendChild(buttonsDiv);
                    tbody.appendChild(row);
                }
            }
        }
    }

    async requestBranchOffices(){
        let response = {
            'state': 500
        };
        await fetch("/unassigned_branch_offices")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }
}
