export default class Addresses {
    initialize() {
        this.autocompleteAddress();
    }
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
    }
}
