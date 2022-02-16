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
            btn.addEventListener('click', () => {
                console.log(btn)

            });
        });
    }
}