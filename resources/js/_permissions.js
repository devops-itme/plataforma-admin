const requestPermissions = async (url) => {
    let response = { state: 500 };
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    await fetch(url, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
        .then(response => response.json())
        .then((data) => {
            response = data;
        })
        .catch(function (e) {
            console.log(e);
        });

    return response
}
export default class Permissions {
    initialize() {
        this.loadPermissions();
    }



    loadPermissions() {
        let configurationBtn = document.getElementsByClassName("configuration-btn");
        let permitsLbl = document.getElementById("permits-label");
        if (configurationBtn == null) {
            return
        }
     
        [].forEach.call(configurationBtn, function (btn) {
            btn.addEventListener('click', async () => {
                let row = btn.parentNode.parentNode;
                let role_id = row.id;
                permitsLbl.innerText = `Permisos - ${row.getAttribute("name")}`;

                let form = document.getElementById("permits-form");
                form.setAttribute("action", `/permisos/${role_id}`)

                let url = '/permisos/getPermissions/' + role_id;
                let response = await requestPermissions(url);
                if (response.state != 200) {
                    return;
                }
                let data = response.data;
                let modules = data.modules;
                let actions = data.actions;
                let permissions = data.permissions;

                let cardBody = document.getElementById("card-body");
                cardBody.innerHTML = ``;
                [].forEach.call(modules, module => {
                    let module_actions = module?.actions?.split(',') ?? [];
                    let module_permissions = permissions.find(element => element.module_id == module.id);
                    let allowed_actions = module_permissions?.actions?.split(',') ?? [];

                    let mainContainer = document.createElement('div');
                    mainContainer.className = "row";

                    let nameContainer = document.createElement("div");
                    nameContainer.className = "col-3 align-self-center";
                    nameContainer.innerHTML = `<h6 class="mb-0 text-muted font-weight-bold">${module.name}</h6>`;
                    mainContainer.appendChild(nameContainer);

                    let checkContainer = document.createElement("div");
                    checkContainer.className = "col-9 align-self-center";
                    checkContainer.innerHTML = `<div class="form-check"></div>`;

                    [].forEach.call(actions, action => {
                        const action_found = module_actions.find(element => element == action.id);
                        const permission_found = allowed_actions.find(element => element == action.id);

                        let label = document.createElement("label");
                        label.className = "form-check-label text-uppercase font-weight-bold mx-4";

                        label.innerHTML = `
                        <input class="form-check-input" type="checkbox" value="${action.id}"
                         name="${module.reference}[]" ${!action_found && 'disabled'}
                         ${permission_found && 'checked'}
                        > ${action.name}
                        `;
                        checkContainer.childNodes[0].appendChild(label);
                    });

                    mainContainer.appendChild(checkContainer);

                    cardBody.appendChild(mainContainer);

                    let submitBtn = document.getElementById("submit-btn");
                    submitBtn.className = `btn btn-primary btn-sm d-block`
                });



            });
        });
    }
}