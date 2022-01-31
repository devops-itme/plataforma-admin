{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h2 class="card-label h1">Ver cliente
                </h2>
                @if($customer->getUser->role == 4)
                    <a href="{{route('userBanks.index', $customer->getUser->id)}}" class="btn btn-primary"> Usuarios</a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="my-5">
                <h5 class="mb-10 font-weight-bold text-dark">Información basica de cliente</h5>
                <!--begin::Item-->
                <div class="border-bottom mb-5 pb-5">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Nombres:</div>
                            <div class="line-height-xl">{{$customer->getUser->name." ".$customer->getUser->last_name}}</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Email:</div>
                            <div class="line-height-xl">{{$customer->getUser->email}}</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Telefono:</div>
                            <div class="line-height-xl">{{$customer->getUser->phone}}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Tipo y numero de documento:</div>
                            <div class="line-height-xl"><b>{{$customer->getUser->getDocumentType->name}}</b> / {{$customer->getUser->document_number}}</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Fecha de nacimiento:</div>
                            <div class="line-height-xl">{{$customer->birthday}}</div>
                        </div>
                    </div>
                </div>
                <!--end::Item-->
            </div>
            <div class="my-5">
                <h5 class="mb-10 font-weight-bold text-dark">Información detallada de cliente</h5>
                <!--begin::Item-->
                <div class="mb-5 pb-5">
                    <div class="row mb-5 pb-5 border-bottom">
                        <div class="col-md-6">
                            <div class="font-weight-bolder mb-3">Nombre de empresa:</div>
                            <div class="line-height-xl">{{$customer->business_name != NULL ? $customer->business_name : 'No registra'}}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="font-weight-bolder mb-3">Nombre comercial:</div>
                            <div class="line-height-xl">{{$customer->tradename != NULL ? $customer->tradename : 'No registra'}}</div>
                        </div>
                    </div>
                    <div class="row mb-5 pb-5 border-bottom">
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Zona:</div>
                            <div class="line-height-xl">{{$customer->getZone->name}}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Contacto:</div>
                            <div class="line-height-xl">{{$customer->contact}}</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Periodo de pago:</div>
                            <div class="line-height-xl">{{$customer->payment_period}}</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Credito:</div>
                            <div class="line-height-xl">{{$customer->credit == 1 ? 'Sí' : 'No'}}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Recepción de saldo por email:</div>
                            <div class="line-height-xl">{{$customer->receive_emails == 1 ? 'Sí' : 'No'}}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Valor FullFill:</div>
                            <div class="line-height-xl">${{number_format($customer->fullfill)}}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Valor Handling:</div>
                            <div class="line-height-xl">${{number_format($customer->handling)}}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Valor COD:</div>
                            <div class="line-height-xl">${{number_format($customer->COD_value)}}</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Impuesto:</div>
                            <div class="line-height-xl">{{$customer->taxes == 1 ? 'Sí' : 'No'}}</div>
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
