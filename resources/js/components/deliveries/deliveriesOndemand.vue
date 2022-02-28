<script>
export default {
    data() {
        return {
            data: [],
            activeIndex: null,
            shipmented: [],
            completed: [],
            showData: "",
            tabs: [],
            currentTab: 31,
            showMessengerData:[],
            messengers: [],
            searchMessenger: null,
            messenger: null,
            messengerName: null,
            // orderTypes: null,
        };
    },
    computed: {
        filterMessengers() {
            if (this.searchMessenger) {
                return this.messengers.filter((item) => {
                    return this.searchMessenger
                        .toString()
                        .toLowerCase()
                        .split(" ")
                        .every((v) =>
                            item.user.document_number.toLowerCase().includes(v)
                        );
                });
            }
        },

        setMessenger() {
            if (this.searchMessenger) {
                this.messengerName =
                    this.filterMessengers[0]?.user.name +
                    " " +
                    this.filterMessengers[0]?.user.last_name;
                return (this.messenger = this.filterMessengers[0]);
            }
        },
    },
    watch: {},

    methods: {
        async getOrders(type_id, index) {
            index != undefined &&
                $(`#myTab li:nth-child(${index + 1}) a`).tab("show");

            this.currentTab = type_id;
            let response = await this.requestOrders();
            this.data = response.data;
            this.activeIndex = null;
            this.showData = [];
            this.showMessengerData = [];
        },

        async requestOrders() {
            let response = { state: 500 };
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            await fetch(`/orders_ondemand/${this.currentTab}`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    response = data;
                })
                .catch((err) => console.warn(err));
            return response;
        },

        async getMessengers() {
            let _this = this;
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            await fetch(`/messengers_delivery`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    _this.messengers = data.data;
                })
                .catch((err) => console.warn(err));
        },

        rowTotal(item) {
            let sum = 0;
            item.map((e) => (sum += parseInt(e.value)));
            sum = new Intl.NumberFormat().format(sum);
            return sum;
        },

        rowClick(data, index) {
            this.showData = data;
            this.showMessengerData = data.get_guides[0]?.get_route?.get_messenger
            this.activeIndex = index;
        },

        async assignateDelivery() {
            if (!this.showData) {
                return await error("Debe seleccionar una orden");
            }
            if (!this.setMessenger) {
                return await error("Debe seleccionar un mensajero");
            }
            let _this = this;
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
            myHeaders.append("Accept", "application/json");
            myHeaders.append("Content-Type", "application/json");
            myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "POST",
                headers: myHeaders,
                body: JSON.stringify({
                    messenger_user_id: this.setMessenger.user_id,
                    order_id: this.showData.id,
                }),
            };
            await fetch(`/ordenes/asignacion`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    if (data.state == 500) {
                        return error(data.message);
                    }
                    if (data.state == 200) {
                        let index = _this.data.findIndex(
                            (item) => item.id == _this.showData.id
                        );
                        _this.data.splice(index, 1);
                        return correct(data.message);
                    }
                })
                .catch((err) => console.warn(err));
        },

        async orderState() {
            let req = await fetch("/order_states");
            let res = await req.json();
            this.tabs = res.data;
            this.currentTab = this.tabs[0].id;
            this.tabs[0].href = "pordespachar";
            this.tabs[1].href = "despachados";
            this.tabs[2].href = "completados";
        },
    },

    async mounted() {
        this.orderState();
        this.getOrders(this.currentTab);
        this.getMessengers();
    },
};
</script>

<style>
.active_row {
    background: #2f45b5;
    color: #ffff;
}
</style>
