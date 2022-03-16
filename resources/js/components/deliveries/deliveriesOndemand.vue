<script>
import moment from 'moment';
export default {
    data() {
        return {
            orders: [],
            activeIndex: null,
            shipmented: [],
            completed: [],
            showData: "",
            ordersQuantity: "",
            ordersTotalValue: 0,
            tabs: [],
            currentTab: 3,
            showMessengerData:[],
            messengers: [],
            searchMessenger: null,
            messenger: null,
            messengerName: null,
            checkAllOrders: false,
            startDate: moment(Date.now()).format("YYYY-MM-DD"),
            endDate: moment(Date.now()).format("YYYY-MM-DD"),
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
        data() {
            if(this.checkAllOrders == false){
                return this.orders.filter((item) => {
                    return this.localizeDate(item.schedule_date) >= this.localizeDate(this.startDate)
                    && this.localizeDate(item.schedule_date) <= this.localizeDate(this.endDate)
                });
            }else{
                 return this.orders;
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

          async statusMatrix() {
            let scope_id = 55
            let req = await fetch(`despacho/matriz_estados?scope_id=${scope_id}`);
            let res = await req.json();
            this.tabs = res.data.slice(0, 3);
            this.currentTab = this.tabs[0].id;
            this.tabs[0].href = "pordespachar";
            this.tabs[1].href = "despachados";
            this.tabs[2].href = "completados";
            this.tabs[2].name = "COMPLETADOS";

        },
        localizeDate(date) {
            if (!date || !date.includes('-')) return date
            const [yyyy, mm, dd] = date.split('-')
            return new Date(`${mm}/${dd}/${yyyy}`)
        },

        async getOrders(type_id, index) {
            index != undefined &&
                $(`#myTab li:nth-child(${index + 1}) a`).tab("show");

            this.currentTab = type_id;
            let response = await this.requestOrders();
            this.orders = response.data;
            // this.data = this.orders;
            this.activeIndex = null;
            this.showData = "";
            this.ordersQuantity= "";
            this.ordersTotalValue= 0;

            for (let i = 0; i < this.orders.length; i++) {
                let sum = 0;
                for (let x = 0; x < this.orders[i].get_guides.length; x++) {
                    sum += this.orders[i].get_guides[x].value;
                }
                this.ordersTotalValue += sum;
            }
            this.ordersQuantity = this.orders.length;
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
                    state: this.tabs[1].id
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

        },


        async updateStateOrders(){
            if (!this.showData) {
                return await error("Debe seleccionar una orden");
            }
            let result = await confirmation('¿Estas Seguro?','Se cambiara el estado de la orden', 'info');
            if (result == true) {
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
                        order_id: this.showData.id,
                        state: this.tabs[1].id, //id tap por despachar
                    }),
                };
                await fetch(`/despacho/orden/estado`, requestOptions)
                    .then((response) => response.json())
                    .then(function (data) {
                        console.log(data)
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
            }

        }
    },

    async mounted() {
        this.statusMatrix();
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

.urgent_row {
    background: #d31928;
    color: #ffff;
}
</style>
