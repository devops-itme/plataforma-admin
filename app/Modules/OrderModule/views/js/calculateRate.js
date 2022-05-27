import { requestCalculatePackingRates } from './request/requestCalculatePackingRates';

export const calculateRate = async (boxes, destination_rate_id) => {
    if (destination_rate_id == null) {
        return
    }
    let corp_value = document.getElementById("corp_value");
    let address = document.getElementById("address");
    if (corp_value == null || address == null) {
        return;
    }
    corp_value.value = 0;

    let same_day_delivery = document.getElementById("same_day_delivery");
    if (same_day_delivery == null) {
        return;
    }
    let immediate_delivery = same_day_delivery.checked ? 1 : 0;

    await [].forEach.call(boxes, async (box) => {
        let lbs = box?.weight;
        let vol = box?.long * box?.broad * box?.high;

        let response = await requestCalculatePackingRates(destination_rate_id, lbs, vol, immediate_delivery);
        if (response.state == 200) {
            corp_value.value = parseFloat(corp_value.value) + parseFloat(response.data);
        }
    });
}