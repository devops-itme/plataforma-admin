export const requestRate = async (zone_id) => {
    let response = { state: 500, message: 'Error en la consulta' };
    let url = `${window.location.origin}/api/rateInquiry?zone_id=${zone_id}`;

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