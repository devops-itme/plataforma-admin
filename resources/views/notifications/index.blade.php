{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')

    <div class="col-md-10 p-4 d-flex flex-row flex-wrap border-right mx-auto">
        <div class="col-md-12 d-flex flex-row flex-wrap justify-content-between align-items-center px-0">
            <h5 class="font-weight-bold text-dark">
                Notificacion
            </h5>
        </div>
        
        <div class="card col-md-12 text-center mt-5">
            <div class="card-body">
                <h5 class="card-title">Titulo de notificacion</h5>
                <p class="card-text">Coroncoro se murio' tu mae</p>
                <a href="#" class="btn btn-primary">Ir al sitio</a>
            </div>
            <div class="card-footer text-muted">
                Hace 2 días
            </div>
        </div>
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
