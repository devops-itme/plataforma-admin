<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multientrega</title>
</head>

<body>

    lat
    <input value="{{ $lat }}" id="lat" />
    lng
    <input value="{{ $lng }}" id="lng" />
    coordinates
    <input value="{{ $zones }}" id="zones" />

    <script>
        function initMap() {

            let lat = document.getElementById("lat");
            let lng = document.getElementById("lng");
            let zones = document.getElementById("zones");

            if (lat == null || lng == null || zones == null) {
                return;
            };

            zones = JSON.parse(zones.value);
            lat = lat.value;
            lng = lng.value;

            if (lat == null || lng == null || zones == null) {
                return;
            };
            let zone_id;
            zones.forEach(zone => {
                let coordinates = JSON.parse(zone.coordinates);
                if (coordinates == null) {
                    return;
                };

                let area = new google.maps.Polygon({
                    paths: coordinates,
                });
                setTimeout(function() {
                    let result = google
                        .maps
                        .geometry
                        .poly
                        .containsLocation(new google.maps.LatLng(lat, lng), area);

                    if (result) {
                        zone_id = zone.id ?? '';
                        console.log(zone.id);
                    }
                }, 100);
            });
            setTimeout(function() {
                console.log('zone_id', zone_id)
                window.location.href = `searchZone?zone_id=${zone_id}&response=1`;
            }, 1000);
            return;
        };
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?library=geometry&callback=initMap&key=AIzaSyD9MFKCZ2zM_6wtlJCiaSdalzbubH_tKFk"
        async defer></script>

</body>

</html>
