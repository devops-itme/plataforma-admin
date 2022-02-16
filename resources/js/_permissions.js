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

        if (configurationBtn == null) {
            return
        }
        console.log(configurationBtn);
        [].forEach.call(configurationBtn, function (btn) {
            btn.addEventListener('click', async () => {
                let row = btn.parentNode.parentNode;
                let role_id = row.id;

                let url = '/permisos/getPermissions/' + role_id;
                let response = await requestPermissions(url);
                console.log(response)
                if (response.state != 200) {
                    return;
                }
                let data = response.data;
                console.log(data)
                let modules = data.modules;

                [].forEach.call(modules, module => {
                    console.log(module)
                });



            });
        });
    }
}