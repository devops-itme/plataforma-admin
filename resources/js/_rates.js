import { requestPlaces } from './_requests';
export default class Rates {
    initialize() {
        this.getNeighborhoods();
    }

    async getNeighborhoods() {
        let select = document.getElementById("select-zone");
        if (select == null) {
            return;
        }
        let response = await requestPlaces('zone_neighborhoods');
        console.log(response)
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
    
    let response = await requestPlaces('zone_neighborhoods', id);
   
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