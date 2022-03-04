<!-- This is source file -->
<template>
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Despachos Packing</h3>
            </div>
        </div>
        <div class="card-body">
            <div
                class="d-flex align-items-center justify-content-between flex-row flex-wrap mb-3"
            >
                <div class="form-group col-md-2 mb-0">
                    <select class="form-control" v-model="selected" @change="loadingEvt(),getGuides(null)">
                        <option
                            v-for="item of delivery_types"
                            v-bind:key="item.value"
                            v-bind:value="item.value"
                        >
                            {{ item.text }}
                        </option>
                        <!-- <option>Entrega</option> -->
                    </select>
                </div>
                <div class="col-md-8 d-flex align-items-center flex-row flex-wrap">
                    <div class="col-md-5 py-2" >
                        <div class=" border rounded" v-if="type_guide == 33 ||  type_guide == 36">
                            <p class="mb-0">
                                <span class="font-weight-bolder mb-3"
                                    >Destinos en recogida por editar:
                                </span>
                                <span class="line-height-xl">2000</span>
                            </p>
                        </div>
                    </div>
                    <div class="form-group col-md-3 mb-0">
                        <select class="form-control" id="delivery_event_state"  v-if="type_guide == 33 ||  type_guide == 36">
                            <option>Seleccione estado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button
                            type="button"
                            class="btn btn-light-primary font-weight-bold"
                            v-if="type_guide == 33 ||  type_guide == 36"
                        >
                            Aplicar nuevo estado
                        </button>
                    </div>
                    <div class="col-md-1">
                        <span class="h5">1/100</span>
                    </div>
                </div>
            </div>
            <ul
                class="nav nav-tabs nav-tabs-line nav-tabs-line-3x nav-bolder"
                id="myTab"
                role="tablist"
            >
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link active"
                        id="porRecoger-tab"
                        data-toggle="tab"
                        href="#porRecoger"
                        role="tab"
                        aria-controls="porRecoger"
                        aria-selected="true"
                        @click="getGuides(0)"
                        >Por {{ selected == 31 ? "Entregar" : "Recoger" }}</a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link"
                        id="enproceso-tab"
                        data-toggle="tab"
                        href="#enproceso"
                        role="tab"
                        aria-controls="enproceso"
                        aria-selected="false"
                        @click="getGuides(1)"
                        >{{ selected == 31 ? "Entregas" : "Recogidas" }} en
                        proceso</a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link"
                        id="consultas-tab"
                        data-toggle="tab"
                        href="#consultas"
                        role="tab"
                        aria-controls="consultas"
                        aria-selected="false"
                        @click="getGuides(2)"
                        >Consultas y edición</a
                    >
                </li>
            </ul>
           <div class="d-flex flex-row flex-wrap">
                <div class="col-md-9">
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active"
                    id="porRecoger"
                    role="tabpanel"
                    aria-labelledby="porRecoger-tab">
                    <!-- Draggable component -->
                        <draggables :selected=selected :guides=guides :guides2=guides2 :messengers=messengers ref="childcomponent"></draggables>

                </div>
                <div
                    class="tab-pane fade"
                    id="enproceso"
                    role="tabpanel"
                    aria-labelledby="enproceso-tab"
                >
                    <!-- In process table -->
                    <tabledy :rows=columns.inProcess.length :guides=guides :columnsNames=columns.inProcess :widthTable=1100></tabledy>
                </div>
                <div
                    class="tab-pane fade"
                    id="consultas"
                    role="tabpanel"
                    aria-labelledby="consultas-tab"
                >
                    <!-- Queries and Edit table -->
                    <tabledy :rows=columns.inEdit.length :guides=guides :columnsNames=columns.inEdit :widthTable=1600></tabledy>
                </div>
            </div>
            </div>
            <div class="col-md-3 py-4">
                <div class="d-flex flex-row flex-wrap align-items-center justify-content-center">
                    <a href="#" class="btn btn-light-success btn-block font-weight-bold mr-2">Imprimir Guia</a>
                    <button v-if="type_guide == 33 ||  type_guide == 36" type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-light-primary btn-block font-weight-bold mr-2">Editar Destino</button>
                </div>
                <div class="d-flex flex-row flex-wrap scroll scroll-pull mt-3 mb-3 border py-2 max-h-250px">
                    <h5 class="mb-5 font-weight-bold text-dark col-md-12">Información de Destino</h5>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Tipo de orden:</div>
                        <div class="line-height-xl">Packing</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente:</div>
                        <div class="line-height-xl">Juanito Perez</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Destino:</div>
                        <div class="line-height-xl">3534534</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Despacho:</div>
                        <div class="line-height-xl">0</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Ref.Cliente:</div>
                        <div class="line-height-xl">---</div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Programado:</div>
                        <div class="line-height-xl">2022/02/04</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Transporte:</div>
                        <div class="line-height-xl">Moto</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Movil:</div>
                        <div class="line-height-xl">381, YEMAYEL ARIEL</div>
                    </div>
                    <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente Depto:</div>
                        <div class="line-height-x1">84: PRINCIPAL</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente Sucursal:</div>
                        <div class="line-height-x1">1179: PRINCIPAL</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente Documento:</div>
                        <div class="line-height-x1">1191: DELIVERY</div>
                    </div>
                    <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Concepto:</div>
                        <div class="line-height-xl">RETIRAR FIANZA A NOMBRE DE EDEMET</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Dirección:</div>
                        <div class="line-height-xl">CLL 50: SAN FRANCISCO: PANAMA</div>
                    </div>
                </div>
                <div class="d-flex flex-row flex-wrap max-h-200px mb-3 pb-3 justify-content-center">
                    <h5 class="mb-5 font-weight-bold text-dark col-md-12">Adjuntos</h5>
                    <div class="col-md-12 symbol-group symbol-hover">
                        <div class="symbol">
                            <img alt="Pic" src="https://placem.at/things?h=100"/>
                        </div>
                        <div class="symbol">
                            <img alt="Pic" src="https://placem.at/things?h=100"/>
                        </div>
                        <div class="symbol">
                            <img alt="Pic" src="https://placem.at/things?h=100"/>
                        </div>
                    </div>
                </div>
            </div>
           </div>
        </div>
        <modalEdit></modalEdit>
    </div>
