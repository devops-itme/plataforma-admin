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
    <div class="card-body">
        <div class="my-5">
            <h5 class="mb-10 font-weight-bold text-dark">Información basica de cliente</h5>
            <!--begin::Item-->
            <div class="border-bottom mb-5 pb-5">
                <div class="row">
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Nombres:</div>
                        <div class="line-height-xl">{{$customer->getUser->name." ".$customer->getUser->last_name}}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Email:</div>
                        <div class="line-height-xl">{{$customer->getUser->email}}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Telefono:</div>
                        <div class="line-height-xl">{{$customer->getUser->phone}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Tipo y numero de documento:</div>
                        <div class="line-height-xl"><b>{{$customer->getUser->getDocumentType->name}}</b> / {{$customer->getUser->document_number}}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Fecha de nacimiento:</div>
                        <div class="line-height-xl">{{$customer->birthday}}</div>
                    </div>
                </div>
            </div>
            <!--end::Item-->
        </div>
        <div class="my-5">
            <h5 class="mb-10 font-weight-bold text-dark">Información detallada de cliente</h5>
            <!--begin::Item-->
            <div class="mb-5 pb-5">
                <div class="row mb-5 pb-5 border-bottom">
                    <div class="col-md-6">
                        <div class="font-weight-bolder mb-3">Nombre de empresa:</div>
                        <div class="line-height-xl">{{$customer->business_name != NULL ? $customer->business_name : 'No registra'}}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="font-weight-bolder mb-3">Nombre comercial:</div>
                        <div class="line-height-xl">{{$customer->tradename != NULL ? $customer->tradename : 'No registra'}}</div>
                    </div>
                </div>
                <div class="row mb-5 pb-5 border-bottom">
                    <div class="col-md-2">
                        <div class="font-weight-bolder mb-3">Zona:</div>
                        <div class="line-height-xl">{{$customer->getZone->name}}</div>
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
                <div class="row">
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
    </div>
</div>

<br>
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                Direcciones
            </h3>
        </div>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm font-weight-bold btn-primary" data-toggle="modal" data-target="#formCreateAddress">
                <i class="fas fa-plus"></i>CREAR DIRECCION
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

            </tbody>
        </table>
        <template id="address-template">
            <tr>
                <td id="description" >Casa</td>
                <td id="name" >Rebolo, Atlántico, Colombia</td>
                <td id="state">Activa</td>
                <td>
                    <button type="button" id="deleteAddress" class="edit btn btn-icon btn-light-success" data-toggle="modal" data-target="#editModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="delete btn btn-icon btn-light-danger">
                        <i class="fas fa-eraser"></i>
                    </button>
                </td>
            </tr>
          </template>
    </div>
</div>
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
                            <label> Descripción </label>
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

<!-- MODAL EDIT-->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDITAR DIRECCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <input type="text" hidden name="user_id" value="{{$customer->user_id}}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label> Descripción </label>
                            <input type="text" name="description" class="form-control" value="{{old('description')}}" placeholder="Descripción">
                        </div>
                        <div class="col-md-6">
                            <label> Dirección *</label>
                            <input type="text" name="address" class="form-control" value="{{old('address')}}" id="address_edit" placeholder="Introduce una ubicación">
                            <input type="hidden" name="lat" id="branch_office_lat_edit" value="{{old('lat')}}">
                            <input type="hidden" name="lng" id="branch_office_lng_edit" value="{{old('lng')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="button" class="btn btn-primary"><i class="fas fa-edit"></i>GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<br>

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection

{{-- Scripts Section --}}
@section('scripts')
<script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script>
@endsection
