{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Editar usuario
        </h3>
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
    <form action="{{route('bankUsers.update', [$user->parent_id, $user->id])}}" method="post">
        @csrf @method('PUT')
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
                <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{$user->name}}"/>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Apellidos:</label>
                <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" value="{{$user->last_name}}"/>
            </div>
            <div class="form-group col-md-4">
                <label>Email:</label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="{{$user->email}}"/>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Telefono: </label>
                <input type="tel" class="form-control form-control-solid" placeholder="Telefono" name="phone" value="{{$user->phone}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group m-0 col-md-6">
                <label>Contraseña: </label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password" />
            </div>
            <div class="form-group m-0 col-md-6">
                <label>Repetir Contraseña: </label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password_confirmation" />
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
