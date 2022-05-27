export const requestGuides = async () => {
    let orderNumber = document.getElementsByName("order_number")[0];
    if (orderNumber == null) {
        orderNumber = null;
    } else {
        orderNumber = orderNumber.value;
    }
    let path = window.location.pathname.split("/");
    let response = {
        state: 500,
    };
    await fetch("/guias?order=" + orderNumber + "&path=" + path)
        .then((response) => response.json())
        .then((data) => {
            response = data;
        })
        .catch((e) => (response.error = e));
    return response;
}