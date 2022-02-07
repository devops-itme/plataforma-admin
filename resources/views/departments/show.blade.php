{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h2 class="card-label h1">Ver departamento
            </h2>
        </div>
    </div>
    <div class="card-body">
        <div class="my-5">
            <h5 class="mb-10 font-weight-bold text-dark">Información basica de departamento</h5>
            <!--begin::Item-->
            <div class="border-bottom mb-5 pb-5">
                <div class="row">
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Nombres</div>
                        <div class="line-height-xl">{{$department->name}}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Estado</div>
                        <div class="line-height-xl">
                            @if ($department->state == 1)
                            <span class="label label-inline label-light-success font-weight-bold">
                                Activo
                            </span>
                        @else
                            <span class="label label-inline label-light-danger font-weight-bold">
                                Inactivo
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="font-weight-bolder mb-3">Descripción:</div>
                        <div class="line-height-xl">{{$department->description}}</div>
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
