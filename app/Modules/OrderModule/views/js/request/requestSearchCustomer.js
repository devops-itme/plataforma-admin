export const requestSearchCustomer = async (query) => {
    let response = {
        state: 500,
    };
    await fetch("/search_customers?value=" + query)
        .then((response) => response.json())
        .then((data) => {
            response = data;
        })
        .catch((e) => (response.error = e));
    return response;
}