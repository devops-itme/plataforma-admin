export const requestPlaces = async (place, id = '') => {
    let response = {
        'state': 500
    };
    await fetch(`getPlaces?place_type=${place}&place_id=${id}`)
        .then(response => response)
        .then(data => {
            response = data
        })
        .catch(e => console.log(e));
    return response;
}