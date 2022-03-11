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
                    <select class="form-control" v-model="selected" @change="loadingEvt(),getGuides(selected)">
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
                        <div class=" border rounded">
                            <p class="mb-0">
                                <span class="font-weight-bolder mb-3"
                                    >Destinos en recogida por editar:
                                </span>
                                <span class="line-height-xl">2000</span>
                            </p>
                        </div>
                    </div>
                    <div class="form-group col-md-3 mb-0">
                        <select class="form-control" id="delivery_event_state" >
                            <option>Seleccione estado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button
                            type="button"
                            class="btn btn-light-primary font-weight-bold"

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
                <li  class="nav-item"  v-for="(tab) in tabs" :key="tab.id" >
                    <a
                    class="nav-link tablink"
                    @click="getGuides(tab.id)"
                    :class="{'active': type_guide === tab.id}"
                    :id="tab.id"  data-toggle="tab"
                    :href="`#${tab.href}`"
                    v-text=tab.name></a>
                </li>
                <!-- <li class="nav-item" role="presentation">
                    <a
                        class="nav-link active"
                        id="porRecoger-tab"
                        data-toggle="tab"
                        href="#porRecoger"
                        role="tab"
                        aria-controls="porRecoger"
                        aria-selected="true"
                        @click="getGuides(0)"
                        >Por {{ selected == 32 ? "Entregar" : "Recoger" }}</a
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
                        >{{ selected == 32 ? "Entregas" : "Recogidas" }} en
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
                </li> -->
            </ul>
           <div class="d-flex flex-row flex-wrap">
                <div class="col-md-9">
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active"
                    id="porRecoger"
                    role="tabpanel"
                    aria-labelledby="porRecoger-tab">
                    <!-- Draggable component -->
                    <draggables :selected=selected @getGuide="getGuide" :guides=guides :guides2=guides2 :tabs=tabs :messengers=messengers ref="childcomponent"></draggables>

                </div>
                <div
                    class="tab-pane fade"
                    id="enproceso"
                    role="tabpanel"
                    aria-labelledby="enproceso-tab"
                >
                    <!-- In process table -->
                    <tabledy :rows=columns.inProcess.length @getGuide="getGuide" :guides=guides :tabs=tabs :columnsNames=columns.inProcess :widthTable=1100></tabledy>
                </div>
                <div
                    class="tab-pane fade"
                    id="consultas"
                    role="tabpanel"
                    aria-labelledby="consultas-tab"
                >
                    <!-- Queries and Edit table -->
                    <tabledy :rows=columns.inEdit.length @getGuide="getGuide" :guides=guides :tabs=tabs :columnsNames=columns.inEdit :widthTable=1600></tabledy>
                </div>
            </div>
            </div>
            <div class="col-md-3 py-4">
                <div class="d-flex flex-row flex-wrap align-items-center justify-content-center">
                    <a href="#" class="btn btn-light-success btn-block font-weight-bold mr-2">Imprimir Guia</a>
                    <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-light-primary btn-block font-weight-bold mr-2">Editar Destino</button>
                </div>
                <div class="d-flex flex-row flex-wrap scroll scroll-pull mt-3 mb-3 border py-2 max-h-250px">
                    <h5 class="mb-5 font-weight-bold text-dark col-md-12">Información de Destino</h5>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Tipo de orden:</div>
                        <div class="line-height-xl" v-if="showGuide != null" v-text="showGuide.get_order.get_order_type.name"></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente:</div>
                        <div class="line-height-xl" v-if="showGuide != null" v-text="showGuide.get_order.get_user.name"></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Destino:</div>
                        <div class="line-height-xl" v-if="showGuide != null" v-text="showGuide.id"></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Despacho:</div>
                        <div class="line-height-xl" v-if="showGuide != null"  v-text="showGuide.dispatched"></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Ref.Cliente:</div>
                        <div class="line-height-xl" v-if="showGuide != null" v-text="showGuide.get_order.get_user.document_number"></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Programado:</div>
                        <div class="line-height-xl">2022/02/04</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Transporte:</div>
                        <div class="line-height-xl"  v-if="showGuide != null"  v-text="showGuide.get_transport_type.name" ></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Movil:</div>
                        <div class="line-height-xl" v-if="if_route == true"  v-text="showGuide.get_route.get_messenger.name+' '+showGuide.get_route.get_messenger.last_name"></div>
                    </div>
                    <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente Depto:</div>
                        <div class="line-height-x1" v-if="if_department == true" v-text="showGuide.get_branch_office.get_department.get_department.id+':'+showGuide.get_branch_office.get_department.get_department.name" >84: PRINCIPAL</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente Sucursal:</div>
                        <div class="line-height-x1" v-if="showGuide != null" v-text="showGuide.get_branch_office.id+': '+showGuide.get_branch_office.name">1179: PRINCIPAL</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente Documento:</div>
                        <div class="line-height-x1">1191: DELIVERY</div>
                    </div>
                    <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Concepto:</div>
                        <div class="line-height-xl" v-if="showGuide != null" v-text="showGuide.concept" ></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Dirección:</div>
                        <div class="line-height-xl" v-if="showGuide != null" v-text="showGuide.address_name"></div>
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
            selected: 55,
            delivery_types: [
                { value: 55, text: "Entregas" },
                { value: 53, text: "Recogidas" },
            ],
            showModal: false,
            columns:{
                inProcess:["Tipo", "Estado", "Fecha evento", "Despacho", "Destino", "F.Prog", "Mensajero", "Estado App", "Cliente", "Contacto", "Barrio/Zona", "Dirección"],
                inEdit:["Tipo", "Estado", "Estado Web", "Estado Web Cont", "Fecha evento", "Despacho", "Destino", "ExtRef", "F.Prog", "Tipo Doc", "Mensajero", "Estado App", "Cliente", "Contacto", "Barrio/Zona", "Dirección", "DeptoId", "Dept Nombre", "SucId", "Suc Nombre", "DocId", "Doc Nombre"],
            },
            guides: [],
            guides2: [],
            messengers: [],
            type_guide: 3,
            showGuide: null,
            activeIndex: 2,
            tabs: [],
            if_route: false,
            if_department: false,

        };
    },

    methods: {
        loadingEvt (){
           $(`#myTab li:nth-child(1) a`).tab("show");
       },
        async statusMatrix(scope) {
            //STATUS MATRIX
            let req = await fetch(`/matriz_estados?scope_id=${scope}`);
            let res = await req.json();
            // take the first 3 data from the consulate
            this.tabs = res.data.slice(0, 3);

            //#HREF TAB
            this.tabs[0].href = "porRecoger";
            this.tabs[1].href = "enproceso";
            this.tabs[2].href = "consultas";

            //NAME TABS
            this.tabs[2].name = "CONSULTA Y EDICIÓN";
            this.selected == 54?  this.tabs[1].name = "RECOGIDA EN PROCESO" : this.tabs[1].name = "ENTREGA EN PROCESO";
            this.selected == 55?  this.tabs[0].name = "POR RECOGER" : this.tabs[0].name = "POR ENTREGAR";
        },


        getGuide(data){
            this.showGuide = data;
            this.showGuide.get_route ? this.if_route = true : this.if_route = false;
            this.showGuide.get_branch_office.get_department ? this.if_department = true : this.if_department = false;

        },
        async getGuides(type) {

            this.statusMatrix(this.selected);
            // if(type !=null){
            //     this.type_guide = type
            // }
            if(type == 55){
                this.type_guide = 3
            }
            if(type == 53){
                this.type_guide = 7
            }

            let response = await this.requestGuides();
            this.guides = response.data;
            this.guides2 = [];
            this.showGuide = null;
            this.type_guide = type;
        },
        async requestGuides() {
            console.log(this.type_guide )
            let response = { state: 500 };
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            // console.log(this.type_guide)
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
        this.getGuides(null);
        this.getMessengers();
    },

};
</script>
