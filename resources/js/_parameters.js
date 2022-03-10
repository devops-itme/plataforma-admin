export default class Parameters {
    initialize() {
        this.parameterData();
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
                this.updateParameter(id);
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
        await fetch("/parametros/"+id+"/", requestOptions)
            .then((response) => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }

}
