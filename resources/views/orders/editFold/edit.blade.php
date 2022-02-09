{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Editar orden
            </h3>
        </div>
        @include('layouts.alerts')
        <!--begin::Form-->
        <form action="{{route('orders.update', $order->id)}}" method="POST">
            @csrf @method('PUT')
            <div class="card-body d-flex flex-row flex-wrap pt-2">
                <div class="col-md-6 border-right">
                    <div class="d-flex flex-row flex-wrap">
                    <h5 class="my-4 font-weight-bold text-dark col-md-12">Información basica de orden</h5>
                    <div class="form-group col-md-6">
                        <label>Numero de orden: <span class="text-danger">*</span></label>
                        <input name="number" type="number" class="form-control form-control-solid" placeholder="333" value="{{$order->number}}" readonly />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="order_type">Tipo de orden <span class="text-danger">*</span></label>
                        <select name="service_type_id" class="form-control form-control-solid" id="order_type">
                            <option selected disabled>Seleccione tipo de orden</option>
                            <option value="1" {{$order->service_type_id == 1 ? 'selected' : ''}}>Ondeman</option>
                            <option value="2" {{$order->service_type_id == 2 ? 'selected' : ''}}>Multiple</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customers">Cliente <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control" id="slc-Customers">
                            <option selected disabled>Seleccione Cliente</option>
                            @foreach ($customers as $customer)
                                <option value="{{$customer->user_id}}" {{$customer->user_id == $order->user_id ? 'selected' : ''}}>{{!is_null($customer->business_name) ? $customer->business_name : $customer->getUser->name." ".$customer->getUser->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 d-flex align-items-center flex-row pt-6">
                        <button type="button" class="btn btn-icon btn-light-success btn-sm mr-2" id="btn-customerData">
                            <i class="fad fa-eye"></i>
                        </button>

                        <a href="{{ route('customers.create') }}" class="btn btn-icon btn-light-primary btn-sm mr-2">
                            <i class="fad fa-plus"></i>
                        </a>
                    </div>
                   </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-row flex-wrap">
                        <div class="d-flex flex-row flex-wrap col-md-12 justify-content-between">
                            <h5 class="my-4 font-weight-bold text-dark col-md-3">Totales</h5>
                            <div class="col-6">
                                <div class="d-flex flex-row flex-wrap">
                                    <div class="col-6 p-0">
                                        <small class="mb-0 label label-sm label-warning label-pill label-inline">Valor total OnDemand</small><br>
                                        <small class="mb-0 pl-2 text-danger">1.00</small>
                                    </div>
                                    <div class="col-6 p-0">
                                        <small class="mb-0 label label-sm label-warning label-pill label-inline">Valor Pagar Cliente</small><br>
                                        <small class="mb-0 pl-2 text-danger">1.00</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Valor Orden OnDemand/Corp:</label>
                            <input name="order_value" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>FF, COD, Com.Gastos, Seguro:</label>
                            <input name="sec_value" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Recibir por COD: </label>
                            <input name="cod_value" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Gastos diligencia: </label>
                            <input name="cost_diligence" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Producto interno: </label>
                            <input name="inner_prod" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Total Tax: </label>
                            <input name="total_tax" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul class="nav nav-light-success nav-pills border-bottom pb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab"
                                aria-controls="general" aria-selected="true">General</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">Pedidos / Destinos</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            @include('orders.editFold.generalTabEdit')
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @include('orders.editFold.guideTabEdit')
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" id="btn-create-messenger" class="btn btn-primary mr-2">Guardar</button>
                <button type="reset" class="btn btn-secondary">Limpiar</button>
            </div>
        </form>
        <!--end::Form-->
    </div>
    @include('orders.detailCustomer')

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
