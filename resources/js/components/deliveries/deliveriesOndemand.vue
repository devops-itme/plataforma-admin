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
                { id: 2, name: "Despachados", href: "despachados"},
                { id: 3, name: "Completados", href: "completados"},
            ],
            currentTab: 1,

        };
    },
    watch: {},

    methods: {
        async getOrders(type_id) {
            let _this = this;
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            myHeaders.append("Access-Control-Allow-Origin", "*");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            await fetch(`/orders_delivery/${type_id}`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    let orders = data.data;
                    _this.data = orders;
                })
                .catch((err) => console.warn(err));
        },

        rowTotal(item) {
            let sum = 0;
            item.map((e) => (sum += parseInt(e.shipping_cost)));
            sum = new Intl.NumberFormat().format(sum);
            return sum;
        },

        rowClick(data, index) {
            // console.log(data);
            // console.log(this.tabs);
            // console.log(this.currentTab)
            this.showData = data;
            this.activeIndex = index;
        },

    },

    mounted() {
        this.getOrders(this.currentTab);
    },
};
</script>

<style>
.active_row {
    background: #2f45b5;
    color: #ffff;
}
</style>
