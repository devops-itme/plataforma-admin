<div class="h-500px d-flex flex-column justify-content-between">
    <table class="table table-sm table-hover">
        <thead class="thead-light">
            <tr class="text-center">
                <th scope="col">Orden</th>
                <th scope="col">Cliente</th>
                <th scope="col">Fecha</th>
                <th scope="col">Valor</th>
                <th scope="col">Barrios</th>
            </tr>
        </thead>
        <tbody class="text-center max-h-300px" style="overflow-y: scroll">
            <tr v-for="(order, index) in data" :key="data.id" :class="[{'active_row': index === activeIndex}]"
                @click="rowClick(order,index)">
                <td v-text="`${order.user_id}-${ order.order_number }`"></td>
                <td v-text=order.get_user.name></td>
                <td v-text="`${ order.schedule_date }|${ order.schedule_time }`"> </td>
                <td v-text="`$${rowTotal(order.get_guides)}`"></td>
                <td>Boston City</td>
            </tr>
        </tbody>
    </table>
    <div class="d-flex flex-row flex-wrap align-items-stretch border-top pt-3">
        <a href="#" class="btn btn-light-primary d-flex align-items-center btn-lg col-md-2">
            <span class="svg-icon">
                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Design/Flatten.svg-->
                <i class="fad fa-globe-americas"></i>
                <!--end::Svg Icon-->
            </span>Ver mapa</a>
        <div class="col-md-10">
            <div class="d-flex flex-row flex-wrap">
                <div class="col-md-5">
                    <p class="mb-2">
                        <span class="font-weight-bolder mb-3">Orden seleccionada: </span>
                        <span class="line-height-xl" v-show="showData.id"
                        v-text="`${showData.user_id}-${ showData.order_number }`"></span>
                    </p>
                    <div class="mb-2 d-flex flex-row flex-wrap align-items-center justify-content-between">
                        <span class="font-weight-bolder mb-0">Nro Mensajero: </span>
                        <input type="number" class="form-control col-7"  v-model="searchMessenger" >
                    </div>
                    <div class="mb-0">
                        <input type="text" class="form-control col-12" disabled v-if="setMessenger" v-model="messengerName">
                    </div>
                </div>
                <div class="col-md-7">
                    <p class="mb-0 text-right">
                        <span class="font-weight-bolder mb-3">Cantidad: </span>
                        <span class="line-height-xl">7</span>,
                        <span class="font-weight-bolder mb-3">Valor: </span>
                        <span class="line-height-xl">$120.00</span>
                    </p>
                    <div class="d-flex flex-row flex-wrap align-items-center justify-content-between">
                        <div class="form-group col-md-8 mb-0 py-0">
                            <label>Pago por:</label>
                            <div class="radio-inline">
                                <label class="radio radio-rounded">
                                    <input type="radio" checked="checked" name="pay_comision" value="1" />
                                    <span></span>
                                    Comisón
                                </label>
                                <label class="radio radio-rounded">
                                    <input type="radio" name="pay_comision" value="0" />
                                    <span></span>
                                    Exclusividad
                                </label>
                            </div>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="col-md-3">
                            <a @click="assignateDelivery()" class="btn btn-light-success font-weight-bold mr-2">Despachar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
