<template>
    <div>
        <div class="d-flex flex-row flex-wrap py-4">
            <div class="col-md-6 p-4 d-flex flex-row flex-wrap border-right">
                <div class="col-md-12 d-flex flex-row flex-wrap justify-content-between align-items-center">
                    <h5 class="font-weight-bold text-dark">
                         Destinos por {{ selected == 1 ? "Entregar" : "Recoger" }}
                    </h5>
                    <div class="col-md-2">
                        <button class="btn btn-light-success font-weight-bold btn-block" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Filtrar
                        </button>
                    </div>
                </div>
                <div class="collapse col-md-12" id="collapseExample">
                    <input type="text" class="form-control" placeholder="Filtrar"/>
                </div>
                <div class="min-h-500px col-md-12">
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
                                @start="drag = true"
                                @end="drag = false" style="cursor: move;">
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
            <div class="col-md-6 p-4 d-flex flex-row flex-wrap">
                <div class="col-md-12 d-flex flex-row flex-wrap justify-content-between align-items-center">
                    <h5 class="font-weight-bold text-dark">
                        Seleccionados por {{ selected == 1 ? "Entregar" : "Recoger" }}
                    </h5>
                </div>
                <div class="min-h-350px col-md-12">
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
                                @start="drag = true"
                                @end="drag = false" style="cursor: move;">
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
                 <div class="form-group col-md-12">
                        <label class="font-weight-bolder">Mensajero</label>
                       <div class="d-flex flex-row flex-wrap justify-content-around px-0">
                            <input type="text" class="form-control col-md-3" />
                            <input type="text" class="form-control col-md-5" />
                            <a href="#" class="btn btn-light-primary font-weight-bold col-md-3">Despachar</a>
                       </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable";
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
