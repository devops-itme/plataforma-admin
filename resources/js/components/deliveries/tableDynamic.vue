<template>
    <div class="d-flex flex-row flex-wrap mt-4">
    <div class="form-group col-md-3 mb-0" >
     <select v-if="typeGuide == 5 && listState.length != 0" class="form-control" style="margin: -30% 0px 0px 339%;"  @change="onChange($event)" v-model="key">  <!--Call run() function-->
    <option value="">Seleccione estado</option>
    <option  v-if="typeGuide == 5" value="3">POR DESPACHAR</option>
    <option  v-if="typeGuide == 5" value="4">DESPACHADO</option>
    <option  v-if="typeGuide == 5" value="6">RECOGIDO</option>
    </select>
    </div>

     <div class="form-group col-md-3 mb-0" >
     <select v-if="typeGuide == 9 && listState.length != 0" class="form-control" style="margin: -30% 0px 0px 223%;"  @change="onChange($event)" v-model="key">  <!--Call run() function-->
    <option value="">Seleccione estado</option>
    <option  v-if="typeGuide == 9" value="7">POR DESPACHAR</option>
    <option  v-if="typeGuide == 9" value="8">DESPACHADO</option>
    <option  v-if="typeGuide == 9" value="10">ENTREGADO</option>
    </select>
    </div>


        <h5 class="font-weight-bold text-dark col-md-12 px-0"> Lista de Destinos</h5>
        <div class="d-flex flex-row flex-wrap col-md-12 px-0">
            <div class="form-group col-md-6 pr-0" >
            <div v-if=" (listState.length != 0 && typeGuide == 5) || (listState.length != 0 && typeGuide == 9)" class="form-group col-md-6 pr-0" style="margin: -19.5% 0px 0px 206%;">
                    <button type="button"
                        class="btn btn-light-primary font-weight-bold"
                        @click="changeState()">
                        Aplicar nuevo estado
                    </button>
                </div>
            </div>
            <div class="form-group col-md-6 pr-0 " style="margin: -5.2% 0px 0px 49%;" >
                <div class="d-flex flex-row-reverse">
                    <button v-if="listData.length != 0 && typeGuide == 5" type="button"
                        class="btn btn-light-primary font-weight-bold"
                        @click="sendToDelivery()">
                        Enviar a entregas
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive col-md-12 px-0 border rounded h-400px" id="fil">
            <input type="text" class="form-control" placeholder="Filtro" v-model="search" />
            <!--  <input type="text" class="form-control" placeholder="Filtro" v-for="a in this.guidess" v-model="a.address_name" disabled v-if="contact"/> -->
            <table id='tabla_packing' class="table table-sm table-bordered"
                :style="{ 'width': widthTable + 'px', 'table-layout': 'auto' }">
                <thead class="thead-light">
                <tr class="text-center">
                        <th style="cursor: pointer" class="text-nowrap">Tipo <i class='fa fa-sort'></i> </th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_estado">Estado <i class='fa fa-sort'></i></th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_evento">Fecha Evento <i class='fa fa-sort'></i> </th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_despacho">Despacho <i class='fa fa-sort'></i> </th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_destino">Destino  <i class='fa fa-sort'></i> </th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_fecha_prog">F.Prog <i class='fa fa-sort'></i> </th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_hora_ent">H.Entrega <i class='fa fa-sort'></i> </th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_mensajero">Mensajero <i class='fa fa-sort'></i> </th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_estado_app">Estado App  <i class='fa fa-sort'></i></th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_cliente">Cliente <i class='fa fa-sort'></i>  </th>
                        <th style="cursor: pointer"  class="text-nowrap" @click="sorted_contacto">Contacto <i class='fa fa-sort'></i> </th>
                        <th style="cursor: pointer" class="text-nowrap">Barrio/Zona <i class='fa fa-sort'></i></th>
                        <th style="cursor: pointer" class="text-nowrap" @click="sorted_direccion">Dirección <i class='fa fa-sort'></i> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="cursor: pointer" v-for="tblItem, index in this.guidess"  v-if="tblItem.get_route != null" @click="rowClick(tblItem, index)" v-bind:class="{ active_row: index === activeIndex, active_list: listData.includes(tblItem.id) } " v-bind:key="index">
                        <td>{{ tblItem.get_order.order_type == 36 ? 'Packing' : tblItem.get_order.order_type }}</td>
                        <td v-if="tblItem.get_status_matrix != null">{{ tblItem.get_status_matrix.name }}</td>
                        <td v-else>--- ---</td>
                        <td>{{ tblItem.created_at.slice(0, 10)}}</td>
                        <td>{{ tblItem.dispatched }}</td>
                        <td>{{ tblItem.id }}</td>
                        <td>{{ tblItem.get_order.schedule_date }}</td>
                        <td>{{ tblItem.get_order.schedule_time_range }}</td>
                        <td v-if="tblItem.dispatched != null && tblItem.get_route != null && tblItem.get_route.get_messenger != null && tblItem.get_route.get_messenger.last_name != null">{{ tblItem.get_route.get_messenger.name + ' ' + tblItem.get_route.get_messenger.last_name }}</td>
                        <td v-if="tblItem.dispatched != null && tblItem.get_route != null && tblItem.get_route.get_messenger != null && tblItem.get_route.get_messenger.last_name == null">{{ tblItem.get_route.get_messenger.name }}</td>
                        <td v-if="tblItem.dispatched != null && tblItem.get_route == null ">Sin Asignar</td>
                        <td>{{ tblItem.app_status ? 'Leido' : 'Pendiente' }}</td>
                        <td v-if="tblItem != null" >{{ tblItem.get_order.get_user.name  + ' ' + tblItem.get_order.get_user.last_name }}</td>
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

