export const requestGuide = async (id) => {
    let response = {
        state: 500,
    };
    await fetch("/guias/" + id + "/edit")
        .then((response) => response.json())
        .then((data) => {
            response = data;
        })
        .catch((e) => (response.error = e));
    return response;
}    