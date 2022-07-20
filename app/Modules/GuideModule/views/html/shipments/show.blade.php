<!-- Formulario Show-->
{{-- Extends layout --}}
@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')

<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h2 class="card-label">
                Ver Guias
            </h2>
        </div>
    </div>

    @if ($history['state'] == 200)
        <br>
        <div style="margin-left: 9%">
            <table>
                    <tr>
                        <td style="font-size:13px">Estado </td>
                    </tr>
                    <tr>
                    <td style="font-size:13px">
                            @switch($info[0]['status'])
                            @case('Creacion')
                            <span class="badge badge-pill badge-success">VERIFICACION</span>
                            @break
                            @case('Recepcion desde plataforma')
                            <span class="badge badge-pill badge-success">RECEPTADO EN BODEGA</span>
                            @break
                            @case('Recepcion desde tienda')
                            <span class="badge badge-pill badge-success">RECEPCION EN SUCURSAL</span>
                            @break
                            @case('Despacho a tienda (tienda destino para entrega al cliente)')
                            <span class="badge badge-pill badge-success">DESPACHO A SUCURSAL</span>
                            @break
                            @default
                            <span class="badge badge-pill badge-success">{{$info[0]['status']}}</span>
                            @endswitch
                        </td>
                    </tr>
            </table>
        </div>
        @endif
</div>
<div class="card card-custom">
    <div class="card-header" style="padding-bottom: 25px">
        <form class="row g-3" method="post" action="#">
            @csrf
            <div class="container mt-8">
                {{-- <input type="text" id="order_id" hidden name="order_id" value="{{$order_id ?? null}}"> --}}
                <label for="branch_off">Ciudades destino <span class="text-danger"></span></label>
                <select name="city" class="custom-select" id="city" disabled>
                    <option value="{{$guide->city}}">{{$guide->city}}</option>
                </select>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col mt-5">
                        <label for="inputCountry" class="form-label">Cod País</label>
                        <input type="text" class="form-control" value="{{$guide->country}}" id="inputCountry" disabled="disabled">
                    </div>
                    <div class="col mt-5">
                        <label for="inputAddress" class="form-label">Cod Ciudad</label>
                        <input type="text" value="{{$guide->city}}" class="form-control" id="inputAddress" disabled="disabled">
                    </div>
                </div>
            </div>

            <div class="card-title">
                <h2 class="card-label">
                    <hr width="545%" />
                    Datos del usuario destinatario
                    <hr width="545%" />
                </h2>
            </div>

            <div class="container mt-8">
                <div class="row">
                    <div class="col">
                        <label for="recipient_name">Nombre del destinatario</label>
                        <input type="text" class="form-control" value="{{$guide->recipient_name}}" id="exampleInputE1" aria-describedby="emailHelp" placeholder="" name="recipient_name" required disabled>
                    </div>
                    <div class="col">
                        <label for="address_name">Direccion del destinatario</label>
                        <textarea class="form-control" value="" id="exampleInputP1" placeholder="Direccion" name="address_name" required disabled>{{$guide->address_name}}</textarea>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="exampleInputEmail1">Tipo de documento</label>
                        <select class="custom-select" id="tipdocumento" name="document_type" disabled>
                            <option>{{$guide->document_type}}</option>
                            <option value="CC">CC</option>
                            <option value="TE">TE</option>
                            <option value="NN">NN</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="exampleInputPassword1">Numero de documento</label>
                        <input type="number" class="form-control" value="{{$guide->document}}" id="numdocument" placeholder="N° de documento" name="document" disabled>
                    </div>
                    <div class="col">
                        <label for="exampleInputPassword1">Telefono</label>
                        <input type="number" class="form-control" value="{{$guide->phone_contact}}" id="telp" placeholder="Telefono" name="phone_contact" name="contact" disabled>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="exampleInputPassword1">Correo</label>
                        <input type="mail" class="form-control" value="{{$guide->email_contact}}" id="mailco" placeholder="mail@mail.com" name="email_contact" disabled>
                    </div>
                    <div class="col">
                        <div class="form-check mt-10">
                            <input class="form-check-input" type="checkbox" disabled value="" id="flexCheckDefault" disabled>
                            <label class="form-check-label" for="flexCheckDefault">
                                Recoger en tienda?
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <label for="delivery_office">Tiendas</label>
                        <select name="delivery_office" disabled class="custom-select" id="delivery_office">
                            <option value="{{$guide->delivery_office}}" disabled selected>{{$guide->delivery_office}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-title mt-8">
                <h2 class="card-label">
                    <hr width="1000%" />
                    Datos de la Guía
                    <hr width="1000%" />
                </h2>
            </div>

            {{-- datos de la guia --}}
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="numguide">Numero de guía</label>
                        <input type="number" class="form-control" value="{{$guide->pre_guide}}" id="numdguia" placeholder="N° de Guía" name="pre_guide" disabled>
                    </div>
                    <div class="col">
                        <label for="numfact">Numero de Factura</label>
                        <input type="text" class="form-control" value="{{$guide->invoice_number}}" id="numdfact" placeholder="N° de Factura" name="invoice_number" disabled>
                    </div>
                    <div class="col">
                        <label for="venvio">Valor declarado del envió</label>
                        <input type="number" class="form-control" value="{{$guide->declared}}" id="telp" placeholder="Telefono" name="declared" disabled>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="pieza">Piezas</label>
                        <input type="number" class="form-control" value="{{$guide->pieces}}" id="pieces" name="pieces" disabled>
                    </div>
                    <div class="col">
                        <label for="kilo">kilos</label>
                        <input type="text" class="form-control" value="{{$guide->kg}}" id="numeroc" name="kg" disabled>
                    </div>
                    <div class="col">
                        <label for="incontact">Nombre del conctacto</label>
                        <input type="text" class="form-control" value="{{$guide->contact}}" id="contact" name="contact" disabled>
                    </div>

                    <div class="container">
                        <div class="row mt-10">
                            <label for="textarea">Descripción</label>
                            <textarea class="form-control" value="" id="textarea" rows="3" name="description" disabled>{{$guide->description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            @if ($history['state'] == 200)
            <div class="card-body">
                <hr>
                <div class="table-responsive" style="overflow: auto;">
                    <table class="table align-items-center text-center table-flush  table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Fecha - Hora</th>
                                <th style="position: relative; left:-14.1em;" scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($info as $tracking)
                            <tr>
                                <td>{{ date('Y-m-d h:i:s', strtotime($tracking['date'])) }}</td>
                                <td style="padding: 0 70% 0 0">
                                    @switch($tracking['status'])
                                    @case('Creacion')
                                    <span class="badge badge-pill badge-success">VERIFICACION</span>
                                    @break
                                    @case('Recepcion desde plataforma')
                                    <span class="badge badge-pill badge-success">RECEPTADO EN BODEGA</span>
                                    @break
                                    @case('Recepcion desde tienda')
                                    <span class="badge badge-pill badge-success">RECEPCION EN SUCURSAL</span>
                                    @break
                                    @case('Despacho a tienda (tienda destino para entrega al cliente)')
                                    <span class="badge badge-pill badge-success">DESPACHO A SUCURSAL</span>
                                    @break
                                    @default
                                    <span class="badge badge-pill badge-success">{{$info['status']}}</span>
                                    @endswitch
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @endif

    </div>
</div>
</form>
</div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
{{-- Styles Section --}}
@section('styles')
@endsection
