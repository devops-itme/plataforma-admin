export const requestGetOrder = async (id) => {
    let response = {
        state: 500,
    };
    await fetch("/getOrder/" + id)
        .then((response) => response.json())
        .then((data) => {
            response = data;
        })
        .catch((e) => (response.error = e));
    return response;
}    