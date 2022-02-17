export default class Zones {
    initialize() {
        this.initMap();
    }

    initMap() {
        // The location of panama 8.689078613386496, -81.13166771577085
        const panama = { lat: 8.689, lng: -81.131 };
        let mapTemplate = document.getElementById("map");
        if (mapTemplate == null) {
            return;
        }
        // The map, centered at panama
        const map = new google.maps.Map(mapTemplate, {
            zoom: 7,
            center: panama,
            mapTypeId: google.maps.MapTypeId.RoadMap
        });
        // The marker, positioned at Uluru
        // const marker = new google.maps.Marker({
        //     position: panama,
        //     map: map,
        // });

        let triangleCoords = [
            new google.maps.LatLng(8.827520901431855, -82.07374528457048),
            new google.maps.LatLng(8.281601970995954, -81.7386623009158),
            // new google.maps.LatLng(8.71351334406503, -81.26075706193294)
        ];

        let myPolygon = new google.maps.Polygon({
            paths: triangleCoords,
            draggable: true, // turn off if it gets annoying
            editable: true,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });

        myPolygon.setMap(map);
    }
}