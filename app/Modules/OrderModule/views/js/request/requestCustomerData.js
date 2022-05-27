export const requestCustomerData = async (query) => {
    let response = {
        state: 500,
    };
    await fetch("/customer_data/" + query)
        .then((response) => response.json())
        .then((data) => {
            response = data;
        })
        .catch((e) => (response.error = e));
    return response;
}