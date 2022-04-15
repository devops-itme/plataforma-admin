export default class Plans {
    initialize() {
        this.editPlan();
    }

    editPlan(){
        let editButtons = document.getElementsByName('planEditBtn');
        if(editButtons == null){
            return;
        }
        [].forEach.call(editButtons, btn => {
            btn.addEventListener('click', async () => {
                let id = btn.id;
                let response = await this.requestPlan(id);
                let data = response.data;
                let name = document.getElementById("plan_name_edit");
                name.value = data.name;
                let description = document.getElementById("plan_description_edit");
                description.value = data.description;
                let form = document.getElementById("formUpdate");
                form.setAttribute('action', '/planes/'+id);
            });
        });
    }

    async requestPlan(id){
        let response = {
            'state': 500
        };
        await fetch("/planes/"+id+"/edit")
            .then(response => response.json())
            .then(data => {
                response = data
            })
            .catch(e => console.log(e));
        return response;
    }
}
