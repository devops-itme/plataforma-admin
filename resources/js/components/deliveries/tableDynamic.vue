<template>
    <div class="d-flex flex-row flex-wrap mt-4">
        <h5 class="font-weight-bold text-dark col-md-12 px-0"> Lista de Destinos</h5>
        <div class="d-flex flex-row flex-wrap col-md-12 px-0">
            <!--             <div class="form-group col-md-6 pr-0">
                <label class="font-weight-bolder">Fecha de evento Desde/Hasta</label>
                <div class="d-flex flex-row flex-wrap">
                    <input type="date" class="form-control col-5 mr-2" />
                    <input type="date" class="form-control col-5" />
                </div>
            </div> -->
        </div>
        <div class="table-responsive col-md-12 px-0 border rounded h-400px" id="fil">
            <input type="text" class="form-control" placeholder="Filtro" v-model="contact" />
            <!--  <input type="text" class="form-control" placeholder="Filtro" v-for="a in this.guidess" v-model="a.address_name" disabled v-if="contact"/> -->
            <table class="table table-sm table-bordered"
                :style="{ 'width': widthTable + 'px', 'table-layout': 'auto' }">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th scope="col" v-for="item of columnsNames" :key="item">{{ item }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="cursor: pointer" v-for="tblItem, index in this.guidess" @click="rowClick(tblItem, index)"
                        class="text-center">
                        <td>{{ tblItem.get_order.order_type == 36 ? 'Packaging' : tblItem.get_order.order_type }}</td>
                        <td>{{ tblItem.get_status_matrix.name }}</td>
                        <td>{{ '' }}</td>
                        <td>{{ tblItem.dispatched }}</td>
                        <td>{{ tblItem.id }}</td>
                        <td>{{ tblItem.get_order.schedule_date }}</td>
                        <td>{{ tblItem.get_route.get_messenger.name + ' ' + tblItem.get_route.get_messenger.last_name }}</td>
                        <td>{{ tblItem.app_status == 0 ? 'Pendiente' : 'Leido' }}</td>
                        <td>{{ tblItem.get_order.get_user.name }}</td>
                        <td>{{ tblItem.contact }}</td>
                        <td>{{ '' }}</td>
                        <td>{{ tblItem.address_name }}</td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</template>
<style>
.sortableSelected {
    background-color: #023E8A;
    color: #fff;
}
</style>
<script>
export default {
    props: {
        rows: Number,
        columnsNames: Array,
        widthTable: Number,
        guides: Array,
        tabs: Array,
    },
    data() {
        return {
            activeIndex: null,
            /*  lists: [
                 {
                     additional_address: 'no',
                     additional_email: 'mailcom@gamil.com',
                     additional_phone: '213',
                     address_description: 'Casa Central',
                     address_id: 1,
                     address_lat: '8.537981',
                     address_lng: '-80.782127',
                     address_name: 'Panamá',
                     app_status: 0,
                     branch_office: null,
                     city: null,
                     concept: 'adad',
                     contact: '77777777',
                     corp_value: 0,
                     country: null,
                     created_at: '2022-06-04T20:04:26.000000Z',
                     customer_document_type: '53',
                     declared: null,
                     deleted_at: null,
                 }
             ], */
            contact: ''
        }
    },

    computed: {
        guidess() {

            console.log(this.contact);
            return this.guides.filter((tblItem) => {
                return this.contact
                    .toString()
                    .toLowerCase()
                    .split(" ")
                    .every((v) =>
                        tblItem.address_name.toLowerCase().includes(v) ||
                        tblItem.contact.toLowerCase().includes(v) ||
                        tblItem.get_order.schedule_date.toLowerCase().includes(v) ||
                        tblItem.get_status_matrix.name.toLowerCase().includes(v) ||
                        tblItem.dispatched.toLowerCase().includes(v) ||
                        tblItem.get_route.get_messenger.name.toLowerCase().includes(v) ||
                        tblItem.get_route.get_messenger.last_name.toLowerCase().includes(v) ||
                        tblItem.get_order.get_user.name.toLowerCase().includes(v)
                        /* tblItem.id.toLowerCase().includes(v) || */
                        /*tblItem.get_order.order_type.toLowerCase().includes(v) ||
                        tblItem.app_status.toLowerCase().includes(v) ||
                         */
                    );
            });

        },

    },
    methods: {
        rowClick(data, index) {
            this.activeIndex = index;
            this.$emit("getGuide", data);
        }
    },
}
</script>
