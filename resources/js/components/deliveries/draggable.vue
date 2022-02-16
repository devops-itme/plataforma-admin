<template>
    <div>
        <div class="d-flex flex-row flex-wrap py-4">
            <div class="col-md-9 d-flex flex-row flex-wrap">
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
                    <div class="min-h-500px col-md-12 border rounded px-0 mt-3">
                        <div class="table-responsive">
                            <table
                                class="table table-sm"
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
                                    :list="myArray"
                                    group="orders"
                                    tag="tbody"
                                    :multi-drag="true"
                                    selected-class="sortableSelected"
                                    @start="drag = true"
                                    @end="drag = false"
                                    style="cursor: move"
                                >
                                    <tr
                                        v-for="tblItem of myArray"
                                        v-bind:key="tblItem.id"
                                        class="text-center"
                                    >
                                        <td>{{ tblItem.id }}</td>
                                        <td>{{ tblItem.order }}</td>
                                        <td>{{ tblItem.guide }}</td>
                                        <td>{{ tblItem.extref }}</td>
                                        <td>{{ tblItem.progDate }}</td>
                                        <td>{{ tblItem.customer }}</td>
                                        <td>{{ tblItem.contact }}</td>
                                        <td>{{ tblItem.zone }}</td>
                                        <td>{{ tblItem.address }}</td>
                                        <td>{{ tblItem.deliveryTime }}</td>
                                        <td>{{ tblItem.createDate }}</td>
                                        <td>{{ tblItem.type }}</td>
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
                    <div class="min-h-425px col-md-12 border rounded px-0">
                        <div class="table-responsive">
                            <table
                                class="table table-sm"
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
                                    :list="myArray2"
                                    group="orders"
                                    tag="tbody"
                                    :multi-drag="true"
                                    selected-class="sortableSelected"
                                    @start="drag = true"
                                    @end="drag = false"
                                    style="cursor: move"
                                >
                                    <tr
                                        v-for="tblItem of myArray2"
                                        v-bind:key="tblItem.id"
                                        class="text-center"
                                    >
                                        <td>{{ tblItem.id }}</td>
                                        <td>{{ tblItem.order }}</td>
                                        <td>{{ tblItem.guide }}</td>
                                        <td>{{ tblItem.extref }}</td>
                                        <td>{{ tblItem.progDate }}</td>
                                        <td>{{ tblItem.customer }}</td>
                                        <td>{{ tblItem.contact }}</td>
                                        <td>{{ tblItem.zone }}</td>
                                        <td>{{ tblItem.address }}</td>
                                        <td>{{ tblItem.deliveryTime }}</td>
                                        <td>{{ tblItem.createDate }}</td>
                                        <td>{{ tblItem.type }}</td>
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
            <div class="col-md-3">
                <div class="d-flex flex-row flex-wrap align-items-center justify-content-center">
                    <a href="#" class="btn btn-light-success btn-block font-weight-bold mr-2">Imprimir Guia</a>
                    <a href="#" class="btn btn-light-primary btn-block font-weight-bold mr-2">Editar Destino</a>
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
</template>
<style>
    .sortableSelected {
  background-color: yellow;
}
</style>
<script>
// import { Sortable, MultiDrag } from 'sortablejs';
import draggable from "vuedraggable";
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
            myArray: [
                {
                    id: 1,
                    order: "123-1234556",
                    guide: 7377845,
                    extref: 888837,
                    progDate: "12-12-2022",
                    customer: "Juanito Perez",
                    contact: "Carmenza Patiño",
                    zone: "Avenida Siempreviva",
                    address: "Calle 12 # 22 - 22",
                    deliveryTime: "22h",
                    createDate: "22-12-2022",
                    type: "Normal",
                },
                {
                    id: 2,
                    order: "123-1234556",
                    guide: 7377847,
                    extref: 888835,
                    progDate: "12-12-2022",
                    customer: "Juanito Perez",
                    contact: "Carmenza Patiño",
                    zone: "Avenida Siempreviva",
                    address: "Calle 12 # 22 - 22",
                    deliveryTime: "22h",
                    createDate: "22-12-2022",
                    type: "Normal",
                },
            ],
            myArray2: [],
        };
    },
};
</script>
