export default class BranchOffices {
    initialize() {
        this.loadPlanFields();
        this.autocompleteAddress();
    }
    loadPlanFields(){
        let option = document.getElementById("branch_office_payment_method");
        let useMode = document.getElementById("useMode");
        let slcPlan = document.getElementById("slcPlan");
        if(option == null){
            return;
        }
        option.addEventListener('change', () => {
            if(option.value == 25){
                useMode.className = 'd-none';
                slcPlan.className = 'd-none';
            } else {
                useMode.className = 'form-group col-md-3';
                slcPlan.className = 'form-group col-md-3';
            }
        });
    }
    autocompleteAddress() {
        const directionCity = document.getElementById("branch_office_address");
        if (directionCity == null) {
            return;
        }
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
    }


}
