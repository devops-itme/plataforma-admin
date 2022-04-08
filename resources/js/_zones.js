import { requestPlaces } from './_requests';

let map;
let infoWindow;

function showArrays(event) {
    // Since this polygon has only one path, we can call getPath() to return the
    // MVCArray of LatLngs.
    const polygon = this;
    const vertices = polygon.getPath();
    let contentString =
        "<b>Bermuda Triangle polygon</b><br>" +
        "Clicked location: <br>" +
        event.latLng.lat() +
        "," +
        event.latLng.lng() +
        "<br>";

    // Iterate over the vertices.
    for (let i = 0; i < vertices.getLength(); i++) {
        const xy = vertices.getAt(i);

        contentString +=
            "<br>" + "Coordinate " + i + ":<br>" + xy.lat() + "," + xy.lng();
    }

    // Replace the info window's content and position.
    infoWindow.setContent(contentString);
    infoWindow.setPosition(event.latLng);
    infoWindow.open(map);
}
export default class Zones {
    initialize() {
        this.initMap();
        this.getCountries();
    }

    initMap() {
        infoWindow = new google.maps.InfoWindow();
        // The location of panama 8.689078613386496, -81.13166771577085
        const panama = { lat: 8.689, lng: -81.131 };
        let mapTemplate = document.getElementById("map");
        if (mapTemplate == null) {
            return;
        }
        // The map, centered at panama
        map = new google.maps.Map(mapTemplate, {
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
            fillOpacity: 0.35,
        });

        myPolygon.setMap(map);
        myPolygon.addListener("dragend", showArrays);
    }

    async getCountries() {
        let select = document.getElementById("select-country");
        if (select == null) {
            return;
        }

        let response = await requestPlaces('country');
        if (response.state != 200) {
            return;
        }

        let countries = response.data;
        countries.map(country => {
            let option = document.createElement("option");
            option.text = country.name;
            option.value = country.id;
            select.appendChild(option);
        });
        select.addEventListener('change', function () {
            getProvinces(select.value);
        });
    }
}

const getProvinces = async (id) => {
    let select = document.getElementById("select-province");
    if (select == null) {
        return;
    }
    select.innerHTML = `<option selected disabled>Seleccione provincia</option>`;

    let response = await requestPlaces('province', id);
    if (response.state != 200) {
        return;
    }

    let provinces = response.data;
    provinces.map(province => {
        let option = document.createElement("option");
        option.text = province.name;
        option.value = province.id;
        select.appendChild(option);
    });
    select.addEventListener('change', function () {
        getDistricts(select.value);
    });
}

const getDistricts = async (id) => {
    let select = document.getElementById("select-district");
    if (select == null) {
        return;
    }
    select.innerHTML = `<option selected disabled>Seleccione distrito</option>`;

    let response = await requestPlaces('district', id);
    if (response.state != 200) {
        return;
    }

    let districts = response.data;
    districts.map(district => {
        let option = document.createElement("option");
        option.text = district.name;
        option.value = district.id;
        select.appendChild(option);
    });

    select.addEventListener('change', function () {
        getCorregimientos(select.value);
    });
}

const getCorregimientos = async (id) => {
    let select = document.getElementById("select-corregimiento");
    if (select == null) {
        return;
    }
    select.innerHTML = `<option selected disabled>Seleccione corregimientos</option>`;

    let response = await requestPlaces('corregimiento', id);
    if (response.state != 200) {
        return;
    }

    let corregimientos = response.data;
    corregimientos.map(corregimiento => {
        let option = document.createElement("option");
        option.text = corregimiento.name;
        option.value = corregimiento.id;
        select.appendChild(option);
    });

    select.addEventListener('change', function () {
        getNeighborhoods(select.value);
    });
}

const getNeighborhoods = async (id) => {
    let select = document.getElementById("select-neighborhood");
    if (select == null) {
        return;
    }
    select.innerHTML = `<option selected disabled>Seleccione barrio</option>`;

    let response = await requestPlaces('neighborhood', id);
    if (response.state != 200) {
        return;
    }

    let neighborhoods = response.data;
    neighborhoods.map(neighborhood => {
        let option = document.createElement("option");
        option.text = neighborhood.name;
        option.value = neighborhood.id;
        select.appendChild(option);
    });
}