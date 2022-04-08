import { requestZoneNeighborhoods } from './_requests';
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
    select.innerHTML = `<option selected disabled>Seleccione barrio</option>`;
    console.log('zone_neighborhoods', id)
    let response = await requestZoneNeighborhoods(id);

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