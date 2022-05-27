export const requestPickupHours = async () => {
    let response = {
        state: 500,
    };
    await fetch("/getPickupHours")
        .then((response) => response.json())
        .then((data) => {
            response = data;
        })
        .catch((e) => (response.error = e));
    return response;
}