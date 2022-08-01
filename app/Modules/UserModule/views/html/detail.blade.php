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

    <div class="card-body ">
        <div class="border-bottom mb-5 pb-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="font-weight-bolder mb-3">Nombres:</div>
                    <div class="line-height-xl">{{ $user->name ?? 'No registra'}}</div>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bolder mb-3">Apellidos:</div>
                    <div class="line-height-xl">{{$user->last_name ?? 'No registra'}}</div>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bolder mb-3">Email:</div>
                    <div class="line-height-xl">{{$user->email ?? 'No registra'}}</div>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bolder mb-3">Estado:</div>
                    <div class="line-height-xl">{{$user->state==1 ? 'Activo':'Inactivo' ??'No registra'}}</div>
                </div>
            </div>
        </div>

        <div class="border-bottom mb-5 pb-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="font-weight-bolder mb-3">Teléfono:</div>
                    <div class="line-height-xl">{{$user->phone ?? 'No registra'}}</div>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bolder mb-3">Rol:</div>
                    <div class="line-height-xl">{{$user->getRole->name ?? 'No registra'}}</div>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bolder mb-3">Tipo de documento:</div>
                    <div class="line-height-xl">{{$user->getDocumentType->name ?? 'No registra'}}</div>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bolder mb-3">Número de identificación:</div>
                    <div class="line-height-xl">{{$user->document_number ?? 'No registra'}}</div>
                </div>
            </div>
        </div>
        @endsection

        {{-- Styles Section --}}
        @section('styles')
        @endsection