</template>
<script>
import draggables from "./draggable.vue";
import tabledy from "./tableDynamic.vue";
import modalEdit from "./modalEditComponent.vue";
export default {
    components: {
        draggables,
        tabledy,
        modalEdit
    },
    data() {
        return {
            selected: 31,
            delivery_types: [
                { value: 31, text: "Entregas" },
                { value: 34, text: "Recogidas" },
            ],
            showModal: false,
            columns:{
                inProcess:["Tipo", "Estado", "Fecha evento", "Despacho", "Destino", "F.Prog", "Mensajero", "Estado App", "Cliente", "Contacto", "Barrio/Zona", "Dirección"],
                inEdit:["Tipo", "Estado", "Estado Web", "Estado Web Cont", "Fecha evento", "Despacho", "Destino", "ExtRef", "F.Prog", "Tipo Doc", "Mensajero", "Estado App", "Cliente", "Contacto", "Barrio/Zona", "Dirección", "DeptoId", "Dept Nombre", "SucId", "Suc Nombre", "DocId", "Doc Nombre"],
            },
            guides: [],
            guides2: [],
            messengers: [],
            type_guide: 31,

        };
    },

    methods: {
        loadingEvt (){
           $(`#myTab li:nth-child(1) a`).tab("show");
       },
        async getGuides(type) {
            this.type_guide = this.selected + type;
            let response = await this.requestGuides();
            this.guides = response.data;
            this.guides2 = [];
        },
        async requestGuides() {
            let response = { state: 500 };
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            await fetch(`/orders_packing/${this.type_guide}`, requestOptions)
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
    },

     async mounted() {
        // this.orderState();
        this.getGuides(null);
        this.getMessengers();
    },

};
</script>
