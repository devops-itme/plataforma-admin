<template>
    <div>
        <div class="d-flex flex-row flex-wrap py-4">
            <div class="col-md-12 d-flex flex-row flex-wrap">
                <div class="col-md-6 p-4 d-flex flex-row flex-wrap border-right">
                    <div class="col-md-12 d-flex flex-row flex-wrap justify-content-between align-items-center px-0">
                        <h5 class="font-weight-bold text-dark">
                            Destinos por
                            {{ selected == 57 ? "Entregar" : "Recoger" }}
                        </h5>
                        <div class="col-md-2 px-0">
                            <button
                                class="btn btn-light-success font-weight-bold btn-block"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseExample"
                                aria-expanded="false"
                                aria-controls="collapseExample"
                            >
                                Filtrar
                            </button>
                        </div>
                    </div>
                    <div class="collapse col-md-12 mt-4" id="collapseExample">
                        <input type="text" class="form-control" placeholder="Filtro" v-model.number="search" />
                    </div>
                    <div class="max-h-500px h-500px col-md-12 border rounded px-0 mt-3">
                        <div class="table-responsive h-500px">
                            <table
                                class="table table-sm table-bordered"
                                style="table-layout: auto; width: 1100px"
                            >
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">Orden</th>
                                        <th scope="col">Destino</th>
                                       <!-- <th scope="col">ExtRef</th> -->
                                        <th scope="col">Fecha Prog</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Contacto</th>
                                        <th scope="col">Barrio/Zona</th>
                                        <th scope="col">Dirección</th>
                                        <th scope="col">H.Entrega</th>
                                        <th scope="col">Fecha Creación</th>
                                        <th scope="col">Tipo</th>
                                    </tr>
                                </thead>
                                <draggable
                                    :list="this.guidess"
                                    group="orders"
                                    tag="tbody"
                                    :multi-drag="true"
                                    selected-class="sortableSelected"
                                    @start="drag = true"
                                    @end="drag = false"
                                    style="cursor: move"
                                >
                                    <tr
                                        v-for="tblItem of this.guidess"
                                        v-bind:key="tblItem.id"
                                        class="text-center"
                                        @click="rowClick(tblItem)"
                                    >
                                        <td>{{ tblItem.id }}</td>
                                        <td>{{ tblItem.get_order.order_number }}</td>
                                        <td>{{ tblItem.id }}</td>
                                        <!--<td>777777</td>-->
                                        <td>{{ tblItem.get_order.schedule_date }}</td>
                                        <td>{{ tblItem.get_order.get_user.name  + ' ' + tblItem.get_order.get_user.last_name  }}</td>
                                        <td>{{ tblItem.contact }}</td>
                                        <td>{{ tblItem.zone }}</td>
                                        <td>{{ tblItem.address_name }}</td>
                                        <td>{{ tblItem.get_order.schedule_time_range }}</td>
                                        <td>{{ tblItem.created_at.slice(0, 10) }}</td>
                                        <td>{{ tblItem.get_order.order_type }}</td>
                                    </tr>
                                </draggable>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-4 d-flex flex-row flex-wrap align-items-start">
                    <div class="col-md-12 d-flex flex-row flex-wrap justify-content-between align-items-center py-2">
                        <h5 class="font-weight-bold text-dark">
                            Seleccionados por
                            {{ selected == 57 ? "Entregar" : "Recoger" }}
                        </h5>
                    </div>
                    <div class="max-h-425px h-425px col-md-12 border rounded px-0">
                        <div class="table-responsive h-425px">
                            <table
                                class="table table-sm table-bordered"
                                style="table-layout: auto; width: 1100px"
                            >
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">Orden</th>
                                        <th scope="col">Destino</th>
                                        <!--<th scope="col">ExtRef</th>-->
                                        <th scope="col">Fecha Prog</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Contacto</th>
                                        <th scope="col">Barrio/Zona</th>
                                        <th scope="col">Dirección</th>
                                        <th scope="col">H.Entrega</th>
                                        <th scope="col">Fecha Creación</th>
                                        <th scope="col">Tipo</th>
                                    </tr>
                                </thead>
                                <draggable
                                    :list="guides2"
                                    group="orders"
                                    tag="tbody"
                                    :multi-drag="true"
                                    selected-class="sortableSelected"
                                    @start="drag = true"
                                    @end="drag = false"
                                    style="cursor: move"
                                >
                                    <tr
                                        v-for="tblItem of guides2"
                                        v-bind:key="tblItem.id"
                                        class="text-center"
                                        @click="rowClick(tblItem)"
                                    >
                                        <td>{{ tblItem.id }}</td>
                                        <td>{{ tblItem.get_order.order_number }}</td>
                                        <td>{{ tblItem.id }}</td>
                                        <!--<td>777777</td>-->
                                        <td>{{ tblItem.get_order.schedule_date }}</td>
                                        <td>{{ tblItem.get_order.get_user.name  + ' ' + tblItem.get_order.get_user.last_name  }}</td>
                                        <td>{{ tblItem.contact }}</td>
                                        <td>{{ tblItem.zone }}</td>
                                        <td>{{ tblItem.address_name }}</td>
                                        <td>{{ tblItem.get_order.schedule_time_range }}</td>
                                        <td>{{tblItem.created_at.slice(0, 10) }}</td>
                                        <td>{{ tblItem.get_order.order_type }}</td>
                                    </tr>
                                </draggable>
                            </table>
                        </div>
                    </div>
                    <div class="form-group col-md-12 mb-0 px-0">
                        <label class="font-weight-bolder">Mensajero</label>
                        <div
                            class="d-flex flex-row flex-wrap justify-content-around px-0"
                        >
                            <input type="text" class="form-control col-md-3" v-model="searchMessenger" />

                           <select   class="form-control col-md-5" ref="seleccionado">
                             <option v-if="a.user.last_name != null"  v-for="a in this.filterMessengers" :value="a.user.id" v-bind:key="a.id" >{{a.user.name+ " " +a.user.last_name}}</option>
                             <option v-if="a.user.last_name == null"  v-for="a in this.filterMessengers" :value="a.user.id" v-bind:key="a.id" >{{a.user.name}}</option>
                           </select>

                            <a
                                href="#"
                                class="btn btn-light-primary font-weight-bold col-md-3" @click="assignateDelivery()"
                                >Despachar</a
                            >
                        </div>
                    </div>
                </div>
            </div>

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
// import { Sortable, MultiDrag } from 'sortablejs';
import draggable from "vuedraggable-multi";
import moment from 'moment';
//  Sortable.mount(new MultiDrag());
export default {
    components: {
        draggable,
    },
    props: {
        selected: Number,
        guides: Array,
        guides2: Array,
        messengers: Array,
        tabs: Array,
    },
    data() {
        return {
            showMessengerData:[],
            searchMessenger: null,
            messenger: null,
            messengerName: null,
            activeIndex: null,
            search: ''
        };
    },
    computed: {

        guidess() {
        const search = this.search.toString();
       // const search = this.search.toLowerCase().trim();

            return this.guides.filter((tblItem) => {
            const full_name =  tblItem.get_order.get_user.name  + ' ' + tblItem.get_order.get_user.last_name ;

                   return (
                     //tblItem.get_order.order_type.toLowerCase().includes(this.search) ||
                    tblItem.id.toString().includes(search) ||
                    tblItem.get_order.order_number.toLowerCase().includes(search) ||
                    tblItem.get_order.order_number.includes(search) ||
                   tblItem.get_order.schedule_date.includes(search) ||
                    //tblItem.get_order.schedule_time_range.includes(this.search) ||
                    full_name.toLowerCase().includes(search) ||
                    full_name.includes(search) ||
                    tblItem.contact.toLowerCase().includes(search) ||
                    tblItem.contact.includes(search) ||
                    tblItem.address_name.toLowerCase().includes(search) ||
                    tblItem.address_name.includes(search)
                  //  tblItem.get_order.created_at.toLowerCase().includes(search)
                )


            });
        },

        filterMessengers() {
            if (this.searchMessenger) {
                return this.messengers.filter((item) => {
                    return this.searchMessenger
                        .toString()
                        .toLowerCase()
                        .split(" ")
                        .every((v) =>
                            item.user.document_number?.toLowerCase()?.includes(v) || item.user.name?.toLowerCase()?.includes(v)
                        );
                });
            }
        },

        setMessenger() {
            if (this.searchMessenger) {

                this.seleccionado = this.$refs.seleccionado.value;
                return (this.messenger = this.seleccionado);
            }
        },
    },

    watch: {

    },
    methods: {
        rowClick(data) {
            this.$emit("getGuide", data);
        },

        formatDate(date) {
             if (date) {
                return moment(String(date)).format('MM/DD/YYYY');
            }
        },
        async assignateDelivery() {
            if (this.guides2.length === 0) {
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
                    messenger_user_id: this.setMessenger,
                    guides: this.guides2,
                    state_order: this.tabs[1].id
                }),
            };
            await fetch(`/quias/asignacion`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    if (data.state == 500) {
                        return error(data.message);
                    }
                    if (data.state == 200) {
                        _this.searchMessenger = null;
                        return correct(data.message);
                    }
                })
                .catch((err) => console.warn(err));
        },





    },
    async mounted() {

    },

};
</script>
