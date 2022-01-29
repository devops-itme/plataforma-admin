export default class Messengers {
    initialize() {
        this.createMessengers();
    }

    createMessengers() {
        let formCreateMessenger = document.getElementById('formCreateMessenger');
        if (formCreateMessenger == null) {
            return;
        }
        formCreateMessenger.addEventListener('submit', function(e){
            e.preventDefault()
           let token = document
               .querySelector('meta[name="csrf-token"]')
               .getAttribute("content");
           let myHeaders = new Headers();
           myHeaders.append("accept", "application/json");
           myHeaders.append("Access-Control-Allow-Origin", "*");
           myHeaders.append("X-CSRF-TOKEN", token);

           let requestOptions = {
               method: "POST",
               headers: myHeaders,
               body: new FormData(formCreateMessenger),
           };

           fetch("/mensajeros", requestOptions)
               .then((response) => response.json())
               .then(function (data) {})
               .catch((err) => console.warn(err));
        });
    }
}
