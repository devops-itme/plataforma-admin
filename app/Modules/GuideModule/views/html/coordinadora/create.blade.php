<!-- Formulario Show-->
{{-- Extends layout --}}
@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
@include('layouts.alerts')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h2 class="card-label">
                Crear guía
            </h2>
        </div>
    </div>
</div>

<!-- COORDINADORA SHIPMENTS DATA -->
<div class="card card-custom" id="CoordinadoraContent">
    <div class="card-header" style="padding-bottom: 25px">
        <form class="row g-3" method="post" action="{{ route('coordinadora.store.guide') }}">
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
                        <input type="number" value="{{ $order_id }}" id="order_id" name="order_id" hidden>
                        <label for="address_name">Nombres del destinatario</label>
                        <input class="form-control" value="" id="nombres_destinatario" placeholder="Nombres" name="nombres_destinatario" required></input>
                    </div>
                    <div class="col">
                        <label for="address_name">Apellidos del destinatario</label>
                        <input class="form-control" value="" id="apellidos_destiantario" placeholder="Apellidos" name="apellidos_destinatario" required></input>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="recipient_name">Identificación del destinatario</label>
                        <input type="number" class="form-control" value="" id="identificacion_destinatario" placeholder="Identificación" name="identificacion_destinatario" required>
                    </div>
                    <div class="col">
                        <label for="exampleInputPassword1">Teléfono fijo destinatario</label>
                        <input type="number" class="form-control" value="" id="telefono_fijo_destinatario" placeholder="Teléfono fijo" name="telefono_fijo_destinatario" required>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="exampleInputPassword1">Teléfono celular destinatario</label>
                        <input type="number" class="form-control" value="" id="telefono_celular_destinatario" placeholder="Teléfono celular" name="telefono_celular_destinatario" required>
                    </div>
                    <div class="col">
                        <label for="exampleInputPassword1">Código de la ciudad destinatario</label>
                        <input type="number" class="form-control" value="" id="codigo_ciudad_destinatario" placeholder="Código de la ciudad" name="codigo_ciudad_destinatario" required>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="exampleInputPassword1">Ciudad del destinatario</label>
                        <select name="ciudad_destinatario" id="ciudad_destinatario" class="form-control" onchange="getCityCode(this.value)" required>
                            <option value="0" selected disabled>Seleccione la ciudad del destinatario</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->codigo_ciudad }}">{{ $city->nombre_ciudad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" value="" id="nombre_ciudad_destinatario" name="nombre_ciudad_destinatario" hidden>
                    <div class="col">
                        <label for="address_name">Dirección del destinatario</label>
                        <textarea minlength="10" class="form-control" value="" id="direccion_destinatario" placeholder="Direccion" name="direccion_destinatario" required>
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
                        <input type="number" class="form-control" value="" id="codigo_pedido" placeholder="Codigo del pedido" name="codigo_pedido" required>
                    </div>
                    <div class="col">
                        <label for="numguide">Número del pedido</label>
                        <input type="number" class="form-control" value="" id="numero_pedido" placeholder="N° de pedido" name="numero_pedido" required>
                    </div>
                </div>
            </div>
            
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="numguide">¿Es pago contra entrega?</label>
                        <select name="es_pago_contra_entrega" id="" class="form-control" disabled>
                            <option value="N">NO</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="numfact">¿Entrega el mismo día?</label>
                        <select name="es_entrega_mismo_dia" id="es_entrega_mismo_dia" class="form-control" required>
                            <option value="0" selected disabled>Seleccione opción</option>
                            <option value="N">No</option>
                            <option value="S">Si</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-10">
                    <div class="col">
                        <label for="numguide">Valor declarado</label>
                        <input type="number" step="0.01" class="form-control" value="" id="valor_declarado" placeholder="Valor declarado" name="valor_declarado" required>
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
                                <th style="width: 100px;">Unidades</th>
                                <th style="width: 100px;">Peso (kg)</th>
                                <th style="width: 100px;">Alto (cm)</th>
                                <th style="width: 100px;">Ancho (cm)</th>
                                <th style="width: 100px;">Largo (cm)</th>
                                <th>Nombre del empaque</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            <td><input type="text" id="referencia" name="referencia" placeholder="Ej: 388JF9D99" class="form-control" maxlength="20" required></td>
                            <td><input type="number" step="0.01" name="unidades" id="unidades" placeholder="Ej: 25" style="width: 100px;" class="form-control" required></td>
                            <td><input type="number" step="0.01" name="peso" id="peso" placeholder="Ej: 10.5" style="width: 100px;" class="form-control" required></td>
                            <td><input type="number" step="0.01" name="alto" id="alto" placeholder="Ej: 10.5" style="width: 100px;" class="form-control" required></td>
                            <td><input type="number" step="0.01" name="ancho" id="ancho" placeholder="Ej: 10.5" style="width: 100px;" class="form-control" required></td>
                            <td><input type="number" step="0.01" name="largo" id="largo" placeholder="Ej: 10.5" style="width: 100px;" class="form-control" required></td>
                            <td><input type="text" name="nombre_empaque" id="nombre_empaque" placeholder="Ej: tarjeta máster card" class="form-control" required></td>
                            <td>Eliminar</td>
                        </tbody>
                    </table>
                    <div class="col-12 mt-5 text-center">
                        <button type="submit" class="btn btn-primary">Crear Guía</button>
                    </div>
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

<script>
    function getCityCode(code){
        document.getElementById("codigo_ciudad_destinatario").value = code;
        var select = document.getElementById("ciudad_destinatario");
        cityName = select.options[select.selectedIndex].innerText;
        document.getElementById("nombre_ciudad_destinatario").value = cityName;
    }
</script>