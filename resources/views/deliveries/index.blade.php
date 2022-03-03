{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    <deliveries-ondemand inline-template>
        <div class="card card-custom gutter-b">
            <div class="card-header card-header-tabs-line">
                <div class="card-title">
                    <h3 class="card-label">Despachos</h3>
                </div>
                <div class="card-title">
                    <h6 class=" card-label">Desde:</h6>
                    <input type="date" value="2022-10-02" min="2000-01-01" style="margin-right: 20px;" v-model="startDate">
                    <h6 class="card-label">Hasta:</h6>
                    <input type="date" value="2022-10-02" min="2000-01-01" style="margin-right: 10px;" v-model="endDate">
                    <input type="checkbox" id="check" style="margin-right: 5px;" v-model="checkAllOrders">
                    <h6 class=" card-text">Ver todo</h6>
                </div>
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x" id="myTab">
                        <li  class="nav-item"  v-for="(tab, index) in tabs" :key="tab.id" >
                            <a class="nav-link tablink" @click="getOrders(tab.id,index)"
                            :class="{'active': currentTab === tab.id}" :id="tab.id"  data-toggle="tab" :href="`#${tab.href}`" v-text=tab.name></a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#pordespachar">Por despachar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#despachados">Despachados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#completados">Completados</a>
                        </li> --}}
                    </ul>
                    <ul class="overlay-panel-actions-primary">

                    </ul>
                </div>
            </div>
            <div class="card-body px-5">
                <div class="d-flex flex-row flex-wrap">
                    <div class="col-md-8 border-right">
                        <div class="tab-content h-500px">
                            <div class="tab-pane fade show active tabcontent" id="pordespachar" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">
                                @include('deliveries.byShipment.shipmentIndex')
                            </div>
                            <div class="tab-pane fade tabcontent" id="despachados" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                @include('deliveries.shipmented.shipmentedIndex')
                            </div>
                            <div class="tab-pane fade tabcontent" id="completados" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                                @include('deliveries.finished.finishedIndex')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-row flex-wrap scroll scroll-pull mb-3 border-bottom max-h-250px">
                            <h5 class="mb-5 font-weight-bold text-dark col-md-12">Información de orden</h5>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Nro Orden:</div>
                                <div class="line-height-xl" v-show="showData.id"
                                    v-text="`${showData.user_id}-${ showData.order_number }`"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Referencia de cliente:</div>
                                <div class="line-height-xl" v-show="showData.id" v-text="`${showData.user_id}`"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Tipo de orden:</div>
                                <div class="line-height-xl" v-show="showData.id" v-text="`${showData.get_order_type?.name}`" ></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Cliente:</div>
                                <div class="line-height-xl" v-show="showData.id"
                                    v-text="`${showData.get_user?.name} ${showData.get_user?.last_name}`"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Teléfono:</div>
                                <div class="line-height-x1" v-show="showData.id" v-text="`${showData.get_user?.phone}`"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Contacto:</div>
                                <div class="line-height-xl" v-show="showData.id" v-text="`${showData.get_user?.get_customer.contact}`"></div>
                            </div>
                            <div class="col-md-6 mb-2"  v-show="showMessengerData?.id">
                                <div class="font-weight-bolder mb-1">Transporte:</div>
                                <div class="line-height-xl" >Moto</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Medio de pago:</div>
                                <div class="line-height-xl" v-show="showData.id" v-text="`${showData.get_payment_method?.name}`">Efectivo</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Movil:</div>
                                <div class="line-height-xl" v-show="showData.id" v-text="`${[showMessengerData ? showMessengerData.id+', '+showMessengerData?.name+' '+showMessengerData?.last_name : 'No registra']}`">381, YEMAYEL ARIEL</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-12 m-0 p-0" v-for="(tab, i) in showData.get_guides"  >
                                <div class="col-md-12 mb-2">
                                    <div class="font-weight-bolder mb-1" v-text="`${'('+(i+1)+'), '+tab.rate}`">(1) Adicional*0:</div>
                                    <div class="line-height-xl" v-text="`${'$'+new Intl.NumberFormat().format(tab.value)}`">$0</div>
                                </div>
                                <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                                <div class="col-md-12 mb-2">
                                    <div class="font-weight-bolder mb-1">Cliente Depto:</div>
                                    <div class="line-height-x1" v-text="`${[showData.get_department ? showData.get_department.id+': '+showData.get_department.name : 'No registra']}`">84: PRINCIPAL</div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="font-weight-bolder mb-1">Cliente Sucursal:</div>
                                    <div class="line-height-x1" v-text="`${[showData.get_branch_office ? showData.get_branch_office.id+': '+showData.get_branch_office.name : 'No registra']}`">1179: PRINCIPAL</div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="font-weight-bolder mb-1">Cliente Documento:</div>
                                    <div class="line-height-x1" v-text="`${[showData.get_user ? showData.get_user.document_number+': '+showData.get_user.get_document_type?.name : '']}`">1191: DELIVERY</div>
                                </div>
                                <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                                <div class="col-md-12 mb-2">
                                    <div class="font-weight-bolder mb-1">Concepto:</div>
                                    <div class="line-height-xl" v-text="tab.concept">RETIRAR FIANZA A NOMBRE DE EDEMET</div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="font-weight-bolder mb-1">Dirección:</div>
                                    <div class="line-height-xl" v-text="tab.get_address ? tab.get_address.name : 'No registra' ">CLL 50: SAN FRANCISCO: PANAMA</div>
                                </div>
                                <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                                <div class="col-md-12 mb-2">
                                    <div class="font-weight-bolder mb-1">Contacto:</div>
                                    <div class="line-height-xl" v-text="tab.contact"></div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="font-weight-bolder mb-1">Email Contacto:</div>
                                    <div class="line-height-xl" v-text="tab.email_contact"></div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="font-weight-bolder mb-1">Teléfono contacto:</div>
                                    <div class="line-height-xl" v-text="tab.phone_contact">+507</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row flex-wrap max-h-200px mb-3 pb-3 border-bottom justify-content-center">
                            <h5 class="mb-5 font-weight-bold text-dark col-md-12">Adjuntos</h5>
                            <div class="col-md">
                                <img class="img-fluid rounded" src="https://placem.at/things?h=100" alt="">
                            </div>
                            <div class="col-md">
                                <img class="img-fluid rounded" src="https://placem.at/things?h=100" alt="">
                            </div>
                        </div>
                        <div class="d-flex flex-row flex-wrap align-items-center justify-content-center">
                            <a href="#" class="btn btn-light-success font-weight-bold mr-2">Imprimir</a>
                            <a href="#" class="btn btn-light-primary font-weight-bold mr-2">Detalle GPS</a>
                            <a type="button" href="#" v-if=currentTab==33 @click="updateStateOrders(31)" class="btn btn-light-primary font-weight-bold mr-2">Volver a despachar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </deliveries-ondemand>
@endsection
