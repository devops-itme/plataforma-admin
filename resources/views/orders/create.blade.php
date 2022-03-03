{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Crear orden
            </h3>
        </div>
        @include('layouts.alerts')
        <!--begin::Form-->
        <form action="{{route('orders.store')}}" method="post">
            @csrf
            <div class="card-body d-flex flex-row flex-wrap pt-2">
                <div class="col-md-6 border-right">
                    <div class="d-flex flex-row flex-wrap">
                    <h5 class="my-4 font-weight-bold text-dark col-md-12">Información basica de orden</h5>
                    <div class="form-group col-md-6">
                        <label>Numero de orden: <span class="text-danger">*</span></label>
                        <input name="order_number" type="text" class="form-control form-control-solid" placeholder="Orden_#" id="order_number" readonly />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="order_type">Tipo de orden <span class="text-danger">*</span></label>
                        <select name="order_type" class="form-control form-control-solid" id="order_type">
                            <option selected disabled>Seleccione tipo de orden</option>
                            @foreach($order_type as $order)
                                <option {{old('order_type')==$order->id?'selected ':''}}  value="{{$order->id}}">{{$order->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="customers">Cliente <span class="text-danger">*</span></label>
                        <button type="button" class="btn btn-primary btn-block bg-white text-dark" data-toggle="modal" data-target="#detailCustomer" id="btnDetailCustomer"> Buscar cliente </button>
                        {{-- <select name="user_id" class="form-control" id="slc-Customers">
                            <option selected disabled>Seleccione Cliente</option>
                            @foreach ($customers as $customer)
                                <option value="{{$customer->user_id}}">{{!is_null($customer->business_name) ? $customer->business_name : $customer->getUser->name." ".$customer->getUser->last_name}}</option>
                            @endforeach
                        </select> --}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="customers">Codigo<span class="text-danger">*</span></label>
                        <input type="text" id="user_code" class="form-control form-control-solid" readonly value="" name="user_id">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customers">Marca / Nombre Comercial<span class="text-danger">*</span></label>
                        <input type="text" id="user_name" class="form-control form-control-solid" readonly value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customers">Contacto<span class="text-danger">*</span></label>
                        <input type="text" id="user_contact" class="form-control form-control-solid" readonly value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customers">Departamento<span class="text-danger">*</span></label>
                        <select name="department_id" id="user_departments" class="form-control form-control-solid">
                            <option value="" selected disabled> Seleccione </option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customers">Sucursal<span class="text-danger">*</span></label>
                        <select name="branch_office_id" id="user_branch_office" class="form-control form-control-solid">
                            <option value="" selected disabled> Seleccione </option>
                        </select>
                        {{-- <input type="text" id="user_branch_office" class="form-control form-control-solid" readonly value=""> --}}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="customers">Tipo de documento<span class="text-danger">*</span></label>
                        <input type="text" id="user_document_type" class="form-control form-control-solid" readonly value="">
                    </div>
                    {{-- <div class="form-group col-md-3 d-flex align-items-center flex-row pt-6">
                        <button type="button" class="btn btn-icon btn-light-success btn-sm mr-2" id="btn-customerData">
                            <i class="fad fa-eye"></i>
                        </button>

                        <a href="{{ route('customers.create') }}" class="btn btn-icon btn-light-primary btn-sm mr-2">
                            <i class="fad fa-plus"></i>
                        </a>
                    </div> --}}
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
                            <input name="expenses" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Recibir por COD: </label>
                            <input name="receive_by_COD" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Gastos diligencia: </label>
                            <input name="diligence_expenses" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Producto interno: </label>
                            <input name="internal_product" type="number" class="form-control form-control-solid" placeholder="0.00" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Total Tax: </label>
                            <input name="tax_total" type="number" class="form-control form-control-solid" placeholder="0.00" />
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
                            @include('orders.generalTab')
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @include('orders.guideTab')
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
    @include('orders.modals.importGuidesModal')

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
