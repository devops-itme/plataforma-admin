<script>
export default {
    data() {
        return {
            data: [],
            activeIndex: null,
            shipmented: [],
            completed: [],
            showData: [],
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
                        .every((v) => item.user.document_number.toLowerCase().includes(v));
                });
            }
        },

        setMessenger(){
            if (this.searchMessenger) {
                this.messengerName = this.filterMessengers[0]?.user.name+' '+this.filterMessengers[0]?.user.last_name;
                return this.messenger = this.filterMessengers[0];
            }
        },
    },
    watch: {},

    methods: {
        async getOrders(type_id) {
            let _this = this;
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            await fetch(`/orders_delivery/${type_id}`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    _this.data = data.data;
                })
                .catch((err) => console.warn(err));
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
            // console.log(data);
            // console.log(this.tabs);
            // console.log(this.currentTab)
            // console.log(this.messenger);
            this.showData = data;
            this.activeIndex = index;
        },


    },

    mounted() {
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
