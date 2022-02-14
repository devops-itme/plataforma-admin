<template>
    <div>
        <div class="d-flex flex-row flex-wrap py-4">
            <div class="col-md-6 p-4 d-flex flex-row flex-wrap border-right">
                <h5 class="font-weight-bold text-dark">
                    Destinos por {{ selected == 1 ? "Entregar" : "Recoger" }}
                </h5>
                <div class="form-group col-md-12">
                    <label>Filtro</label>
                    <input type="text" class="form-control" />
                </div>
                <div class="min-h-500px col-md-12">
                    <div class="table-responsive">
                    <table class="table table-sm">
                            <thead class="thead-light">
                                <tr>
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
                            <tbody>
                                <tr v-for="tblItem of myArray" v-bind:key="tblItem.id">
                                    <td>{{tblItem.id}}</td>
                                    <td>{{tblItem.order}}</td>
                                    <td>{{tblItem.guide}}</td>
                                    <td>{{tblItem.extref}}</td>
                                    <td>{{tblItem.progDate}}</td>
                                    <td>{{tblItem.customer}}</td>
                                    <td>{{tblItem.contact}}</td>
                                    <td>{{tblItem.zone}}</td>
                                    <td>{{tblItem.address}}</td>
                                    <td>{{tblItem.deliveryTime}}</td>
                                    <td>{{tblItem.createDate}}</td>
                                    <td>{{tblItem.type}}</td>
                                </tr>
                            </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <!-- <draggable
            v-model="myArray"
            group="people"
            @start="drag = true"
            @end="drag = false"
        >
            <div v-for="element in myArray" :key="element.id">
                {{ element.name }}
            </div>
        </draggable> -->
    </div>
</template>
<style>
    thead.thead-light>tr>th{
        width: 50px; padding:0;
    }
    table.table-sm>tbody>tr>td{
        width: 30px !important;
    }
</style>

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
            ],
        };
    },
};
</script>
