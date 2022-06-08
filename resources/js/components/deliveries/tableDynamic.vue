<template>
    <div class="d-flex flex-row flex-wrap mt-4">
        <h5 class="font-weight-bold text-dark col-md-12 px-0"> Lista de Destinos</h5>
        <div class="d-flex flex-row flex-wrap col-md-12 px-0">
            <div class="form-group col-md-6 pl-0">
                <label class="font-weight-bolder">Filtro</label>
                <input type="text" class="form-control"  placeholder="Filtro"/>
            </div>
            <div class="form-group col-md-6 pr-0">
                <label class="font-weight-bolder">Fecha de evento Desde/Hasta</label>
                <div class="d-flex flex-row flex-wrap">
                    <input type="date" class="form-control col-5 mr-2" />
                    <input type="date" class="form-control col-5" />
                </div>
            </div>
        </div>
        <div class="table-responsive col-md-12 px-0 border rounded h-400px">
            <table class="table table-sm table-bordered" :style="{'width': widthTable+'px', 'table-layout': 'auto'}">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th scope="col" v-for="item of columnsNames" :key="item">{{item}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        :class="[{'sortableSelected': index === activeIndex}]"
                        style="cursor: pointer"
                        v-for="(tblItem, index) of guides"
                        v-bind:key="tblItem.id"
                        @click="rowClick(tblItem, index)"
                        class="text-center">
                        <td>{{tblItem.get_order.order_type == 36 ? 'Packaging': tblItem.get_order.order_type}}</td>
                        <td>{{tblItem.get_status_matrix.name}}</td>  
                        <td>{{''}}</td>
                        <td>{{tblItem.dispatched}}</td>
                        <td>{{tblItem.id}}</td>
                        <td>{{tblItem.get_order.schedule_date}}</td> 
                        <td>{{tblItem.get_route.get_messenger.name +' '+ tblItem.get_route.get_messenger.last_name}}</td>
                        <td>{{tblItem.app_status == 0 ? 'Pendiente' : 'Leido'}}</td>
                        <td>{{tblItem.get_order.get_user.name}}</td>
                        <td>{{tblItem.contact}}</td>
                        <td>{{''}}</td>
                        <td>{{tblItem.address_name}}</td>
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
        return{
            activeIndex: null,
        }
    },
    methods: {
        rowClick(data, index) {
            this.activeIndex = index;
            this.$emit("getGuide", data);
        },

    }
}
</script>
