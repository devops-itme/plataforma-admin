{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Detalles usuario
        </h3>
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
        <div class="card-body d-flex flex-row flex-wrap">
            <div class="form-group col-md-4">
                <label>Nombre de empresa:</label>
                <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{$user->getParent->getCustomer->business_name}}"disabled />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Nombre comercial:</label>
                <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{$user->getParent->getCustomer->tradename}}" disabled />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Nombres:</label>
                <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{$user->name}}" disabled/>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Apellidos:</label>
                <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" value="{{$user->last_name}}" disabled/>
            </div>
            <div class="form-group col-md-4">
                <label>Email:</label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="{{$user->email}}" disabled/>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Teléfono: </label>
                <input type="tel" class="form-control form-control-solid" placeholder="Teléfono" name="phone" value="{{$user->phone}}" disabled />
                <span class="form-text text-muted"></span>
            </div>
        </div>
    <!--end::Form-->
</div>
@endsection
