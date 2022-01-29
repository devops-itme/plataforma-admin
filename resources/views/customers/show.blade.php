{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h2 class="card-label h1">Ver cliente
                </h2>
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
                            <div class="line-height-xl">John Wick</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Email:</div>
                            <div class="line-height-xl">correo@correo.com</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Telefono:</div>
                            <div class="line-height-xl">3000000</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Tipo y numero de documento:</div>
                            <div class="line-height-xl"><b>CC</b> / 1.125.251.255</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Fecha de nacimiento:</div>
                            <div class="line-height-xl">12/12/2022</div>
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
                            <div class="line-height-xl">Panes calientes de killa S.A</div>
                        </div>
                        <div class="col-md-6">
                            <div class="font-weight-bolder mb-3">Nombre comercial:</div>
                            <div class="line-height-xl">Pan Santana</div>
                        </div>
                    </div>
                    <div class="row mb-5 pb-5 border-bottom">
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Zona:</div>
                            <div class="line-height-xl">Zona #1</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Contacto:</div>
                            <div class="line-height-xl">Juanito Perez, 3000000</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Periodo de pago:</div>
                            <div class="line-height-xl">Del 15 al 30</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Credito:</div>
                            <div class="line-height-xl">SI</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Recepción de saldo por email:</div>
                            <div class="line-height-xl">SI</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Valor FullFill:</div>
                            <div class="line-height-xl">$100.000</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Valor Handling:</div>
                            <div class="line-height-xl">$100.000</div>
                        </div>
                        <div class="col-md-3">
                            <div class="font-weight-bolder mb-3">Valor COD:</div>
                            <div class="line-height-xl">$100.000</div>
                        </div>
                        <div class="col-md-2">
                            <div class="font-weight-bolder mb-3">Impuesto:</div>
                            <div class="line-height-xl">SI</div>
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
