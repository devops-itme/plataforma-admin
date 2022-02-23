{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')

<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Editar cliente
        </h3>
        {{-- <div class="w-50"></div>
        <div class="w-30 mt-2 d-flex justify-content-center align-items-center">
            @if($customer->getUser->role == 4)
                <a href="{{route('bankUsers.index', $customer->getUser->id)}}" class="btn btn-icon btn-light-warning btn-sm mr-2" data-tooltip title="Usuarios">
                    <i class="fad fa-users-class"></i>
                </a>
            @endif
            <a href="{{route('branchOffices.index', $customer->user_id)}}" class="btn btn-icon btn-light-info btn-sm mr-2" data-tooltip title="Sucursales">
                <i class="fad fa-building"></i>
            </a>
            <a href="{{route('departments.index', ['user_id' => $customer->getUser->id])}}" class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip title="Departamentos">
                <i class="fad fa-warehouse"></i>
            </a>
        </div> --}}
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
    <form action="{{route('customers.update', $customer->id)}}" method="post">
        @csrf @method('PUT')
        <div class="card-body d-flex flex-row flex-wrap">

            <div class="form-group m-0 col-md-2">
                <label>Tipo de persona</label>
                <select class="form-control form-control-solid" id="slc_type">
                    <option disabled selected> Seleccione </option>
                    <option value="1" {{$customer->getUser->name ? 'selected' : ''}}>Persona natural</option>
                    <option value="2" {{$customer->business_name ? 'selected' : ''}}>Persona juridica</option>
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <input type="hidden" value="{{$customer->business_name ? '2' : '1'}}" id="customer_type_edit">
            <div class="col-md-7 d-flex px-0" id="naturalCustomer">
                <div class="form-group col-md-6">
                    <label>Nombres: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{$customer->getUser->name}}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-6">
                    <label>Apellidos <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" value="{{$customer->getUser->last_name}}" />
                </div>
            </div>
            <div class="d-none" id="legalCustomer">
                <div class="form-group m-0 col-md-6">
                    <label>Nombre de empresa <span class="text-danger">*</span></label>
                    <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="text"
                        name="business_name" value="{{ $customer->business_name }}" />
                </div>
                <div class="form-group m-0 col-md-6">
                    <label>Nombre comercial <span class="text-danger">*</span></label>
                    <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="text"
                        name="tradename" value="{{ $customer->tradename }}" />
                </div>
            </div>
            <div class="form-group col-md-3">
                <label>Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="{{$customer->getUser->email}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Telefono: <span class="text-danger">*</span></label>
                <input type="tel" class="form-control form-control-solid" placeholder="Telefono" name="phone" value="{{$customer->getUser->phone}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Tipo de documento</label>
                <select class="form-control form-control-solid" id="document_type" name="document_type">
                    <option selected disabled>Seleccione</option>
                    @foreach($documents as $document)
                        <option value="{{$document->id}}" {{$document->id == $customer->getUser->document_type ? 'selected' : ''}}>{{$document->name}}</option>
                    @endforeach
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Numero de identificación: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="N° de identificación" name="document_number" value="{{$customer->getUser->document_number}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Fecha de nacimiento: <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-solid" placeholder="" name="birthday" value="{{$customer->birthday}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre de empresa <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="text" name="business_name" value="{{$customer->business_name}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre comercial <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="text" name="tradename" value="{{$customer->tradename}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Repetir Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password_repeat" />
            </div>
            <div class="col-md-12">
                <ul class="nav nav-light-success nav-pills border-bottom pb-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">General</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sucursales</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="departament-tab" data-toggle="tab" href="#departament" role="tab" aria-controls="departament" aria-selected="false">Departamentos</a>
                    </li>
                    @if($customer->getUser->role == 4)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{route('bankUsers.index', $customer->getUser->id)}}">Usuarios</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="d-flex flex-row flex-wrap mt-3">
                            <h5 class="my-4 font-weight-bold text-dark col-md-12">Información general de cliente</h5>
                            <div class="form-group col-md-3">
                                <label for="exampleSelect1">Zona <span class="text-danger">*</span></label>
                                <select class="form-control form-control-solid" id="zone" name="zone">
                                    <option selected disabled> Seleccione </option>
                                    <option {{$customer->zone_id == 1 ? 'selected' : ''}}>1</option>
                                    <option {{$customer->zone_id == 2 ? 'selected' : ''}}>2</option>
                                    <option {{$customer->zone_id == 3 ? 'selected' : ''}}>3</option>
                                    <option {{$customer->zone_id == 4 ? 'selected' : ''}}>4</option>
                                    <option {{$customer->zone_id == 5 ? 'selected' : ''}}>5</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 mb-1">
                                <label for="exampleTextarea">Contacto <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-solid" id="exampleTextarea" rows="1" name="contact">{{$customer->contact}}</textarea>
                            </div>
                            <div class="form-group col-md-2 my-3">
                                <label for="payment_period">Periodo de pago <span class="text-danger">*</span></label>
                                <select class="form-control form-control-solid px-2 placeholder-dark-75" id="payment_period" name="payment_period">
                                    <option disabled>Seleccione</option>
                                    @foreach ($payment_period as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $customer->payment_period ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-0 py-4">
                                <label>Credito</label>
                                <div class="radio-inline">
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="credit" {{$customer->credit == 1 ? 'checked="checked"' : ''}} value="1" />
                                        <span></span>
                                        SI
                                    </label>
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="credit" {{$customer->credit == 0 ? 'checked="checked"' : ''}} value="0" />
                                        <span></span>
                                        NO
                                    </label>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group col-md-2 mb-0 py-4">
                                <label>Enviar saldo por Email</label>
                                <div class="radio-inline">
                                    <label class="radio radio-rounded">
                                        <input type="radio" checked="checked" name="receive_emails" value="1" {{$customer->receive_emails == 1 ? 'checked="checked"' : ''}}/>
                                        <span></span>
                                        SI
                                    </label>
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="receive_emails" value="0" {{$customer->receive_emails == 0 ? 'checked="checked"' : ''}}/>
                                        <span></span>
                                        NO
                                    </label>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-2">
                                <label>Valor FullFill <span class="text-danger">*</span></label>
                                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                                    type="number" name="fullfill" value="{{$customer->fullfill}}" />
                            </div>
                            <div class="form-group py-3 m-0 col-md-2">
                                <label>Valor Handling <span class="text-danger">*</span></label>
                                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                                    type="number" name="handling" value="{{$customer->handling}}" />
                            </div>
                            <div class="form-group py-3 m-0 col-md-2">
                                <label>Valor COD <span class="text-danger">*</span></label>
                                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                                    type="number" name="COD_value" value="{{$customer->COD_value}}" />
                            </div>
                            <div class="form-group col-md-2 mb-0 py-4">
                                <label>Impuesto <span class="text-danger">*</span></label>
                                <div class="radio-inline">
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="taxes" value="1" {{$customer->taxes == '1' ? 'checked="checked"' : ''}} />
                                        <span></span>
                                        SI
                                    </label>
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="taxes" value="0" {{$customer->taxes == '0' ? 'checked="checked"' : ''}} />
                                        <span></span>
                                        NO
                                    </label>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="col-md-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="d-flex flex-row flex-wrap">
                                        <div class="col-md-6 d-flex flex-row flex-wrap border-right">
                                            <h5 class="my-4 font-weight-bold text-dark col-md-12">Información general de orden</h5>
                                            <div class="form-group col-md-6">
                                                <label for="trans_type">Tipo de transporte <span class="text-danger">*</span></label>
                                                <select name="vehicle_type_id" class="form-control form-control-solid" id="trans_type">
                                                    <option selected="" disabled="">Seleccione tipo de transporte</option>
                                                    <option value="1">Moto</option>
                                                    <option value="2">Auto</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pay_method">Metodo de pago <span class="text-danger">*</span></label>
                                                <select name="payment_method_id" class="form-control form-control-solid" id="pay_method">
                                                    <option selected="" disabled="">Seleccione Metodo de pago</option>
                                                    <option value="1">Efectivo</option>
                                                    <option value="2">Cheque</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Fecha de programación: <span class="text-danger">*</span></label>
                                                <input name="schedule_date" type="date" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Hora de programación: <span class="text-danger">*</span></label>
                                                <input name="schedule_time" type="time" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-md-12 m-0 d-flex align-items-center">
                                                <div class="checkbox-inline">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="express_delivery">
                                                        <span></span>
                                                        Marcar Urgente Despacho
                                                    </label>
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="last_destination_return">
                                                        <span></span>
                                                        Retorno Ultimo Destino
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex flex-row flex-wrap">
                                            <h5 class="my-4 font-weight-bold text-dark col-md-12">Seguro de mercancia</h5>
                                            <div class="form-group col-md-6">
                                                <label>Valor asegurado: <span class="text-danger">*</span></label>
                                                <input name="insured_value" type="number" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>A cobrar %: <span class="text-danger">*</span></label>
                                                <input name="percentage_receivable" type="number" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>A cobrar $: <span class="text-danger">*</span></label>
                                                <input name="value_receivable" type="number" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <!--tabla de datos-->
                                    <table class="table table-sm" id="branch_offices_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre de Sucursal</th>
                                                <th scope="col">Tipo de Sucursal</th>
                                                <th scope="col">Zona de Sucursal</th>
                                                <th scope="col">Contacto de Sucursal</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="#" class="btn btn-primary btn-sm font-weight-bolder" data-toggle="modal" data-target="#modalCreate">
                                                            <span class="svg-icon svg-icon-md">
                                                                <i class="fas fa-plus"></i>
                                                            </span>Crear
                                                        </a>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                     {{-- DEPARTMENT MODULE --}}
                     <div class="tab-pane fade" id="departament" role="tabpanel" aria-labelledby="departament-tab">
                        <department-tab>

                        </department-tab>
                     </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </div>
    </form>
    <!--end::Form-->
</div>

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
