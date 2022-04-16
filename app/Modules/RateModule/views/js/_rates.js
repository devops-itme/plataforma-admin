import { requestZoneNeighborhoods } from '../../../../../resources/js/_requests';
export default class Rates {
    initialize() {
        this.getZone();
    }

    async getZone() {
        let select = document.getElementById("select-zone");
        if (select == null) {
            return;
        }

        select.addEventListener('change', function () {
            getNeighborhoods(select.value);
        });
    }
}

const getNeighborhoods = async (id) => {
    let select = document.getElementById("select-neighborhood");
    if (select == null) {
        return;
    }
    select.innerHTML = `<option selected disabled>Seleccione</option>`;

    let response = await requestZoneNeighborhoods(id);

    if (response.state != 200) {
        return;
    }

    let neighborhoods = response.data;
    neighborhoods.map(neighborhood => {
        let option = document.createElement("option");
        
        option.text = ((neighborhood.name ?? '') + '; ' +
            (neighborhood.get_corregimiento.name ?? '') + '; ' +
            (neighborhood.get_corregimiento.get_district.name ?? '') + '; ' +
            (neighborhood.get_corregimiento.get_district.get_province.name ?? '') + '; ' +
            (neighborhood.get_corregimiento.get_district.get_province.get_country.name ?? ''));
        option.value = neighborhood.id;
        select.appendChild(option);
    });
}