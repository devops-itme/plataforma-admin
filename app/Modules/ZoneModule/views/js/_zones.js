import { requestPlaces, requestZone } from '../../../../../resources/js/_requests';

let map;
let coordinates = [];

function showArrays(event) {
    let coordinates_input = document.getElementById("coordinates");
    if (coordinates_input == null) {
        return;
    }

    const polygon = this;
    const vertices = polygon.getPath();
    coordinates = [];
   
    for (let i = 0; i < vertices.getLength(); i++) {
        const xy = vertices.getAt(i);
        coordinates.push({ lat: xy.lat(), lng: xy.lng() });
    }
    
    coordinates_input.value = JSON.stringify(coordinates);
}

function initMap(coordinates = null) {
    if (google == null) {
        return;
    }
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

    let triangleCoords = [
        new google.maps.LatLng(8.827520901431855, -82.07374528457048),
        new google.maps.LatLng(8.281601970995954, -81.7386623009158),
    ];
    if (coordinates != null) {
        triangleCoords = JSON.parse(coordinates);
    }

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
    myPolygon.addListener("mouseup", showArrays);
}
export default class Zones {
    initialize() {
        initMap();
        this.getCountries();
        this.formHandler();
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

    formHandler() {
        let editBtn = document.getElementsByClassName("edit-btn");
        if (editBtn == null) {
            return;
        }

        [].forEach.call(editBtn, function (btn) {
            btn.addEventListener('click', async () => {
                let info_label = document.getElementById("info-label");
                if (info_label == null) {
                    return;
                }
                info_label.innerText = 'Actualizar'

                let zone_form = document.getElementById("zone-form");
                if (zone_form == null) {
                    return;
                }

                let select_state = document.getElementById("select-state");
                if (select_state==null) {
                    return;
                }

                let input_name = document.getElementById("input-name");
                if (input_name == null) {
                    return;
                }

                let select_country = document.getElementById("select-country");
                if (select_country == null) {
                    return;
                }

                let response = await requestZone(btn?.id);
                if (response?.state != 200) {
                    return;
                }               

                let zone = response.data;
                initMap(zone.coordinates);
                zone_form.setAttribute('action', `zonas/${zone.id}`);
                let put = document.createElement('input');
                put.type = 'hidden'; put.name = '_method'; put.value = 'PUT';
                zone_form.appendChild(put);

                input_name.value = zone.name;
                let country = zone.get_neighborhoods[0].get_corregimiento.get_district.get_province.get_country;
                let province = zone.get_neighborhoods[0].get_corregimiento.get_district.get_province;
                let district = zone.get_neighborhoods[0].get_corregimiento.get_district;
                let corregimiento = zone.get_neighborhoods[0].get_corregimiento;
                let neighborhoods = zone.get_neighborhoods;

                select_country.value = country.id;
                getProvinces(country.id, province.id);
                getDistricts(province.id, district.id);
                getCorregimientos(district.id, corregimiento.id);
                getNeighborhoods(corregimiento.id, neighborhoods);

                select_state.value = zone.state;
                let select_state_container = select_state.parentNode;
                select_state_container.className = "form-group col-md-12";
            });
        });
    }
}

const getProvinces = async (id, selected = false) => {
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

    if (selected) {
        select.value = selected;
    }

    select.addEventListener('change', function () {
        getDistricts(select.value);
    });
}

const getDistricts = async (id, selected = false) => {
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

    if (selected) {
        select.value = selected;
    }

    select.addEventListener('change', function () {
        getCorregimientos(select.value);
    });
}

const getCorregimientos = async (id, selected = false) => {
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

    if (selected) {
        select.value = selected;
    }

    select.addEventListener('change', function () {
        getNeighborhoods(select.value);
    });
}

const getNeighborhoods = async (id, selected = []) => {
    let select = document.getElementById("select-neighborhood");
    if (select == null) {
        return;
    }
    select.innerHTML = `<option disabled>Seleccione barrio</option>`;

    let response = await requestPlaces('neighborhood', id);
    if (response.state != 200) {
        return;
    }

    let neighborhoods = response.data;
    neighborhoods.map(neighborhood => {
        const found = selected.find(element => element.id == neighborhood.id);
        let option = document.createElement("option");
        option.text = neighborhood.name;
        option.value = neighborhood.id;
        option.selected = found ? true : false;
        select.appendChild(option);
    });
}