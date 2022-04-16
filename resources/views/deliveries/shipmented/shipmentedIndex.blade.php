<div class="h-500px d-flex flex-column justify-content-between">
    <table class="table table-sm table-hover">
        <thead class="thead-light">
            <tr class="text-center">
                <th scope="col">Orden</th>
                <th scope="col">Despacho</th>
                <th scope="col">Mensajero</th>
                <th scope="col">Cliente</th>
                <th scope="col">Fecha</th>
                <th scope="col">Valor</th>
                <th scope="col">Barrios</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody class="text-center max-h-300px" style="overflow-y: scroll;">
            <tr v-for="(order, index) in data" :key="data.id" :class="[{'active_row': index === activeIndex}, {'urgent_row': order.urgent_dispatch === 1  && index != activeIndex}]"
            @click="rowClick(order,index)">
                <td v-text="`${order.user_id}-${ order.order_number }`"></td>
                <td v-text="`${order.dispatched}`"></td>
                <td v-text="`${order.get_guides[0]?.get_route?.get_messenger.name} ${ order.get_guides[0]?.get_route?.get_messenger.last_name }`"></td>
                <td v-text=order?.get_user?.name??(order?.get_user?.get_customer?.business_name??(order?.get_user?.get_customer?.tradename??'---'))></td>
                <td v-text="`${ order.schedule_date }|${ order.schedule_time }`"> </td>
                <td v-text="`$${rowTotal(order.get_guides)}`"></td>
                <td v-text="`${ order.get_guides[0]?.address_description}`"></td>
                <td>Pendiente</td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex flex-row flex-wrap align-items-center justify-content-between border-top pt-3">

            <div class="col-md-8 d-flex flex-row flex-wrap">
                <div class="form-group py-3 m-0 col-md-4">
                    <label>Nro Mensajero:</label>
                    <input type="number" class="form-control" v-if="showData" disabled v-bind:value="`${showData.get_guides[0]?.get_route?.get_messenger.document_number}`" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group py-3 m-0 col-md-3">
                    <label>Orden:</label>
                    <input type="text" class="form-control" v-if="showData" disabled v-bind:value="`${showData.user_id}-${ showData.order_number }`" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group py-3 m-0 col-md-5">
                    <label>Cliente:</label>
                    <input type="text" class="form-control" v-if="showData" disabled v-bind:value="`${showData.get_user?.name} ${showData.get_user?.last_name}`" />
                    <span class="form-text text-muted"></span>
                </div>
            </div>
            <div class="col-md-3 text-right">
                <button type="reset" class="btn btn-light-danger font-weight-bold">Limpiar</button>
            </div>
        <div class="col-md-12">
            <div class="d-flex flex-row flex-wrap">
                <div class="col-md-7">
                    <p class="mb-0">
                        <span class="font-weight-bolder mb-3">Cantidad: </span>
                        <span class="line-height-xl" v-text="`${new Intl.NumberFormat().format(ordersQuantity)}`"></span>,
                        <span class="font-weight-bolder mb-3">Valor: </span>
                        <span class="line-height-xl" v-text="`${'$'+new Intl.NumberFormat().format(ordersTotalValue)}`"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
