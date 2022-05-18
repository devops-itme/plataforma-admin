export const requestSearchZone = async (address_id) => {
    let response = { state: 500, message: 'Error en la consulta' };
    let url = `${window.location.origin}/api/searchZone?address_id=${address_id}`;

    await fetch(url)
        .then(response => response.json())
        .then(data => {
            response = data;
        })
        .catch(e => {
            response.error = e;
        });

    return response;
}