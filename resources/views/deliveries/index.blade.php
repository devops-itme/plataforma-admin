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
                    <input type="date" value="2022-10-02" min="2000-01-01" style="margin-right: 20px;">
                    <h6 class="card-label">Hasta:</h6>
                    <input type="date" value="2022-10-02" min="2000-01-01" style="margin-right: 10px;">
                    <input type="checkbox" id="check" style="margin-right: 5px;">
                    <h6 class=" card-text">Ver todo</h6>
                </div>
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                        <li  class="nav-item"  v-for="(tab, index) in tabs" :key="tab.id" >
                            <a class="nav-link" @click="getOrders(tab.id)"
                            :class="{'active': currentTab === tab.id}" data-toggle="tab" :href="`#${tab.href}`" v-text=tab.name></a>
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
                            <div class="tab-pane fade show active" id="pordespachar" role="tabpanel"
                                aria-labelledby="kt_tab_pane_2">
                                @include('deliveries.byShipment.shipmentIndex')
                            </div>
                            <div class="tab-pane fade" id="despachados" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                                @include('deliveries.shipmented.shipmentedIndex')
                            </div>
                            <div class="tab-pane fade" id="completados" role="tabpanel" aria-labelledby="kt_tab_pane_3">
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
                                <div class="line-height-xl">---</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Tipo de orden:</div>
                                <div class="line-height-xl">Normal</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Cliente:</div>
                                <div class="line-height-xl" v-show="showData.id"
                                    v-text="`${showData.get_user?.name} ${showData.get_user?.last_name}`"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Telefono:</div>
                                <div class="line-height-x1">3002220000</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Contacto:</div>
                                <div class="line-height-xl">Martha Payega</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Transporte:</div>
                                <div class="line-height-xl">Moto</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Medio de pago:</div>
                                <div class="line-height-xl">Efectivo</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Movil:</div>
                                <div class="line-height-xl">381, YEMAYEL ARIEL</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">(1) Adicional*0:</div>
                                <div class="line-height-xl">$0</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Cliente Depto:</div>
                                <div class="line-height-x1">84: PRINCIPAL</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Cliente Sucursal:</div>
                                <div class="line-height-x1">1179: PRINCIPAL</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Cliente Documento:</div>
                                <div class="line-height-x1">1191: DELIVERY</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Concepto:</div>
                                <div class="line-height-xl">RETIRAR FIANZA A NOMBRE DE EDEMET</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Dirección:</div>
                                <div class="line-height-xl">CLL 50: SAN FRANCISCO: PANAMA</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Contacto:</div>
                                <div class="line-height-xl"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Contacto Email:</div>
                                <div class="line-height-xl"></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Contacto Phone:</div>
                                <div class="line-height-xl">+507</div>
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
                            <a href="#" class="btn btn-light-primary font-weight-bold mr-2">Volver a despachar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </deliveries-ondemand>
@endsection
