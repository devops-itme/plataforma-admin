<template>
    <div class="d-flex flex-row flex-wrap mt-4">
        <h5 class="font-weight-bold text-dark col-md-12 px-0"> Lista de Destinos</h5>
        <div class="d-flex flex-row flex-wrap col-md-12 px-0">
            <div class="form-group col-md-6 pr-0">
                <!-- <label class="font-weight-bolder">Fecha de evento Desde/Hasta</label>
                <div class="d-flex flex-row flex-wrap">
                    <input type="date" class="form-control col-5 mr-2" />
                    <input type="date" class="form-control col-5" />
                </div> -->
            </div>
            <div class="form-group col-md-6 pr-0 ">

                <div class="d-flex flex-row-reverse">
                    <button v-if="listData.length != 0 && typeGuide == 5" type="button"
                        class="btn btn-light-primary font-weight-bold"
                        @click="sendToDelivery()">
                        Enviar a Entregas
                    </button>
                </div>
            </div>
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
                    <tr style="cursor: pointer" v-for="tblItem, index in this.guides" @click="rowClick(tblItem, index)" v-bind:class="{ active_row: index === activeIndex, active_list: listData.includes(tblItem.id) } " v-bind:key="index">
                        <td>{{ tblItem.get_order.order_type == 36 ? 'Packing' : tblItem.get_order.order_type }}</td>
                        <td v-if="tblItem.get_status_matrix != null">{{ tblItem.get_status_matrix.name }}</td>
                        <td v-else>--- ---</td>
                        <td>{{ new Date(tblItem.created_at).toLocaleDateString()}}</td>
                        <td>{{ tblItem.dispatched }}</td>
                        <td>{{ tblItem.id }}</td>
                        <td>{{ tblItem.get_order.schedule_date }}</td>
                        <td>{{ tblItem.get_order.schedule_time_range }}</td>
                        <td v-if="tblItem.dispatched != null && tblItem.route != null && tblItem.route.get_messenger != null">{{ tblItem.route.get_messenger.name + ' ' + tblItem.route.get_messenger.last_name }}</td>
                        <td v-else>Sin Asignar</td>
                        <td>{{ tblItem.app_status == 0 ? 'Pendiente' : 'Leido' }}</td>
                        <td v-if="tblItem != null" >{{ tblItem.get_order.get_user.name }}</td>
                        <td v-else>--- ---</td>
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
        typeGuide: Number,
    },
    data() {
        return {
            activeIndex: null,
            listData: [],
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
            // return this.guides.filter((tblItem) => {
            //     return this.contact
            //         .toString()
            //         .toLowerCase()
            //         .split(" ")
            //         .every((v) =>
            //             tblItem.address_name.toLowerCase().includes(v) ||
            //             tblItem.contact.toLowerCase().includes(v) ||
            //             tblItem.get_order.schedule_date.toLowerCase().includes(v) ||
            //             tblItem.get_status_matrix.name.toLowerCase().includes(v) ||
            //             tblItem.dispatched.toLowerCase().includes(v) ||
            //             tblItem.route.get_messenger.name.toLowerCase().includes(v) ||
            //             tblItem.route.get_messenger.last_name.toLowerCase().includes(v) ||
            //             tblItem.get_order.get_user.name.toLowerCase().includes(v)
            //             /* tblItem.id.toLowerCase().includes(v) || */
            //             /*tblItem.get_order.order_type.toLowerCase().includes(v) ||
            //             tblItem.app_status.toLowerCase().includes(v) ||
            //              */
            //         );
            // });

            return this.guides.sort((a, b) => b.updated_at.localeCompare(a.updated_at));

        },

    },
    methods: {
        rowClick(data, index) {
            this.activeIndex = index;
            this.$emit("getGuide", data);
            window.addEventListener('click', ()=>{
                if(!this.listData.includes(data.id) && data.status_matrix_id == 6){
                    this.listData.push(data.id)
                }else{
                    this.listData = []
                }
            })
        },
        async sendToDelivery(){
             let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
                myHeaders.append("Accept", "application/json");
                myHeaders.append('Content-Type', "application/json");
                myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify({
                      'guide_ids': this.listData
                    })
            };
            let response = await this.requestUpdateGuidesState(requestOptions);
            if(response.state != 200){
                error(response.data.message);
            }
            window.location.reload();
            correct(response.data.message)
        },
        async requestUpdateGuidesState(requestOptions){
            let response = {
                'state': 500
            };
            await fetch("guide/estado/recogida-entrega", requestOptions)
                .then((response) => response.json())
                .then(data => {
                    response = data
                })
                .catch(e => console.log('requestUpdateGuide',e));
            return response;
        }
    },
}
</script>

<style>
.active_row {
    background: #2f45b5;
    color: #ffff;
}

.active_list {
    background: #287487;
    color: #ffff;
}
</style>
