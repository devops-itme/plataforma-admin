export default class Addresses {
    initialize() {
        this.autocompleteAddress();
        this.createAddress();
        this.getAddresses();
        this.deleteAddress();
    }
    //AUTOCOMPLETE BRANCH OFFICES
    autocompleteAddress() {
        const directionCity = document.getElementById("branch_office_address");

        google.maps.event.addDomListener(window, "load", function () {
            const autocompleteCity = new google.maps.places.Autocomplete(
                directionCity,
                {
                    bounds: new google.maps.LatLngBounds(
                        new google.maps.LatLng(40.416775, -3.70379)
                    ),
                    types: ["geocode"],
                }
            );

            autocompleteCity.addListener("place_changed", () => {
                const place = autocompleteCity.getPlace();
                document.getElementById("branch_office_address").value =
                    place.formatted_address;
                document.getElementById("branch_office_lat").value =
                    place.geometry.location.lat();
                document.getElementById("branch_office_lng").value =
                    place.geometry.location.lng();
            });
        });

        //AUTOCOMPLETE CLIENT ADDRESS CREATE/EDIT
        const directionCity2 = document.getElementsByName("address");
        directionCity2.forEach(function callback(directionCity2, index) {
            google.maps.event.addDomListener(window, "load", function () {
                const autocompleteCity2 = new google.maps.places.Autocomplete(
                    directionCity2,
                    {
                        bounds: new google.maps.LatLngBounds(
                            new google.maps.LatLng(40.416775, -3.70379)
                        ),
                        types: ["geocode"],
                    }
                );
                autocompleteCity2.addListener("place_changed", () => {
                    const place = autocompleteCity2.getPlace();
                    document.getElementsByName("address")[index].value =
                        place.formatted_address;
                    document.getElementsByName("lat")[index].value =
                        place.geometry.location.lat();
                    document.getElementsByName("lng")[index].value =
                        place.geometry.location.lng();
                });
            });
        });
    }

    getAddresses = async () => {

        const address = document,
            $table = address.querySelector(".address_table"),
            $template = address.getElementById("address-template")?.content,
            $fragment = address.createDocumentFragment();
        let user_id = $table?.id;

        $table?.querySelector("tbody").replaceChildren($fragment)
        try {
            let res = await fetch(`/direcciones?user_id=+${user_id}`)
                .then((response) => response.json())
                .then(function (data) {
                    data.data.forEach((element) => {
                        $template.getElementById("description").textContent =
                            element.description;
                        $template.getElementById("name").textContent =
                            element.name;
                        $template.getElementById("state").textContent =
                            element.state;

                        $template.querySelector(".edit").dataset.id =
                            element.id;
                        $template.querySelector(".edit").dataset.description =
                            element.description;
                        $template.querySelector(".edit").dataset.name =
                            element.name;
                        $template.querySelector(".edit").dataset.lat =
                            element.lat;
                        $template.querySelector(".edit").dataset.lng =
                            element.lng;

                        $template.querySelector(".delete").dataset.id =
                            element.id;
                        let $clone = address.importNode($template, true);
                        // populate_with_new_rows(address);
                        // old_tbody.parentNode.replaceChild(address, old_tbody)
                        $fragment.appendChild($clone);
                    });
                });


            $table?.querySelector("tbody").appendChild($fragment);
        } catch (err) {
            let message = err.statusText || "Ocurrió un error";
            $table?.insertAdjacentHTML(
                "afterend",
                `<p><b>Error ${err.status}: ${message}</b></p>`
            );
        }
    };
    //CREATE ADDRESS
    createAddress() {
        let formCreateAddress = document.getElementById("formCreateAddress");
        if (formCreateAddress == null) {
            return;
        }
        formCreateAddress.style.display = "none";
        formCreateAddress.addEventListener("submit", async (e) => {
            e.preventDefault();
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            myHeaders.append("Access-Control-Allow-Origin", "*");
            myHeaders.append("Content-Type", "application/json");
            myHeaders.append("X-CSRF-TOKEN", token);

            let formData = JSON.stringify({
                user_id: e.target.user_id.value,
                name: e.target.address.value,
                lat: e.target.lat.value,
                lng: e.target.lng.value,
                description: e.target.description.value,
            });

            let requestOptions = {
                method: "POST",
                headers: myHeaders,
                body: formData,
            };
            let response = await this.requestCreateAddress(requestOptions);

            if (response.state != 200) {
                console.log(formCreateAddress);
            }
            this.getAddresses();
        });
    }

    async requestCreateAddress(requestOptions) {
        let response = { data: 500 };
        await fetch("/direcciones", requestOptions)
            .then((response) => response.json())
            .then(function (data) {
                response = data;
            })
            .catch((err) => console.warn(err));

        return response;
    }

    deleteAddress() {
        // let template = document.getElementById("address-template");
        // if (template == null) {
        //     return;
        // }
        // let btn_delete = template.getElementsByClassName("deleteAddress");
        // console.log(btn_delete);
        // template.addEventListener("click", async (e) => {
        //     e.preventDefault();

        //     if (e.target.matches(".delete")) {
        //         let isDelete = confirm(
        //             `¿Estás seguro de eliminar el id ${e.target.dataset.id}?`
        //         );
        //     }
        // });
    }
}
