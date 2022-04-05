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
        <!--begin::Form-->
        <form action="" method="post">

            <div class="card-body d-flex flex-row flex-wrap">
                <div class="col-md-3">
                    <div class="font-weight-bolder">Nombres:</div>
                    <div class="line-height-xl">Admin</div>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bolder">Numero de documento:</div>
                    <div class="line-height-xl"></div>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bolder">Correo:</div>
                    <div class="line-height-xl">admin@me.com</div>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bolder">Teléfono:</div>
                    <div class="line-height-xl"></div>
                </div>
                <div class="col-md-6">
                    <div class="font-weight-bolder mt-5">Rol:</div>
                    <div class="line-height-xl">Admin</div>
                </div>
                <div class="col-md-6">
                    <div class="font-weight-bolder mt-5">Estado:</div>
                    <div class="line-height-xl">Activo</div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button type="reset" class="btn btn-secondary"><a href="{{ route('users.index') }}"
                        class="text-muted">Volver</a></button>
            </div>
        </form>
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
