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
</div>

<!-- COORDINADORA SHIPMENTS DATA -->
<div class="card card-custom" id="CoordinadoraContent">
    <div class="card-header" style="padding-bottom: 25px">
        <form class="row g-3" method="post" action="#">
            @csrf
            
            <div class="card-title">
                <h2 class="card-label">
                    <hr width="750%" />
                    Datos del Destinatario
                    <hr width="750%" />
                </h2>
            </div>
            <div class="container mt-8">
                <div class="row">
                    <div class="col">
                        <label for="address_name">Nombres del destinatario</label>
                        <input class="form-control" value="{{ $order->nombres_destinatario }}" id="recipient_name" placeholder="Nombres" name="recipient_name" disabled></input>
                    </div>
                    <div class="col">
                        <label for="address_name">Apellidos del destinatario</label>
                        <input class="form-control" value="{{ $order->apellidos_destinatario }}" id="recipient_lastname" placeholder="Apellidos" name="recipient_lastname" disabled></input>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="recipient_name">Identificación del destinatario</label>
                        <input type="text" class="form-control" value="{{ $order->identificacion_destinatario }}" id="recipient_identification" placeholder="Identificación" name="recipient_identification" disabled>
                    </div>
                    <div class="col">
                        <label for="exampleInputPassword1">Teléfono fijo destinatario</label>
                        <input type="number" class="form-control" value="{{ $order->telefono_fijo_destinatario }}" id="recipient_phone" placeholder="Teléfono° de documento" name="recipient_phone" disabled>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="exampleInputPassword1">Teléfono celular destinatario</label>
                        <input type="number" class="form-control" value="{{ $order->telefono_celular_destinatario }}" id="recipient_cellphone" placeholder="N° de documento" name="recipient_cellphone" disabled>
                    </div>
                    <div class="col">
                        <label for="exampleInputPassword1">Código de la ciudad destinatario</label>
                        <input type="number" class="form-control" value="{{ $order->codigo_ciudad_destinatario }}" id="recipient_city_code" placeholder="Código de la ciudad" name="recipient_city_code" disabled>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="exampleInputPassword1">Ciudad del destinatario</label>
                        <input type="text" class="form-control" value="{{ $order->nombre_ciudad_destinatario }}" id="telp" placeholder="Telefono" name="phone_contact" name="contact" disabled>
                    </div>
                    <div class="col">
                        <label for="address_name">Dirección del destinatario</label>
                        <textarea class="form-control" value="" id="exampleInputP1" placeholder="Direccion" name="address_name" required disabled>{{ $order->direccion_destinatario }}
                        </textarea>
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
                        <label for="numguide">Código del pedido</label>
                        <input type="text" class="form-control" value="{{ $order->codigo_pedido }}" id="numdguia" placeholder="N° de Guía" name="pre_guide" disabled>
                    </div>
                    <div class="col">
                        <label for="numguide">Número del pedido</label>
                        <input type="text" class="form-control" value="{{ $order->numero_pedido }}" id="numdguia" placeholder="N° de Guía" name="pre_guide" disabled>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="numguide">Valor declarado</label>
                        <input type="number" class="form-control" value="{{$order->valor_declarado }}" id="numdguia" placeholder="N° de Guía" name="pre_guide" disabled>
                    </div>
                    <div class="col">
                        <label for="numfact">Hora y fecha del pedido</label>
                        <input type="text" class="form-control" value="{{ $order->horafecha_pedido ?? "No registra" }}" id="numdfact" placeholder="N° de Factura" name="invoice_number" disabled>
                    </div>

                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="numguide">¿Es pago contra entrega?</label>
                        <select name="" id="" class="form-control" disabled>
                            <option value="No" selected>No</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="numfact">¿Entrega el mismo día?</label>
                        @if ($order->es_entrega_mismo_dia == "N")
                            <input type="text" class="form-control" value="No" id="telp" placeholder="Telefono" name="declared" disabled>
                        @else
                        <input type="text" class="form-control" value="Si" id="telp" placeholder="Telefono" name="declared" disabled>
                        @endif
                        
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="numguide">Estado de la guía</label>
                        @if ($order->state == null)
                            <input type="text" class="form-control" value="Sin registrar" disabled>
                        @else
                        <input type="text" class="form-control" value="Registrada" disabled>
                        @endif
                    </div>
                    <div class="col">
                        <label for="numfact">Estado del envío</label>
                        @if ($order->status == null)
                            <input type="text" class="form-control" value="Sin información registrada" disabled>
                        @else
                        <input type="text" class="form-control" value="{{ $order->status }}" disabled>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-title">
                <h2 class="card-label">
                    <hr width="790%" />
                        Detalle de productos
                    <hr width="790%" />
                </h2>
            </div>

            <div class="container">
                <div class="row mt-10">
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Unidades</th>
                                <th>Peso (kg)</th>
                                <th>Alto (cm)</th>
                                <th>Ancho (cm)</th>
                                <th>Largo (cm)</th>
                                <th>Nombre del empaque</th>
                            </tr>
                        </thead>
                        
                        @foreach ($orderDetails as $product)
                        <tbody>
                            @if (count($orderDetails) == 0)
                                <td colspan="8">Sin productos asociados</td>
                            @endif
                            <td>{{ $product->referencia }}</td>
                            <td>{{ $product->unidades }}</td>
                            <td>{{ $product->peso }}</td>
                            <td>{{ $product->alto }}</td>
                            <td>{{ $product->ancho }}</td>
                            <td>{{ $product->largo }}</td>
                            <td>{{ $product->nombre_empaque }}</td>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
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

<style>
    th {
        border-right: 1px solid rgb(0, 154, 201);
        border-left: 1px solid rgb(0, 154, 201);
    }
    table {
        text-align: center;
    }
</style>