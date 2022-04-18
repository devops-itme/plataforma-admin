export default class Customers {
    constructor(){
        this.branchId = '';
        this.userId = '';
    }
    initialize() {
        this.customerFeatures();
        this.saveCustomer();
        this.saveBranchOffices();
        this.listBranchOffices();
        this.updateBranchOffice();
        this.saveUser();
        this.listUsers();
        this.updateUser();
    }

    saveCustomer(){
        let customerForm = document.getElementById("storeCustomerForm");
        if(customerForm == null){
            return;
        }
        let customerBtn = document.getElementById("storeCustomerBtn");
        if(customerBtn == null){
            return;
        }
        customerBtn.addEventListener("click", async () => {

            let formData = new FormData(storeCustomerForm);
            let branchesCheck = document.getElementsByName('branchCheck');
            let departmentsCheck = document.getElementsByName("departments[]");
            let branchArr = [];
            let departmentsArr = [];
            branchesCheck.forEach((e) => {
                e.checked && branchArr.push(e.value);
            });
            departmentsCheck.forEach((e) => {
                e.checked && departmentsArr.push(e.value);
            });
            formData.append('branchCheck', branchArr);
            formData.append('departments', departmentsArr);
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
                console.log(token)
            let myHeaders = new Headers();
                myHeaders.append("Accept", "application/json");
                myHeaders.append("Access-Control-Allow-Origin", "*");
                myHeaders.append('Content-Type', "application/x-www-form-urlencoded");
                myHeaders.append('Content-Type', "application/json");
                myHeaders.append('Content-Type', "multipart/form-data");
                myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "POST",
                headers: myHeaders,
                body: JSON.stringify(Object.fromEntries(formData))
            };
            let response = await this.storeCustomer(requestOptions);
            console.log(response);
            if(response.state == 200){
                correct(response.message);
                window.location.replace("/clientes");
            } else {
                error(response.message);
                console.log(response.error);
            }
        });
    }

    async storeCustomer(requestOptions){
        let response = {
            'state': 500
        };
        await fetch("/clientes/store", requestOptions)
            .then((response) => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    customerFeatures() {

        let typeSelected = document.getElementById("customer_type_edit");
        let option = document.getElementById("slc_type");
        let naturalCustomer = document.getElementById("naturalCustomer");
        let legalCustomer = document.getElementById("legalCustomer");
        let birth_date = document.getElementById("birth_date");
        let password = document.getElementById("passwordDiv");
        let r_password = document.getElementById("r_passwordDiv");
        if(option == null){
            return;
        }
        if(typeSelected != null){
            if (typeSelected.value == 1) {
                legalCustomer.className = 'd-none'
                naturalCustomer.className = 'col-md-6 d-flex px-0';
                birth_date.className = 'form-group py-3 m-0 col-md-4';
            } else if (typeSelected.value == 2) {
                naturalCustomer.className = 'd-none'
                legalCustomer.className = 'col-md-3 d-flex px-0'
                birth_date.className = 'form-group py-3 m-0 col-md-3';
            }
        }
        option.addEventListener('change', (event) => {
            if (option.value == 1) {
                legalCustomer.className = 'd-none';
                naturalCustomer.className = 'col-md-6 d-flex px-0';
                birth_date.className = 'form-group py-3 m-0 col-md-4';
                password.className = 'form-group py-3 m-0 col-md-4';
                r_password.className = 'form-group py-3 m-0 col-md-4';
            } else if (option.value == 2) {
                naturalCustomer.className = 'd-none';
                legalCustomer.className = 'col-md-3 d-flex px-0';
                birth_date.className = 'form-group py-3 m-0 col-md-3';
                password.className = 'form-group py-3 m-0 col-md-6';
                r_password.className = 'form-group py-3 m-0 col-md-6';
            }
        })
    }

    saveBranchOffices(){
        let btnSendData = document.getElementById("saveBranchOffice");
        if(btnSendData == null){
            return;
        }

        btnSendData.addEventListener('click', async () => {
            let branch_office_name = document.getElementById("branch_office_name"),
                branch_office_type = document.getElementById("branch_office_type"),
                branch_office_description = document.getElementById("branch_office_description"),
                branch_office_zone = document.getElementById("branch_office_zone"),
                branch_office_address = document.getElementById("branch_office_address"),
                branch_office_lat = document.getElementById("branch_office_lat"),
                branch_office_lng = document.getElementById("branch_office_lng"),
                branch_office_email = document.getElementById("branch_office_email"),
                branch_office_contact = document.getElementById("branch_office_contact"),
                branch_office_document_type = document.getElementById("branch_office_document_type"),
                branch_office_document_number = document.getElementById("branch_office_document_number"),
                branch_office_payment_method = document.getElementById("branch_office_payment_method"),
                branch_office_phone = document.getElementById("branch_office_phone"),
                branch_office_plan = document.getElementById("branch_office_plan"),
                branch_office_usage_mode = document.getElementById("branch_office_usage_mode"),
                branch_office_default = document.getElementById("branch_office_default"),
                branch_office_department = document.getElementById("branch_office_department");

            let user_id = document.getElementById("customer_id")?.value;

            let formData = new FormData();
            formData.append('branch_office_name', branch_office_name.value);
            formData.append('branch_office_type', branch_office_type.value);
            formData.append('branch_office_description', branch_office_description.value);
            formData.append('branch_office_zone', branch_office_zone.value);
            formData.append('branch_office_address', branch_office_address.value);
            formData.append('branch_office_lat', branch_office_lat.value);
            formData.append('branch_office_lng', branch_office_lng.value);
            formData.append('branch_office_email', branch_office_email.value);
            formData.append('branch_office_contact', branch_office_contact.value);
            formData.append('branch_office_document_type', branch_office_document_type.value);
            formData.append('branch_office_document_number', branch_office_document_number.value);
            formData.append('branch_office_payment_method', branch_office_payment_method.value);
            formData.append('branch_office_phone', branch_office_phone.value);
            formData.append('branch_office_plan', branch_office_plan.value);
            formData.append('branch_office_usage_mode', branch_office_usage_mode.value);
            formData.append('branch_office_default', branch_office_default.value);
            formData.append('branch_office_department', branch_office_department.value);
            if(user_id != null){
                formData.append('user_id',user_id);
                console.log('user_id',user_id);
            }

            let response = await this.sendBranchOfficeData(formData);
            if(response['state'] == 200){
                correct('Sucursal creada de manera exitosa');
                branch_office_name.value = '';
                branch_office_type.value = '';
                branch_office_description.value = '';
                branch_office_zone.selectedIndex = 0;
                branch_office_address.value = '';
                branch_office_lat.value = '';
                branch_office_lng.value = '';
                branch_office_email.value = '';
                branch_office_contact.value = '';
                branch_office_document_type.selectedIndex = 0;
                branch_office_document_number.value = '';
                branch_office_payment_method.value = '';
                branch_office_phone.value = '';
                branch_office_usage_mode.value = '';
                branch_office_default.checked = false;
                branch_office_department.selectedIndex = 0;
                let modal = document.getElementById("modalCreate");
                modal.click();
                this.listBranchOffices();
            } else {
                error(response['error']);
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
        if(tbody == null){
            return;
        }
        tbody.innerHTML = '';
        let get_customer_id = document.getElementById("customer_id")?.value;
        let route = window.location.pathname.split('/');
        let customer_id = (route.includes('edit') || typeof parseInt(route[2]) == 'number') ? get_customer_id : null;
        let assignedBranchOffices = route.includes('edit') ? await this.requestBranchOffices(customer_id) : (typeof parseInt(route[2]) == 'number') ? await this.requestBranchOffices(customer_id) : await this.requestBranchOffices(customer_id);

        if(assignedBranchOffices.state == 200){
            let data = assignedBranchOffices.data;
            if(data.length > 0){
                for (let i = 0; i < data.length; i++) {
                    let row = tbody.insertRow();

                    let nameCell = row.insertCell(0);
                    nameCell.innerHTML = data[i].name??'';

                    let typeCell = row.insertCell(1);
                    typeCell.innerHTML = data[i].get_type.name??'';

                    let zoneCell = row.insertCell(2);
                    zoneCell.innerHTML = data[i].get_zone.name??'';

                    let contactCell = row.insertCell(3);
                    contactCell.innerHTML = data[i].contact??'';

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
                    branchCheck.checked = true;
                    // //Show button
                    // const showBranch = document.createElement("button");
                    // showBranch.setAttribute('class', 'btn btn-icon btn-light-primary btn-sm mr-2');
                    // showBranch.setAttribute('type', 'button');
                    // showBranch.innerHTML = '<i class="far fa-folder-open"></i>';
                    //Edit button
                    const branchEdit = document.createElement("button");
                    branchEdit.setAttribute('class', 'btn btnEdit btn-icon btn-light-success btn-sm mr-2');
                    branchEdit.setAttribute('data-toggle', 'modal');
                    branchEdit.setAttribute('data-target', '#modalEdit');
                    branchEdit.setAttribute('id', 'branch-'+data[i].id);
                    branchEdit.setAttribute('type', 'button');
                    branchEdit.setAttribute('title', 'Editar');
                    branchEdit.setAttribute('data-tooltip', '');
                    branchEdit.innerHTML = '<i class="fas fa-edit"></i>';
                    //Delete button
                    const branchDelete = document.createElement("button");
                    branchDelete.onclick = function(){confirmDelete('/sucursales/null/'+data[i].id)};
                    branchDelete.setAttribute('class', 'btn btn-icon btn-light-danger btn-sm mr-2');
                    branchDelete.setAttribute('type', 'button');
                    branchDelete.setAttribute('title', 'Eliminar');
                    branchDelete.setAttribute('data-tooltip', '');
                    branchDelete.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    //Div
                    const buttonsDiv = document.createElement("div");
                    buttonsDiv.setAttribute('class', 'd-flex justify-content-around aling-items-center flex-wrap flex-row');

                    if(!(typeof(parseInt(location.pathname.split('/')[2])) == 'number' && location.pathname.includes('edit')) || location.pathname.includes('create')){
                        buttonsDiv.appendChild(branchCheck);
                    }
                    buttonsDiv.appendChild(branchEdit);
                    buttonsDiv.appendChild(branchDelete);
                    selectCell.appendChild(buttonsDiv);
                    tbody.appendChild(row);
                }
            }
        }
        this.editBranches();
        this.listDepartments();
    }

    async requestBranchOffices(customer_id = null){
        let response = {
            'state': 500
        };
        await fetch("/unassigned_branch_offices?customer="+customer_id)
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    editBranches(){
        let branches = document.getElementsByClassName("btnEdit");
        if (branches == null) {
            return
        }
        [].forEach.call(branches, branch => {
            branch.addEventListener('click', async () =>{
                this.branchId = branch['id'].split('-')[1];
                let response = await this.requestBranchToEdit(this.branchId);
                let data = response.data[0];
                document.getElementById("branch_office_name_edit").value = data.name;
                let slcBranchType = document.getElementById("branch_office_type_edit");
                [].forEach.call(slcBranchType, key => {
                    if(key.value == data.type){
                        key.setAttribute('selected', 'selected');
                    }
                });
                document.getElementById("branch_office_description_edit").value = data.description;
                let slcZone = document.getElementById("branch_office_zone_edit");
                [].forEach.call(slcZone, key => {
                    if(key.value == data.zone_id){
                        key.setAttribute('selected', 'selected');
                    }
                });
                document.getElementById("branch_office_address_edit").value = data.address;
                document.getElementById("branch_office_lat_edit").value = data.lat;
                document.getElementById("branch_office_lng_edit").value = data.lng;
                document.getElementById("branch_office_email_edit").value = data.email;
                document.getElementById("branch_office_contact_edit").value = data.contact;
                let slcDocumentType = document.getElementById("branch_office_document_type_edit");
                [].forEach.call(slcDocumentType, key => {
                    if(key.value == data.document_type){
                        key.setAttribute('selected', 'selected');
                    }
                });
                document.getElementById("branch_office_document_number_edit").value = data.document_number;
                let slcPaymentMethod = document.getElementById("branch_office_payment_method_edit");
                [].forEach.call(slcPaymentMethod, key => {
                    if(key.value == data.payment_method){
                        if(key.value != 24){
                            document.getElementById("slcPlanEdit").className = 'form-group col-md-3';
                            document.getElementById("useModeEdit").className = 'form-group col-md-3';
                        } else {
                            document.getElementById("slcPlanEdit").className = 'd-none';
                            document.getElementById("useModeEdit").className = 'd-none';
                        }
                        key.setAttribute('selected', 'selected');
                    }
                });
                document.getElementById("branch_office_phone_edit").value = data.phone;
                let inpDefault = document.getElementsByName("branch_office_default_edit");
                [].forEach.call(inpDefault, key => {
                    if(key.value == data.default){
                        key.setAttribute('checked', 'checked');
                    }
                });
                let dpts = document.getElementById("branch_office_department_edit");
                [].forEach.call(dpts, dpt => {
                    if(data.get_department != null){
                        if(dpt.value == data.get_department.department_id){
                            dpt.selected = true;
                        }
                    } else {
                        dpt.value == 'Seleccione' ? dpt.selected = true : ''
                    }
                })
                let plans = document.getElementById("branch_office_plan_edit");
                [].forEach.call(plans, key => {
                    if(key.value == data.plan){
                        key.setAttribute('checked', 'true');
                    }
                });
            })
        });
    }

    async requestBranchToEdit(id){
        let response = {
            'state': 500
        };
        await fetch("/sucursales/null/"+id)
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    updateBranchOffice(){
        let formUpdateBranch = document.getElementById("formUpdate");
        let btnSubmit = document.getElementById("updateBranchOffice");
        if(formUpdateBranch == null){
            return;
        }
        if(btnSubmit == null){
            return;
        }
        btnSubmit.addEventListener('click', async (e) =>  {
            e.preventDefault();
            let formData = new FormData(formUpdateBranch);

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
            let response = await this.sendDataToUpdate(this.branchId, requestOptions);
            if(response.state == 200){
                alert(response.message);
                let modal = document.getElementById("modalEdit");
                modal.click();
                this.listBranchOffices();
            } else {
                alert('Ha ocurrido un error al actualizar la sucursal.');
                console.log('Error '+response.error);
            }
        });
    }

    async sendDataToUpdate(id, requestOptions){
        let response = {
            'state': 500
        };
        await fetch("/sucursales/"+null+"/"+id+"/update", requestOptions)
            .then((response) => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    async listDepartments(){
        let slcDepartments = document.getElementsByName("branch_office_department");
        if(slcDepartments == null) {
            return;
        }
        let departments = await this.requestDepartments();
        let data = departments.data;

        [].forEach.call(slcDepartments, slcDept => {
            slcDept.selectedIndex = "0";
            removeOptions(slcDept);

            for (var i = 0; i < data.length; i++) {
                let element = data[i];
                let department = '<option value="'+element.id+'"> '+element.name+' </option>';
                slcDept.insertAdjacentHTML('beforeend', department);
            }
        });
    }

    async requestDepartments(){
        let response = {
            'state': 500
        };
        await fetch("/unassigned_depts")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    saveUser(){
        let btnSubmit = document.getElementById("saveUser");
        if(btnSubmit == null){
            return;
        }
        btnSubmit.addEventListener('click', async () => {
            let parent_id = document.getElementById("customer_id").value,
                name = document.getElementById("user_name").value,
                last_name = document.getElementById("user_last_name").value,
                email = document.getElementById("user_email").value,
                phone = document.getElementById("user_phone").value,
                password = document.getElementById("user_password").value,
                password_confirm = document.getElementById("user_password_confirm").value;

            let formData = new FormData();
            formData.append('name', name);
            formData.append('last_name', last_name);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('password', password);
            formData.append('password_confirmation', password_confirm);

            let response = await this.storeUserData(parent_id, formData);
            if(response.state == 200){
                correct(response.message);
                let modal = document.getElementById("modalCreateUser");
                modal.click();
                this.listUsers();
            } else {
                error(response.error);
                console.log('Error: '+response.error);
            }
        });
    }

    async storeUserData(parent_id, formData){
        let response = {
            'state': 500
        };

        response = await fetch("/usuario-banco/"+parent_id+"/store", {
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            body: formData
        })
        return response.json();
    }

    async listUsers(){
        let tbody = document.querySelector("#users_table tbody");
        if(tbody == null){
            return;
        }
        let parent_id = document.getElementById("customer_id").value;
        if(parent_id == null){
            return;
        }
        tbody.innerHTML = '';
        let response = await this.requestUsers(parent_id);
        if(response.state == 200){
            let data = response.data;
            if(data.length > 0){
                [].forEach.call(data, key => {
                    let row = tbody.insertRow();

                    let nameCell = row.insertCell(0);
                    nameCell.innerHTML = key.name;

                    let lastNameCell = row.insertCell(1);
                    lastNameCell.innerHTML = key.last_name;

                    let emailCell = row.insertCell(2);
                    emailCell.innerHTML = key.email;

                    let phoneCell = row.insertCell(3);
                    phoneCell.innerHTML = key.phone;

                    let stateCell = row.insertCell(4);
                    if(key.state == 1){
                        stateCell.innerHTML =   '<span class="label label-inline label-light-success font-weight-bold">\
                                                    Activo\
                                                </span>';
                    } else {
                        stateCell.innerHTML =   '<span class="label label-inline label-light-danger font-weight-bold">\
                                                    Inactivo\
                                                </span>';
                    }
                    let selectCell = row.insertCell(5);
                    const userEdit = document.createElement("button");
                    userEdit.setAttribute('name', 'btnEditUser');
                    userEdit.setAttribute('class', 'btn btnEditUser btn-icon btn-light-success btn-sm mr-2');
                    userEdit.setAttribute('data-toggle', 'modal');
                    userEdit.setAttribute('data-target', '#modalEditUser');
                    userEdit.setAttribute('id', 'branch-'+key.id);
                    userEdit.setAttribute('type', 'button');
                    userEdit.innerHTML = '<i class="fas fa-edit"></i>';
                    //Delete button
                    const userDelete = document.createElement("button");
                    userDelete.onclick = function(){confirmDelete('/usuario-banco/'+parent_id+'/'+key.id)};
                    userDelete.setAttribute('class', 'btn btn-icon btn-light-danger btn-sm mr-2');
                    userDelete.setAttribute('type', 'button');
                    userDelete.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    //Div
                    const buttonsDiv = document.createElement("div");
                    buttonsDiv.setAttribute('class', 'd-flex justify-content-around aling-items-center flex-wrap flex-row');
                    buttonsDiv.appendChild(userEdit);
                    buttonsDiv.appendChild(userDelete);
                    selectCell.appendChild(buttonsDiv);

                    tbody.appendChild(row);
                });
                this.editUser();
            }
        }
    }

    async requestUsers(parent_id){
        let response = {
            'state': 500
        };
        await fetch("/usuario-banco/"+parent_id+"")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    editUser(){
        let users = document.getElementsByName("btnEditUser");
        if(users == null){
            return;
        }
        let parent_id = document.getElementById("customer_id").value;
        if(parent_id == null){
            return;
        }
        [].forEach.call(users, key => {
            key.addEventListener('click', async () => {
                let user_id = key['id'].split('-')[1];
                this.userId = user_id;
                let response = await this.requestUserData(parent_id, user_id);
                let data = response.data;

                document.getElementById("user_name_edit").value = data.name;
                document.getElementById("user_last_name_edit").value = data.last_name;
                document.getElementById("user_email_edit").value = data.email;
                document.getElementById("user_phone_edit").value = data.phone;
            });
        });
    }

    async requestUserData(parent_id, id){
        let response = {
            'state': 500
        };
        await fetch("/usuario-banco/"+parent_id+"/"+id+"/edit")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

    updateUser(){
        let updateBtn = document.getElementById("updateUser");
        if(updateBtn == null){
            return;
        }
        updateBtn.addEventListener('click', async () => {
            let parent_id = document.getElementById("customer_id").value;
            let name = document.getElementById("user_name_edit").value;
            let last_name = document.getElementById("user_last_name_edit").value;
            let email = document.getElementById("user_email_edit").value;
            let phone = document.getElementById("user_phone_edit").value;
            let password = document.getElementById("user_password_edit").value;
            let password_confirm = document.getElementById("user_password_confirm_edit").value;

            let formData = new FormData();
            formData.append('name', name);
            formData.append('last_name', last_name);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('password', password);
            formData.append('password_confirmation', password_confirm);

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
            let response = await this.sendUserDataToUpdate(parent_id, this.userId, requestOptions);
            if(response.state == 200){
                correct(response.message);
                let modal = document.getElementById("modalEditUser");
                modal.click();
                this.listUsers();
            } else {
                error(response.error);
                // console.log('Error: '+response.error);
            }
        });
    }

    async sendUserDataToUpdate(parent_id, id, requestOptions){
        let response = {
            'state': 500
        };
        await fetch('/usuario-banco/'+parent_id+'/'+id+'/update', requestOptions)
            .then((response) => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

}
