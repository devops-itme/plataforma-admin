{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Crear usuario
        </h3>
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
    <form action="/usuario-banco/{{$parent_id ? $parent_id : null}}/store" method="post">
        @csrf
        <div class="card-body d-flex flex-row flex-wrap">

            <div class="form-group col-md-4">
                <label>Nombres: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{old('name')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Apellidos: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" value="{{old('last_name')}}" />
            </div>
            <div class="form-group col-md-4">
                <label>Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="{{old('email')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Teléfono: </label>
                <input type="tel" class="form-control form-control-solid" placeholder="Teléfono" name="phone" value="{{old('phone')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group m-0 col-md-4">
                <label>Contraseña: </label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password" />
            </div>
            <div class="form-group m-0 col-md-4">
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
