export default class Addresses {
    initialize() {
        this.autocompleteAddress();
    }
    //AUTOCOMPLETE BRANCH OFFICES
    autocompleteAddress() {
        const directionCity = document.getElementById('branch_office_address');


        google.maps.event.addDomListener(window, 'load', function () {
            const autocompleteCity = new google.maps.places.Autocomplete(
                directionCity, {
                    bounds: new google.maps.LatLngBounds(
                        new google.maps.LatLng(40.416775, -3.703790)
                    ),
                    types: ['geocode']
                }
            );

            autocompleteCity.addListener("place_changed", () => {
                const place = autocompleteCity.getPlace();
                document.getElementById('branch_office_address').value = place.formatted_address;
                document.getElementById('branch_office_lat').value = place.geometry.location.lat();
                document.getElementById('branch_office_lng').value = place.geometry.location.lng();

            });

        });

         //AUTOCOMPLETE CLIENT ADDRESS CREATE/EDIT
        const directionCity2 = document.getElementById('user_address');
        google.maps.event.addDomListener(window, 'load', function () {
            const autocompleteCity2 = new google.maps.places.Autocomplete(
                directionCity2, {
                    bounds: new google.maps.LatLngBounds(
                        new google.maps.LatLng(40.416775, -3.703790)
                    ),
                    types: ['geocode']
                }
            );

            autocompleteCity2.addListener("place_changed", () => {
                const place = autocompleteCity2.getPlace();
                document.getElementById('user_address').value = place.formatted_address;
                document.getElementById('user_address_lat').value = place.geometry.location.lat();
                document.getElementById('user_address_lng').value = place.geometry.location.lng();

            });

        });
    }


}
