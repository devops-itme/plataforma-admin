export const requestPlaces = async (place, id = '') => {
    let response = {
        'state': 500
    };
    await fetch(`getPlaces?place_type=${place}&place_id=${id}`)
        .then(response => response.json())
        .then(data => {
            response = data
        })
        .catch(e => console.log(e));
    return response;
}

export const requestZoneNeighborhoods = async (id = '') => {
    let response = {
        'state': 500
    };
    await fetch(`/getZoneNeighborhoods/${id}`)
        .then(response => response.json())
        .then(data => {
            response = data
        })
        .catch(e => console.log(e));
    return response;
}

export const requestZone = async (id = '') => {
    let response = {
        'state': 500
    };
    await fetch(`/zonas/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            response = data
        })
        .catch(e => console.log(e));
    return response;
}