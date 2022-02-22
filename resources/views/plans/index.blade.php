{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')



    <div class="card card-custom ">

        <div class="card-header card-header-tabs-line">
            <div class="card-title">
                <h6 class=" card-label">ID:</h6>
                <input type="number" class="form-control" value="1" min="1" style="margin-right: 10px; width: 50px">
                <h6 class="card-label">Nombre:</h6>
                <div class=" row col-md-12">
                    <input type="text" class="form-control" placeholder="Escriba su nombre" style="width: 100vh">
                    <button class="btn-primary btn" style="margin: 0px 10px"><span>Limpiar</span></button>
                    <button class="btn-primary btn"><span>Guardar</span></button>
                </div>
            </div>

        </div>
        <div class="card-body d-flex flex-row flex-wrap pt-10">
            <div class="col-md-12">
                <ul class="nav nav-light-success nav-pills border-bottom pb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="listaPlanes-tab" data-toggle="tab" href="#listaPlanes" role="tab"
                            aria-controls="general" aria-selected="true">Lista de Planes</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="paquetesPlan-tab" data-toggle="tab" href="#paquetesPlan" role="tab"
                            aria-controls="paquetesPlan" aria-selected="false">Paquetes del Plan</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="zonasPerm-tab" data-toggle="tab" href="#zonasPerm" role="tab"
                            aria-controls="zonasPerm" aria-selected="false">Barrios/Zonas Permitidas</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="listaPlanes" role="tabpanel" aria-labelledby="general-tab">
                        @include('plans.listaPlanesTab')
                    </div>
                    <div class="tab-pane fade" id="paquetesPlan" role="tabpanel" aria-labelledby="paquetesPlan-tab">
                        @include('plans.paquetesPlanTab')
                    </div>
                    <div class="tab-pane fade" id="zonasPerm" role="tabpanel" aria-labelledby="zonasPerm-tab">
                        @include('plans.zonasPermTab')
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
{{-- Styles Section --}}
@section('styles')
@endsection
