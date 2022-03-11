export default class Parameters {
    initialize() {
        this.loadParameterValues();
    }

    parameterData(){
        let editButtons = document.getElementsByName('btnEditParameter');
        if(editButtons == null){
            return;
        }
        [].forEach.call(editButtons, btn  => {
            btn.addEventListener('click', async () => {
                let id = btn.id;
                let response = await this.requestParameterData(id);
                let data = response.data;
                let name = document.getElementById("parameter_name");
                name.value = data.name;
                let description = document.getElementById("parameter_description");
                description.value = data.description;
                let state = document.getElementById("parameter_state_edit");
                data.state == 1 ? state.checked = true : state.checked = false;
                // this.updateParameter(id);
            });
        });
    }

    async requestParameterData(id){
        let response = {
            'state': 500
        };
        await fetch("/parametros/"+id+"/edit")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    async updateParameter(id){
        let btnUpdate = document.getElementById("btnUpdateParameter");
        if(btnUpdate == null){
            return;
        }
        btnUpdate.addEventListener('click', async () => {
            let updateForm = document.getElementById("formUpdateParameter");
            let formData = new FormData(updateForm);
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
                let modal = document.getElementById("modalEditUser");
                modal.click();
                let requestData = await this.requestParameterValues(id);
                let data = requestData.data;
                this.renderParameterTable(data);
            } else {
                error(response.message);
            }
        });
    }

    async requestUpdateParameter(id, requestOptions){
        let response = {
            'state': 500
        };
        await fetch("/parametros/"+id+"/", requestOptions)
            .then((response) => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    loadParameterValues(){
        let buttons = document.getElementsByName('btnShowParameters');
        if(buttons == null){
            return;
        }
        [].forEach.call(buttons, btn => {
            btn.addEventListener('click', () => {
                this.renderParameterTable(btn['id']);
                this.storeParameterValue(btn['id']);
            });
        });
    }

    async requestParameterValues(id){
        let response = {
            'state': 500
        };
        await fetch("/parametros/"+id)
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
            buttonsDiv.appendChild(editBtn);
            buttonsDiv.appendChild(deleteBtn);
            selectCell.appendChild(buttonsDiv);

            tbody.appendChild(row);
        });
    }

    storeParameterValue(id){
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
            formData.append('parameter_id', id);
            let response = await this.requestStoreParameterValue(formData);
            if(response.state == 200){
                success(response.message);
                let modal = document.getElementById("modalCreateParameter");
                modal.click();
                this.renderParameterTable(id);
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

}
