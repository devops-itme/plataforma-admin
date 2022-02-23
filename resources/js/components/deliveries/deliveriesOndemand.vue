<script>
export default {
    data() {
        return {
            data: [],
            activeIndex: null,
            shipmented: [],
            completed: [],
            showData: "",
            tabs: [
                { id: 1, name: "Por despachar", href: "pordespachar" },
                { id: 2, name: "Despachados", href: "despachados" },
                { id: 3, name: "Completados", href: "completados" },
            ],
            currentTab: 1,

            messengers: [],
            searchMessenger: null,
            messenger: null,
            messengerName: null,
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
    watch: {
    },

    methods: {
        async getOrders(type_id){
            // let tabEl = document.querySelector('button[data-toggle="tab"]')
            //     // tabEl.addEventListener('shown.bs.tab', function (event) {
            //     //     event.target // newly activated tab
            //     //     event.relatedTarget // previous active tab
            //     // })
            //     console.log(tabEl)
            this.currentTab = type_id;
            let response =  await this.requestOrders();
            this.data = response.data
        },

        async requestOrders() {
            let response = {state:500};
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            await fetch(`/orders_delivery/${this.currentTab}`, requestOptions)
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
            await fetch(`/guias/asignacion`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    if (data.state == 500) {
                        return error(data.message);
                    }
                    if (data.state == 200) {
                        let index =_this.data.findIndex(item=>item.id==_this.showData.id);
                        _this.data.splice(index,1);
                        return correct(data.message);
                    }
                })
                .catch((err) => console.warn(err));
        },
    },

    async mounted() {
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
