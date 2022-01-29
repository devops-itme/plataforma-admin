export default class Messengers {
    initialize() {
        this.createMessengers();
    }

    // //CREATE MESSENGER
    // createMessengers() {
    //     let formCreateMessenger = document.getElementById(
    //         "formCreateMessenger"
    //     );
    //     if (formCreateMessenger == null) {
    //         return;
    //     }
    //     formCreateMessenger.addEventListener("submit", function (e) {
    //         e.preventDefault();
    //         let token = document
    //             .querySelector('meta[name="csrf-token"]')
    //             .getAttribute("content");
    //         let myHeaders = new Headers();
    //         myHeaders.append("accept", "application/json");
    //         myHeaders.append("Access-Control-Allow-Origin", "*");
    //         myHeaders.append("X-CSRF-TOKEN", token);

    //         let requestOptions = {
    //             method: "POST",
    //             headers: myHeaders,
    //             body: new FormData(formCreateMessenger),
    //         };

    //         fetch("/mensajeros", requestOptions)
    //             .then((response) => response.json())
    //             .then(function (data) {
    //                 if (data.state == 500) {
    //                     alert(data.message);
    //                 }
    //                 if (data.state == 200) {
    //                     alert(data.message);
    //                 }
    //                 if (data.errors) {
    //                     alert(data.errors);
    //                 }
    //             })
    //             .catch((err) => console.warn(err));
    //     });
    // }

    // //DELETE MESSENGER
    // deleteMessenger() {
    //     let deleteMessenger = document.getElementById("deleteMessenger");

    //     deleteMessenger.addEventListener("submit", function (e) {
    //         e.preventDefault();
    //     });
    // }

    // // UPDATE MESSENGER
    // updateMessenger() {
    //     let formUpdateMessenger = document.getElementById("formUpdateMessenger");
    //     if (formUpdateMessenger == null) {
    //         return;
    //     }
    //     formUpdateMessenger.addEventListener("submit", function (e) {
    //         e.preventDefault();
    //         let token = document
    //             .querySelector('meta[name="csrf-token"]')
    //             .getAttribute("content");
    //         let myHeaders = new Headers();
    //         myHeaders.append("accept", "application/json");
    //         myHeaders.append("Access-Control-Allow-Origin", "*");
    //         myHeaders.append("X-CSRF-TOKEN", token);

    //         let requestOptions = {
    //             method: "PUT",
    //             headers: myHeaders,
    //             body: new FormData(formUpdateMessenger),
    //         };

    //         fetch("/mensajeros", requestOptions)
    //             .then((response) => response.json())
    //             .then(function (data) {
    //                 if (data.state == 500) {
    //                     alert(data.message);
    //                 }
    //                 if (data.state == 200) {
    //                     alert(data.message);
    //                 }
    //                 if (data.errors) {
    //                     alert(data.errors);
    //                 }
    //             })
    //             .catch((err) => console.warn(err));
    //     });
    // }
}
