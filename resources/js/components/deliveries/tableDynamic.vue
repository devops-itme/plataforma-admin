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
            <input type="text" class="form-control" placeholder="Filtro" v-model="search" />
            <!--  <input type="text" class="form-control" placeholder="Filtro" v-for="a in this.guidess" v-model="a.address_name" disabled v-if="contact"/> -->
            <table class="table table-sm table-bordered"
                :style="{ 'width': widthTable + 'px', 'table-layout': 'auto' }">
                <thead class="thead-light">
                 <tr class="text-center">
                        <th>Tipo </th>
                        <th>Estado <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_estado_asc" ></i> <i class="fa fa-sort-down" @click="sorted_estado_desc " ></i> </div> </th>
                        <th>Fecha Evento <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_evento_asc" ></i> <i class="fa fa-sort-down" @click="sorted_evento_desc " ></i> </div></th>
                        <th>Despacho <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_despacho_asc" ></i> <i class="fa fa-sort-down" @click="sorted_despacho_desc " ></i> </div></th>
                        <th>Destino <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_destino_asc" ></i> <i class="fa fa-sort-down" @click="sorted_destino_desc " ></i> </div></th>
                        <th>F.Prog <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_fecha_prog_asc" ></i> <i class="fa fa-sort-down" @click="sorted_fecha_prog_desc " ></i> </div></th>
                        <th>H.Entrega <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_hora_ent_asc" ></i> <i class="fa fa-sort-down" @click="sorted_hora_ent_desc " ></i> </div></th>
                        <th>Mensajero <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_mensajero_asc" ></i> <i class="fa fa-sort-down" @click="sorted_mensajero_desc " ></i> </div></th>
                        <th>Estado App <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_estado_app_asc" ></i> <i class="fa fa-sort-down" @click="sorted_estado_app_asc " ></i> </div></th>
                        <th>Cliente <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_cliente_asc" ></i> <i class="fa fa-sort-down" @click="sorted_cliente_desc " ></i> </div></th>
                        <th>Contacto <div style="display: flex; flex-direction: column;´"> <i class="fa fa-sort-up"  @click="sorted_contacto_asc" ></i> <i class="fa fa-sort-down" @click="sorted_contacto_desc " ></i> </div></th>
                        <th>Barrio/Zona</th>
                        <th>Dirección <div style="display: flex; flex-direction: column;"> <i class="fa fa-sort-up"  @click="sorted_direccion_asc" ></i> <i class="fa fa-sort-down" @click="sorted_direccion_desc " ></i> </div></th>
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
            search: '',
            sortedData: [],
            sortedbyASC: true
        }
    },

mounted() {
    this.sortedData = this.guides;
    console.log(this.sortedData);
  },


    computed: {

       guidess() {
        const search = this.search.toLowerCase().trim();


            return this.guides.filter((tblItem) => {
                  const full_name =  tblItem.get_order.get_user.name  + ' ' + tblItem.get_order.get_user.last_name ;
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
                    //tblItem.get_order.order_type.toLowerCase().includes(this.search) ||
                    tblItem.get_status_matrix.name.toLowerCase().includes(search) ||
                    tblItem.get_order.created_at.toLowerCase().includes(search) ||
                    tblItem.dispatched.toLowerCase().includes(search) ||
                    tblItem.id.toString().includes(this.search) ||
                    tblItem.get_order.schedule_date.toLowerCase().includes(search) ||
                    tblItem.get_order.schedule_time_range.toLowerCase().includes(search) ||
                    tblItem.get_route.get_messenger.name.toLowerCase().includes(search) ||
                    tblItem.get_route.get_messenger.name.includes(search) ||
                    full_name.toLowerCase().includes(search) ||
                    full_name.includes(search) ||
                    tblItem.contact.toLowerCase().includes(search) ||
                    tblItem.contact.includes(search) ||
                    tblItem.address_name.toLowerCase().includes(search) ||
                    tblItem.address_name.includes(search)
                )
                    }
                }
            })
        }
    },


    methods: {
   //Estado sorting
    sorted_estado_asc(){
         return this.guides.sort((a, b) => a.get_status_matrix.name.localeCompare(b.get_status_matrix.name));
    },

     sorted_estado_desc(){
         return this.guides.sort((a, b) => b.get_status_matrix.name.localeCompare(a.get_status_matrix.name));
    },

     //Evento Sorting
    sorted_evento_asc(){
         return this.guides.sort((a, b) => a.created_at.localeCompare(b.created_at));
    },

     sorted_evento_desc(){
         return this.guides.sort((a, b) => b.created_at.localeCompare(a.created_at));
    },

         //Despacho Sorting
    sorted_despacho_asc(){
         return this.guides.sort((a, b) => a.dispatched.localeCompare(b.dispatched));
    },

     sorted_despacho_desc(){
         return this.guides.sort((a, b) => b.dispatched.localeCompare(a.dispatched));
    },

    //Destino Sorting
    sorted_destino_asc(){   // Molestando
         return this.guides.sort((a, b) => a.tblItem.id.localeCompare(b.tblItem.id));
    },

     sorted_destino_desc(){
         return this.guides.sort((a, b) => b.tblItem.id.localeCompare(a.tblItem.id ));
    },


     //Fecha Prog. Sorting
    sorted_fecha_prog_asc(){
         return this.guides.sort((a, b) => a.get_order.schedule_date.localeCompare(b.get_order.schedule_date));
    },

     sorted_fecha_prog_desc(){
         return this.guides.sort((a, b) => b.get_order.schedule_date.localeCompare(a.get_order.schedule_date));
    },

  //Hora Entrega Sorting
     sorted_hora_ent_asc(){
         return this.guides.sort((a, b) => a.get_order.schedule_time_range.localeCompare(b.get_order.schedule_time_range));
    },

     sorted_hora_ent_desc(){
         return this.guides.sort((a, b) => b.get_order.schedule_time_range.localeCompare(a.get_order.schedule_time_range));
    },

      // Mensajero Sorting
     sorted_mensajero_asc(){
         return this.guides.sort((a, b) => a.get_route.get_messenger.name.localeCompare(b.get_route.get_messenger.name));
    },

     sorted_mensajero_desc(){
         return this.guides.sort((a, b) => b.get_route.get_messenger.name.localeCompare(a.get_route.get_messenger.name));
    },

        // Estado App Sorting
     sorted_estado_app_asc(){
         return this.guides.sort((a, b) => a.app_status.toString() .localeCompare(b.app_status.toString() ));
    },

     sorted_estado_app_desc(){
         return this.guides.sort((a, b) => b.app_status.toString() .localeCompare(a.app_status.toString() ));
    },


//Cliente Sorting
  sorted_cliente_asc(){
         return this.guides.sort((a, b) => a.get_order.get_user.name.localeCompare(b.get_order.get_user.name));
    },

    sorted_cliente_desc(){
         return this.guides.sort((a, b) => b.get_order.get_user.name.localeCompare(a.get_order.get_user.name));
    },

//Cliente Sorting
  sorted_contacto_asc(){
         return this.guides.sort((a, b) => a.contact.localeCompare(b.contact));
    },

    sorted_contacto_desc(){
         return this.guides.sort((a, b) => b.contact.localeCompare(a.contact));
    },

    //Cliente direccion
  sorted_direccion_asc(){
         return this.guides.sort((a, b) => a.address_name.localeCompare(b.address_name));
    },

    sorted_direccion_desc(){
         return this.guides.sort((a, b) => b.address_name.localeCompare(a.address_name));
    },

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
