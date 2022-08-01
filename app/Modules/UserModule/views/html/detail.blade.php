{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')

<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Detalle del usuario
        </h3>
    </div>
    @include('layouts.alerts')

    <div class="card-body d-flex flex-row flex-wrap">

        <div class="form-group col-md-3">
            <label>Nombres</label>
            <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{$user->name}}" disabled />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-3">
            <label>Apellidos</label>
            <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" value="{{$user->last_name}}" disabled />
        </div>
        <div class="form-group col-md-3">
            <label>Email</label>
            <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="{{$user->email}}" disabled />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-3">
            <label>Estado</label>
            <input type="text" class="form-control form-control-solid" name="state" value="{{$user->state==1 ? 'Activo':'Inactivo'}}" disabled />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-3">
            <label>Teléfono</label>
            <input type="tel" class="form-control form-control-solid" placeholder="Teléfono" name="phone" value="{{$user->phone}}" disabled />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-3">
            <label>Rol</label>
            <select class="form-control form-control-solid" id="document_type" name="role" disabled>
                <option>{{$user->getRole->name}}</option>
                <option value="Admin">Admin</option>
                <option value="Operador">Operador</option>
                <option value="Mensajero">Mensajero</option>
            </select>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-3">
            <label>Tipo de documento</label>
            <select class="form-control form-control-solid" id="document_type" name="role" disabled>
                <option>{{$user->getDocumentType->name}}</option>
                <option value="CC">C.C</option>
                <option value="CE">C.E</option>
                <option value="PE">P.E</option>
                <option value="RUC">RUC</option>
            </select>
            <span class="form-text text-muted"></span>
        </div>

        <div class="form-group col-md-3">
            <label>Número de identificación</label>
            <input type="text" class="form-control form-control-solid" placeholder="N° de identificación" name="document_number" value="{{$user->document_number}}" disabled />
            <span class="form-text text-muted"></span>
        </div>
    </div>
</div>
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
