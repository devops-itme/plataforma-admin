{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h2 class="card-label h1">Ver mensajero
            </h2>
        </div>
    </div>
    <div class="card-body">
        <div class="my-5">
            <h5 class="mb-10 font-weight-bold text-dark">Información basica de mensajero</h5>
            <!--begin::Item-->
            <div class="border-bottom mb-5 pb-5">
                <div class="row">
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Nombres:</div>
                        <div class="line-height-xl">{{ $messenger->user->name .' '. $messenger->user->last_name}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Email:</div>
                        <div class="line-height-xl">{{$messenger->user->email}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Telefono:</div>
                        <div class="line-height-xl">{{$messenger->user->phone}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Tipo y numero de documento:</div>
                        <div class="line-height-xl"><b>CC</b> / {{$messenger->user->document_number}}</div>
                    </div>
                </div>
            </div>
            <!--end::Item-->
        </div>
        <div class="my-5">
            <h5 class="mb-10 font-weight-bold text-dark">Información detallada de mensajero</h5>
            <!--begin::Item-->
            <div class="mb-5 pb-5">
                <div class="row mb-5 pb-5 border-bottom">
                    <div class="col-md-4">
                        <div class="font-weight-bolder mb-3">Placa de vehiculo:</div>
                        <div class="line-height-xl">{{$messenger->vehile_plate}}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="font-weight-bolder mb-3">Fecha de ingreso:</div>
                        <div class="line-height-xl">{{$messenger->admission_date}}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="font-weight-bolder mb-3">Porcentaje de producción:</div>
                        <div class="line-height-xl">{{$messenger->production_percentage}}%</div>
                    </div>
                </div>
                <div class="row mb-5 pb-5 border-bottom">
                    <div class="col-md-6">
                        <div class="font-weight-bolder mb-3">Exclusivo:</div>
                        <div class="line-height-xl">{{$messenger->exclusive == 1 ? 'SI' : 'NO' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="font-weight-bolder mb-3">Contrato:</div>
                        <div class="line-height-xl"><a href="#" target="_blank" download="contrato-mensajero.pdf">Descargar contrato</a></div>
                    </div>
                </div>
            </div>
            <!--end::Item-->
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