import swal from 'sweetalert'
window.swal = swal;

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
            listState: [],
            issue: '',
            suma : '',
            listSelected: [],
            search: '',
            sortedData: [],
            sortedbyASC: true,
            key: "",
            seleccion: "",
        }
    },

mounted() {
    this.sortedData = this.guides;
  },

    computed: {

       guidess() {
        const search = this.search.toLowerCase().trim();

            return this.guides.filter((tblItem) => {
                const full_name =  tblItem?.get_order?.get_user?.name  + ' ' + tblItem?.get_order?.get_user?.last_name ;
                if (tblItem.get_route != null){
                if(this.search == 'leido'){
            return (
                tblItem.app_status == 1 ? 'Leido' : 'Pendiente'.toLowerCase().includes(search)
                )
                    }
            if(this.search == 'pendiente'){
            return (
                tblItem.app_status == 0 ? 'Pendiente' : 'Leido'.toLowerCase().includes(search)
                )
                    }
                if(this.search != 'leido' && this.search != 'pendiente' ){
                return (

                    tblItem?.get_status_matrix.name?.toLowerCase().includes(search) ||
                    tblItem?.get_order?.created_at?.toLowerCase().includes(search) ||
                    tblItem?.dispatched?.toLowerCase().includes(search) ||
                    tblItem?.id.toString().includes(this.search) ||
                    tblItem?.get_order?.schedule_date?.toLowerCase().includes(search) ||
                    tblItem?.get_order?.schedule_time_range?.toLowerCase().includes(search) ||
                    tblItem?.get_route?.get_messenger.name?.toLowerCase().includes(search) ||
                    tblItem?.get_route?.get_messenger.name?.includes(search) ||
                    full_name?.toLowerCase().includes(search) ||
                    full_name?.includes(search) ||
                    tblItem?.contact?.toLowerCase().includes(search) ||
                    tblItem?.contact?.includes(search) ||
                    tblItem?.address_name?.toLowerCase().includes(search) ||
                    tblItem?.address_name?.includes(search)
                )
                    }
                }
            })
        }
    },

    methods: {
        onChange(event) {
       this.seleccion = event.target.value;
       this.listData = [];
    },

    rowClick(data, index) {
            this.activeIndex = index;
            this.$emit("getGuide", data);
            window?.addEventListener('click', ()=>{

                if(!this.listData?.includes(data?.id) && data?.status_matrix_id == 6  ){
                    this.listData.push(data.id)
                    this.listState.push(data.id)
                    this.listSelected = data?.status_matrix_id
                    this.issue = data?.get_issue?.get_issue?.name
                    if(this.issue == undefined){
                        this.issue = 'NO REGISTRA'
                    }

                }

                else if(  data?.status_matrix_id == 4  ){
                    this.listData = []
                    this.listState.push(data.id)
                    this.listSelected = data.status_matrix_id
                    this.issue = data?.get_issue?.get_issue?.name
                    // data = ''
                    if(this.issue == undefined){
                        this.issue = 'NO REGISTRA'
                    }

                }

                else if(  data?.status_matrix_id == 3  ){
                    this.listData = []
                    this.listState.push(data.id)
                    this.listSelected = data?.status_matrix_id
                    this.issue = data?.get_issue?.get_issue?.name

                    if(this.issue == undefined){
                        this.issue = 'NO REGISTRA'
                    }
                }

                else if(  data?.status_matrix_id == 7  ){
                    this.listData = []
                    this.listState.push(data.id)
                    this.listSelected = data?.status_matrix_id
                    this.issue = data?.get_issue?.get_issue?.name

                    if(this.issue == undefined){
                        this.issue = 'NO REGISTRA'
                    }
                }

                else if( data?.status_matrix_id == 8  ){
                    this.listData = []
                    this.listState.push(data.id)
                    this.listSelected = data?.status_matrix_id
                    this.issue = data?.get_issue?.get_issue?.name

                    if(this.issue == undefined){
                        this.issue = 'NO REGISTRA'
                    }

                }
                else if( data?.status_matrix_id == 10  ){
                    this.listData = []
                    this.listState.push(data.id)
                    this.listSelected = data?.status_matrix_id
                    this.issue = data?.get_issue?.get_issue?.name

                    if(this.issue == undefined){
                        this.issue = 'NO REGISTRA'
                    }
                }
                else {
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
            swal({
            title: "Estado Actualizado",
            text: " ",
            icon: 'success',
            timer: 2000,
            buttons: false })
                        .then(function(){
                        location.reload();
                    }
                );
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
        },

  // CHANGE STATE GUIDES

async changeState(){

let answer = '';
// console.log('List Data');
// console.log(this.listData);
 let issue = this.issue;
 let equal = this.listSelected;
 let state_select = this.seleccion;
 let key_word = '';

if (state_select == 3){
    key_word = ' POR DESPACHAR'
}

if (state_select == 4){
    key_word = 'DESPACHADO'
}


if (state_select == 6){
    key_word = 'RECOGIDO'
}

if (state_select == 7 ){
    key_word = ' POR DESPACHAR'
}

if (state_select == 8){
    key_word = 'DESPACHADO'
}

if (state_select == 10){
    key_word = 'ENTREGADO'
}

  if(state_select == ''){
    window.swal({
   title: "Aviso",
    text: "Debe seleccionar un estado",
    icon: "warning",
    buttons: {
    confirm: 'Entendido',
  },
})
  }

  else if(equal == state_select){
    window.swal({
   title: "Aviso",
    text: "Ya esta guía se encuentra en el estado seleccionado: "+key_word,
    icon: "warning",
    buttons: {
    confirm: 'Entendido',
  },
})
  }

  else if(state_select != '' && issue!= 'ENTREGADO' ){

 window.swal({
   title: "Cambio de Estado",
    text: "¿Está seguro que quiere cambiar el estado de la guía a: "+key_word+"?",
    icon: "warning",
    buttons: {
    confirm: 'Si',
    cancel: 'No',
  },
}).then((isConfirm) => {
  if (isConfirm) {
            let response = null;
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
                myHeaders.append("Accept", "application/json");
                myHeaders.append('Content-Type', "application/json");
                myHeaders.append("X-CSRF-TOKEN", token);

            //PICKUP ORDERS
            if (state_select == 3){
                let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify({
                    'guide_ids': this.listState
                    })
            };
            let response = {
                'state': 500
            };
             fetch("guide/estado/recogida-pordespachar", requestOptions)
                .then((response) => response.json())
                .then(data => {
                    response = data
                    swal({
            title: "Estado Actualizado",
            text: " ",
            icon: 'success',
            timer: 2000,
            buttons: false })
                        .then(function(){
                        location.reload();
                }
                );
                })
                .catch(e => console.log('pickupByDispatch',e));
            return response;
            }

            if (state_select == 4){
                let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify({
                    'guide_ids': this.listState
                    })
            };
            let response = {
                'state': 500
            };
             fetch("guide/estado/recogida-despachada", requestOptions)
                .then((response) => response.json())
                .then(data => {
                    response = data
                    swal({
            title: "Estado Actualizado",
            text: " ",
            icon: 'success',
            timer: 2000,
            buttons: false })
                        .then(function(){
                        location.reload();
                }
                );
                })
                .catch(e => console.log('pickupByDispatch',e));
            return response;
            }


            if (state_select == 6){
                 let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify({
                    'guide_ids': this.listState
                    })
            };
            let response = {
                'state': 500
            };
             fetch("guide/estado/recogida-finalizada", requestOptions)
                .then((response) => response.json())
                .then(data => {
                    response = data
                    swal({
            title: "Estado Actualizado",
            text: " ",
            icon: 'success',
            timer: 2000,
            buttons: false })
                        .then(function(){
                        location.reload();
                }
                );
                })
                .catch(e => console.log('pickupByDispatch',e));
            return response;
            }

            //DELIVERY ORDERS
            if (state_select == 7){
               let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify({
                    'guide_ids': this.listState
                    })
            };
            let response = {
                'state': 500
            };
             fetch("guide/estado/entrega-pordespachar", requestOptions)
                .then((response) => response.json())
                .then(data => {
                    response = data
                    swal({
            title: "Estado Actualizado",
            text: " ",
            icon: 'success',
            timer: 2000,
            buttons: false })
                        .then(function(){
                        location.reload();
                }
                );
                })
                .catch(e => console.log('pickupByDispatch',e));
            return response;
            }
            if (state_select == 8){
              let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify({
                    'guide_ids': this.listState
                    })
            };
            let response = {
                'state': 500
            };
             fetch("guide/estado/entrega-despachada", requestOptions)
                .then((response) => response.json())
                .then(data => {
                    response = data
                    swal({
            title: "Estado Actualizado",
            text: " ",
            icon: 'success',
            timer: 2000,
            buttons: false })
                        .then(function(){
                        location.reload();
                }
                );
                })
                .catch(e => console.log('pickupByDispatch',e));
            return response;
            }
            if (state_select == 10){
              let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify({
                    'guide_ids': this.listState
                    })
            };
            let response = {
                'state': 500
            };
             fetch("guide/estado/entrega-finalizada", requestOptions)
                .then((response) => response.json())
                .then(data => {
                    response = data
                    swal({
            title: "Estado Actualizado",
            text: " ",
            icon: 'success',
            timer: 2000,
            buttons: false })
                        .then(function(){
                        location.reload();
                }
                );
                })
                .catch(e => console.log('pickupByDispatch',e));
            return response;
            }

            if(response.state != 200){
                error(response.data.message);
            }

}
})

}
 else if(state_select != '' && issue== 'ENTREGADO'){

     window.swal({
   title: "Aviso",
    text: "No se puede cambiar el estado de una guía que tiene cómo incidencia: ENTREGADO",
    icon: "warning",
    buttons: {
    confirm: 'Entendido',
  },
})

 }
        },

   //Estado sorting
    sorted_estado(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
        return this.guides.sort((a, b) => a?.get_status_matrix?.name?.localeCompare(b?.get_status_matrix?.name));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
        return this.guides.sort((a, b) => b?.get_status_matrix?.name?.localeCompare(a?.get_status_matrix?.name));
    }
    },

     //Evento Sorting
    sorted_evento(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
        return this.guides.sort((a, b) => a?.created_at.localeCompare(b?.created_at));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
    return this.guides.sort((a, b) => b?.created_at.localeCompare(a?.created_at));
    }
    },

         //Despacho Sorting
    sorted_despacho(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
    return this.guides.sort((a, b) => a?.dispatched?.localeCompare(b?.dispatched));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
    return this.guides.sort((a, b) => b?.dispatched?.localeCompare(a.dispatched));
    }
    },

    //Destino Sorting
    sorted_destino(){   // Molestando
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
        return this.guides.sort((a, b) => a?.created_at?.localeCompare(b?.created_at));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
    return this.guides.sort((a, b) => b?.created_at?.localeCompare(a?.created_at));
    }
    },

      //Fecha Prog. Sorting
    sorted_fecha_prog(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
        return this.guides.sort((a, b) => a?.get_order?.schedule_date?.localeCompare(b?.get_order?.schedule_date));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
    return this.guides.sort((a, b) => b.get_order?.schedule_date?.localeCompare(a.get_order?.schedule_date));
    }
    },


  //Hora Entrega Sorting
    sorted_hora_ent(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
        return this.guides.sort((a, b) => a?.get_order?.schedule_time_range.localeCompare(b?.get_order?.schedule_time_range));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
    return this.guides.sort((a, b) => b?.get_order?.schedule_time_range.localeCompare(a?.get_order?.schedule_time_range));
    }
    },

      // Mensajero Sorting
    sorted_mensajero(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
    return this.guides.sort((a, b) => a?.get_route?.get_messenger?.name.localeCompare(b?.get_route?.get_messenger?.name));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
    return this.guides.sort((a, b) => b?.get_route?.get_messenger?.name.localeCompare(a?.get_route?.get_messenger?.name));
    }
    },

        // Estado App Sorting
    sorted_estado_app(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
    return this.guides.sort((a, b) => a?.app_status?.toString().localeCompare(b?.app_status?.toString() ));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
        return this.guides.sort((a, b) => b?.app_status?.toString().localeCompare(a?.app_status?.toString() ));
    }
    },


//Cliente Sorting
    sorted_cliente(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
        return this.guides.sort((a, b) => a?.get_order?.get_user?.name?.localeCompare(b?.get_order?.get_user?.name));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
        return this.guides.sort((a, b) => b.get_order?.get_user?.name?.localeCompare(a.get_order?.get_user?.name));
    }
    },

//Contato Sorting
    sorted_contacto(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
        return this.guides.sort((a, b) => a?.contact?.localeCompare(b?.contact));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
        return this.guides.sort((a, b) => b?.contact?.localeCompare(a?.contact));
    }
    },

   //Cliente direccion
    sorted_direccion(){
        if (this.sortedbyASC) {
        this.sortedData.sort((x, y) => (x[sortBy] > y[sortBy] ? -1 : 1));
        this.sortedbyASC = false;
        return this.guides.sort((a, b) => a?.address_name?.localeCompare(b?.address_name));
    } else {
        this.sortedData.sort((x, y) => (x[sortBy] < y[sortBy] ? -1 : 1));
        this.sortedbyASC = true;
        return this.guides.sort((a, b) => b?.address_name?.localeCompare(a?.address_name));
    }
    }

    }
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
