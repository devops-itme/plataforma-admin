export default class Parameters {
    constructor() {
        this.id = '';
    }
    initialize() {
        this.loadParameterValues();
    }

    loadParameterValues(){
        let buttons = document.getElementsByName('btnShowParameters');
        if(buttons == null){
            return;
        }
        [].forEach.call(buttons, btn => {
            this.id = '';
            btn.addEventListener('click', async () => {
                this.id = btn['id'];
                let btnOpenModalCreate = document.getElementById("divCreateParameter");
                btnOpenModalCreate.className = 'col d-flex align-items-top justify-content-end';
                await this.renderParameterTable(this.id);
                this.storeParameterValue(this.id);
                this.editParameterValue();
                return;
            });
        });
    }

    async requestParameterValues(id){
        let response = {
            'state': 500
        };
        await fetch("/valor-parametros/"+id)
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    async renderParameterTable(id){
        let tbody = document.querySelector("#parameterValueTable tbody");
        tbody.innerHTML = '';

        let response = await this.requestParameterValues(id);
        let data = response.data;
        [].forEach.call(data, key => {
            let row = tbody.insertRow();

            let nameCell = row.insertCell(0);
            nameCell.innerHTML = key.name;
            let descriptionCell = row.insertCell(1);
            descriptionCell.innerHTML = key.description??'Sin descripción';
            let stateCell = row.insertCell(2);
            if(key.state == 1){
                stateCell.innerHTML =   '<span class="label label-inline label-light-success font-weight-bold">\
                                            Activo\
                                        </span>';
            } else {
                stateCell.innerHTML =   '<span class="label label-inline label-light-danger font-weight-bold">\
                                            Inactivo\
                                        </span>';
            }
            let selectCell = row.insertCell(3);
            const editBtn = document.createElement("button");
            editBtn.setAttribute('name', 'btnEditParameter');
            editBtn.setAttribute('class', 'btn btn-icon btn-light-success btn-sm mr-2');
            editBtn.setAttribute('data-toggle', 'modal');
            editBtn.setAttribute('data-target', '#modalEditParameter');
            editBtn.setAttribute('id', +key.id);
            editBtn.setAttribute('type', 'button');
            editBtn.innerHTML = '<i class="fas fa-edit"></i>';

            const deleteBtn = document.createElement("button");
            deleteBtn.onclick = function(){confirmDelete('parametros/delete/'+key.id)};
            deleteBtn.setAttribute('class', 'btn btn-icon btn-light-danger btn-sm mr-2');
            deleteBtn.setAttribute('type', 'button');
            deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';

            const buttonsDiv = document.createElement("div");
            buttonsDiv.setAttribute('class', 'd-flex justify-content-around aling-items-center flex-wrap flex-row');
            if(key.editable == 0){
                editBtn.setAttribute('disabled', true);
                deleteBtn.setAttribute('disabled', true);
            }
            buttonsDiv.appendChild(editBtn);
            buttonsDiv.appendChild(deleteBtn);
            selectCell.appendChild(buttonsDiv);

            tbody.appendChild(row);
        });
    }

    storeParameterValue(){
        let btnStore = document.getElementById("btnStoreParameter");
        if(btnStore == null){
            return;
        }
        btnStore.addEventListener('click', async () => {
            let form = document.getElementById("formCreateParameter");
            if(form == null){
                return;
            }
            let formData = new FormData(form);
            formData.append('parameter_id', this.id);
            let response = await this.requestStoreParameterValue(formData);
            if(response.state == 200){
                success(response.message);
                let modal = document.getElementById("modalCreateParameter");
                modal.click();
                location.reload();
                // this.renderParameterTable(this.id);
            } else {
                error(response.message);
            }
        });
    }

    async requestStoreParameterValue(formData){
        let response = {
            'state': 500
        };

        response = await fetch("/parametros", {
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            body: formData
        })
        return response.json();
    }

    editParameterValue(){
        let allEditBtns = document.getElementsByName('btnEditParameter');
        if(allEditBtns == null){
            return;
        }
        allEditBtns.forEach(btn => {
            btn.addEventListener('click', async () => {
                let response = await this.requestParameterData(btn['id']);
                let data = response.data;
                let name = document.getElementById("parameter_name");
                name.value = data.name;
                let description = document.getElementById("parameter_description");
                description.value = data.description;
                let state = document.getElementById("parameter_state_edit");
                data.state == 1 ? state.checked = true : '';

                this.updateParameterValue(btn['id']);
            });
        });
    }

    async requestParameterData(id){
        let response = {
            'state': 500
        };
        await fetch("valor-parametros/"+id+"/edit")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    updateParameterValue(id){
        let form = document.getElementById('formUpdateParameter');
        if(form == null){
            return;
        }
        let btnUpdate = document.getElementById("btnUpdateParameter");
        if(btnUpdate == null){
            return;
        }
        btnUpdate.addEventListener("click", async () => {
            let formData = new FormData(form);

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

            let response = await this.requestUpdateParameter(id, requestOptions);
            if(response.state == 200){
                success(response.message);
                let modal = document.getElementById("modalEditParameter");
                modal.click();
                location.reload();
            } else {
                error(response.message);
            }
        });
    }

    async requestUpdateParameter(id, requestOptions){
        let response = {
            'state': 500
        };
        await fetch("parametros/"+id, requestOptions)
            .then((response) => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

}
