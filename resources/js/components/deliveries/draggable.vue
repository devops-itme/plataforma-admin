<template>
    <div>
        <div class="d-flex flex-row flex-wrap py-4">
            <div class="col-md-12 d-flex flex-row flex-wrap">
                <div class="col-md-6 p-4 d-flex flex-row flex-wrap border-right">
                    <div class="col-md-12 d-flex flex-row flex-wrap justify-content-between align-items-center px-0">
                        <h5 class="font-weight-bold text-dark">
                            Destinos por
                            {{ selected == 1 ? "Entregar" : "Recoger" }}
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
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Filtrar"
                        />
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
                                        <th scope="col">ExtRef</th>
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
                                    :list="guides"
                                    group="orders"
                                    tag="tbody"
                                    :multi-drag="true"
                                    selected-class="sortableSelected"
                                    @start="drag = true"
                                    @end="drag = false"
                                    style="cursor: move"
                                    @select="handleChange"
                                >
                                    <tr
                                        v-for="tblItem of guides"
                                        v-bind:key="tblItem.id"
                                        class="text-center"
                                    >
                                        <td>{{ tblItem.id }}</td>
                                        <td>{{ tblItem.get_order.order_number }}</td>
                                        <td>{{ tblItem.id }}</td>
                                        <td>777777</td>
                                        <td>28/02/2022</td>
                                        <td>{{ tblItem.get_order.get_user.name }}</td>
                                        <td>{{ tblItem.contact }}</td>
                                        <td>{{ tblItem.zone }}</td>
                                        <td>{{ tblItem.address_name }}</td>
                                        <td>28/02/2022</td>
                                        <td>{{ formatDate(tblItem.created_at) }}</td>
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
                            {{ selected == 1 ? "Entregar" : "Recoger" }}
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
                                        <th scope="col">ExtRef</th>
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
                                    @select="handleChange"
                                    style="cursor: move"
                                >
                                    <tr
                                        v-for="tblItem of guides2"
                                        v-bind:key="tblItem.id"
                                        class="text-center"
                                    >
                                        <td>{{ tblItem.id }}</td>
                                        <td>{{ tblItem.get_order.order_number }}</td>
                                        <td>{{ tblItem.id }}</td>
                                        <td>777777</td>
                                        <td>28/02/2022</td>
                                        <td>{{ tblItem.get_order.get_user.name }}</td>
                                        <td>{{ tblItem.contact }}</td>
                                        <td>{{ tblItem.zone }}</td>
                                        <td>{{ tblItem.address_name }}</td>
                                        <td>28/02/2022</td>
                                        <td>{{ tblItem.created_at }}</td>
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
                            <input type="text" class="form-control col-md-3" />
                            <input type="text" class="form-control col-md-5" />
                            <a
                                href="#"
                                class="btn btn-light-primary font-weight-bold col-md-3"
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
    },
    data() {
        return {
            tabs: [],
            guides: [],
            guides2: [],
            currentTab: 31,
            data: [],

        };
    },
    methods: {
        handleChange(evt) {
            console.log(evt.items);
        },

         formatDate(date) {
             if (date) {
                return moment(String(date)).format('MM/DD/YYYY');
            }
        },

        async getGuides(type_id, index) {
            // index != undefined &&
            //     $(`#myTab li:nth-child(${index + 1}) a`).tab("show");

            this.currentTab = type_id;
            let response = await this.requestGuides();
            this.guides = response.data;
            // this.activeIndex = null;
            // this.showData = [];
            // this.showMessengerData = [];
        },
        async requestGuides() {
            let response = { state: 500 };
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            await fetch(`/orders_packing/${this.currentTab}`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    response = data;
                })
                .catch((err) => console.warn(err));
            return response;
        },

    },
     async mounted() {
        // this.orderState();
        this.getGuides(this.currentTab);
        // this.getMessengers();
    },

};
</script>
