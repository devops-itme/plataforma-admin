{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h2 class="card-label h1">Ver cliente
            </h2>
        </div>
    </div>
    @include('layouts.alerts')
    <div class="card-body">
        <div class="my-5">
            <h5 class="mb-10 font-weight-bold text-dark">Información basica de cliente</h5>
            <!--begin::Item-->
            <div class="border-bottom mb-5 pb-5">
                <div class="row">
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Nombres:</div>
                        <div class="line-height-xl">{{(($customer->getUser->name??'')." ".($customer->getUser->last_name??'')) ?? 'No registra'}}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Email:</div>
                        <div class="line-height-xl">{{$customer->getUser->email??'No registra'}}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Teléfono:</div>
                        <div class="line-height-xl">{{$customer->getUser->phone??'No registra'}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Tipo y número de documento:</div>
                        <div class="line-height-xl"><b>{{$customer->getUser->getDocumentType->name??'No registra'}}</b> / {{$customer->getUser->document_number??'No registra'}}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Fecha de nacimiento:</div>
                        <div class="line-height-xl">{{$customer->birthday}}</div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="user_id" id="customer_id" value="{{$customer->getUser->id??'No registra'}}">
            <!--end::Item-->
        </div>
        <div class="my-5">
            <h5 class="mb-10 font-weight-bold text-dark">Información detallada de cliente</h5>
            <!--begin::Item-->
            <div class="mb-5 pb-5">
                <div class="row mb-5 pb-5 border-bottom">
                    <div class="col-md-6">
                        <div class="font-weight-bolder mb-3">Nombre de empresa:</div>
                        <div class="line-height-xl">{{$customer->business_name??'No registra'}}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="font-weight-bolder mb-3">Nombre comercial:</div>
                        <div class="line-height-xl">{{$customer->tradename??'No registra'}}</div>
                    </div>
                </div>
                <div class="row mb-5 pb-5 border-bottom">
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Zona:</div>
                        <div class="line-height-xl">{{$customer->getZone->name??'No registra'}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Contacto:</div>
                        <div class="line-height-xl">{{$customer->contact}}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Periodo de pago:</div>
                        <div class="line-height-xl">{{$customer->payment_period}}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Credito:</div>
                        <div class="line-height-xl">{{$customer->credit == 1 ? 'Sí' : 'No'}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Recepción de saldo por email:</div>
                        <div class="line-height-xl">{{$customer->receive_emails == 1 ? 'Sí' : 'No'}}</div>
                    </div>
                </div>
                <div class="row mb-5 pb-5 border-bottom">
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Valor FullFill:</div>
                        <div class="line-height-xl">${{number_format($customer->fullfill)}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Valor Handling:</div>
                        <div class="line-height-xl">${{number_format($customer->handling)}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Valor COD:</div>
                        <div class="line-height-xl">${{number_format($customer->COD_value)}}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Impuesto:</div>
                        <div class="line-height-xl">{{$customer->taxes == 1 ? 'Sí' : 'No'}}</div>
                    </div>
                </div>
            </div>
            <!--end::Item-->
        </div>
        <div class="my-5">
            <h5 class="mb-10 font-weight-bold text-dark">Seguro de mercancia</h5>
            <div class="mb-5 pb-5">
                <div class="row">
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Valor asegurado:</div>
                        <div class="line-height-xl">${{number_format($customer->insured_value)}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">A cobrar %:</div>
                        <div class="line-height-xl">${{number_format($customer->percentage_to_collect)}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">A cobrar $:</div>
                        <div class="line-height-xl">${{number_format($customer->money_to_collect)}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <ul class="nav nav-light-success nav-pills border-bottom pb-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="addresses-tab" data-toggle="tab" href="#addresses" role="tab" aria-controls="addresses" aria-selected="true">Direcciones</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="branches-tab" data-toggle="tab" href="#branches" role="tab" aria-controls="branches" aria-selected="false">Sucursales</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="departament-tab" data-toggle="tab" href="#departament" role="tab" aria-controls="departament" aria-selected="false">Departamentos</a>
        </li>
    </ul>
</div>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Direcciones
                    </h3>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm font-weight-bold btn-primary" data-toggle="modal" data-target="#formCreateAddress">
                        <i class="fas fa-plus"></i>CREAR DIRECCIÓN
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="address_table table align-items-center text-center table-flush" id="{{$customer->user_id}}">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Descripción</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->getUser->getAddresses as $item)
                        <tr>
                            <td id="description" >{{$item->description}}</td>
                            <td id="name" >{{$item->name}}</td>
                            @if($customer->state == 1)
                            <td>
                                <span class="label label-inline label-light-success font-weight-bold">
                                    Activo
                                </span>
                            </td>
                            @else
                                <td>
                                    <span class="label label-inline label-light-danger font-weight-bold">
                                        Inactivo
                                    </span>
                                </td>
                            @endif
                            <td>
                                <button type="button" class="edit btn btn-icon btn-light-success"  data-tooltip title="Editar" data-toggle="modal" data-target="#editModal{{$item->id}}" >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- MODAL EDIT-->
                                <div class="modal fade" id="editModal{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">EDITAR DIRECCIÓN</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('addresses.update', $item->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <input type="text" hidden name="user_id" value="{{$item->user_id}}">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label> Descripción </label>
                                                            <input type="text" name="description" class="form-control" value="{{$item->description}}" placeholder="Descripción">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label> Dirección *</label>
                                                            <input type="text" name="address" class="form-control" value="{{$item->name}}" id="address_edit" placeholder="Introduce una ubicación">
                                                            <input type="hidden" name="lat" id="branch_office_lat_edit" value="{{$item->lat}}">
                                                            <input type="hidden" name="lng" id="branch_office_lng_edit" value="{{$item->lng}}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                                                        <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i>GUARDAR</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" onclick="deleteResource('{{route('addresses.destroy', $item->id)}}', true)" class="delete btn btn-icon btn-light-danger">
                                    <i class="fas fa-eraser"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show" id="branches" role="tabpanel" aria-labelledby="branches-tab">
        <div class="card">
            <div class="card-header">
                <h3>Sucursales</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm" id="branch_offices_table">
                    <thead>
                        <tr>
                            <th scope="col">Nombre de Sucursal</th>
                            <th scope="col">Tipo de Sucursal</th>
                            <th scope="col">Zona de Sucursal</th>
                            <th scope="col">Contacto de Sucursal</th>
                            <th scope="col">Estado</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade show" id="departament" role="tabpanel" aria-labelledby="departament-tab">
        <div class="card">
            <div class="card-header">
                <h3>Departamentos</h3>
            </div>
            <div class="card-body">
                <department-tab :user-id="{{ $customer->user_id  }}" :show-dep="1">
                </department-tab>
            </div>
        </div>
    </div>
</div>

@include('customers.modals.branches.createBranchModal')
@include('customers.modals.branches.editBranchModal')

<!-- MODAL CREATE-->
<div class="modal fade" id="formCreateAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CREAR DIRECCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('addresses.store') }}" method="POST" id="formCreateAddress">
                    @csrf
                    <input type="text" hidden name="user_id" value="{{$customer->user_id}}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label> Descripción *</label>
                            <input type="text" name="description" class="form-control" value="{{old('description')}}" placeholder="Descripción">
                        </div>
                        <div class="col-md-6">
                            <label> Dirección *</label>
                            <input type="text" name="address" class="form-control" value="{{old('address')}}" id="address" placeholder="Introduce una ubicación">
                            <input type="hidden" name="lat" id="branch_office_lat" value="{{old('lat')}}">
                            <input type="hidden" name="lng" id="branch_office_lng" value="{{old('lng')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>GUARGAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

{{-- Styles Section --}}
@section('styles')

@endsection

{{-- Scripts Section --}}
@section('scripts')
<script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script>
@endsection
