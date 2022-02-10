export default class Addresses {
    initialize() {
        this.autocompleteAddress();
        this.createAddress();
        this.getAddresses();
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
        const directionCity2 = document.getElementById("user_address");

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
                document.getElementById("user_address").value =place.formatted_address;
                document.getElementById("user_address_lat").value =place.geometry.location.lat();
                document.getElementById("user_address_lng").value =place.geometry.location.lng();
            });
        });

    }

    getAddresses = async () => {
        const address = document,
            $table = address.querySelector(".address_table"),
            $form = address.querySelector(".address_form"),
            $template = address.getElementById("address-template")?.content,
            $fragment = address.createDocumentFragment();

        try {
            let res = await fetch("/direcciones")
            .then((response) => response.json())
            .then(function (data) {
                data.data.forEach(element => {
                    $template.getElementById("description").textContent = element.description;
                    $template.getElementById("name").textContent = element.name;
                    $template.getElementById("state").textContent = element.state;
                    // $template.querySelector(".edit").dataset.id = el.id;
                    // $template.querySelector(".edit").dataset.name = el.nombre;
                    // $template.querySelector(".edit").dataset.constellation = el.constelacion;
                    // $template.querySelector(".delete").dataset.id = el.id;

                    let $clone = address.importNode($template, true);
                    $fragment.appendChild($clone);
               });

            })
            $table.querySelector("tbody").appendChild($fragment);
        } catch (err) {
            let message = err.statusText || "Ocurrió un error";
            $table.insertAdjacentHTML(
              "afterend",
              `<p><b>Error ${err.status}: ${message}</b></p>`
            );
        }
    };
     //CREATE ADDRESS
     createAddress() {
        let formCreateAddress = document.getElementById("formCreateAddress" );
        if (formCreateAddress == null) {
            return;
        }
        formCreateAddress.addEventListener("submit", function (e) {
            e.preventDefault();
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
                body: new FormData(formCreateAddress[0]),
            };

            fetch("/direcciones", requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    if (data.state == 500) {
                        alert(data.message);
                    }
                    if (data.state == 200) {
                        alert(data.message);
                    }
                    if (data.errors) {
                        alert(data.errors);
                    }
                })
                .catch((err) => console.warn(err));
        });
    }

}
