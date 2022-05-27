export const requestValidateGuide = async (data) => {
    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Content-Type", "application/json");
    myHeaders.append("X-CSRF-TOKEN", token);

    let response = { state: 500, message: 'Error en la consulta' };

    let url = `${window.location.origin}/validateGuide`;

    await fetch(url, {
        method: 'POST',
        headers: myHeaders,
        body: data
    })
        .then(response => response.json())
        .then(data => {
            response = data;
        })
        .catch(e => {
            response.error = e;
        });

    return response;
}