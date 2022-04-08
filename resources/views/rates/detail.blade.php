{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')

    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Detalle de Tarifario
            </h3>
        </div>

        @include('layouts.alerts')

        <form action="{{ route('rates.store') }}" method="POST">
           
            <div class="card-body d-flex flex-row flex-wrap">

                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Tipo de tarifa:</div>
                        <div class="line-height-xl">{{ $rate->getPackageType->name }}</div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Numero de Documento:</div>
                        <div class="line-height-xl">123456789</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Correo</div>
                        <div class="line-height-xl">navaja@gmail.com</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Teléfono</div>
                        <div class="line-height-xl">30257777</div>
                    </div>
                    <div class="col-md-6 mt-7">
                        <div class="font-weight-bolder mb-3">Rol</div>
                        <div class="line-height-xl">Lacra</div>
                    </div>
                    <div class="col-md-6 mt-7">
                        <div class="font-weight-bolder mb-3">Estado</div>
                        <div class="line-height-xl">Activo</div>
                    </div> --}}
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button type="reset" class="btn btn-secondary"><a href="{{ route('rates.index') }}"
                        class="text-muted">Volver</a></button>
            </div>
        </form>
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
