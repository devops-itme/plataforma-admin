export const requestCalculatePackingRates = async (rate_id, lbs, vol, immediate_delivery) => {
    let response = { state: 500, message: 'Error en la consulta' };
    if(rate_id == null){
        response.message = 'id de la tarifa es obligatorio'
        return response;
    }
    let url = `${window.location.origin}/api/calculatePackingRates?rate_id=${rate_id}&lbs=${lbs}&vol=${vol}&immediate_delivery=${immediate_delivery}`;

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