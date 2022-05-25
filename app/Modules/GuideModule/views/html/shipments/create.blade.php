<!-- Formulario Create-->
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
                    Guias Individuales
                </h2>
            </div>
        </div>
    </div>
    <div class="card card-custom">
        <div class="card-header">
            <form class="row g-3" method="post" action="{{ route('shipments.store', ['order_id' => $order_id]) }}">
                @csrf
                <div class="input-group mt-5">
                    <div class="input-group-prepend">
                        {{-- <input type="text" id="order_id" hidden name="order_id" value="{{$order_id ?? null}}"> --}}
                        <label for="branch_off">ciudades destino <span class="text-danger">*</span></label>
                    </div>
                    <select name="branch_office" class="custom-select" id="branch_off">
                        <option value="" disabled selected>Seleccionar</option>
                    </select>
                </div>
                <div class="col-md-6 mt-5">
                    <label for="inputPassword4" class="form-label">Cod País</label>
                    <input type="number" class="form-control" id="inputPassword4" disabled="disabled" >
                </div>
                <div class="col-md-6 mt-5">
                    <label for="inputAddress" class="form-label">Cod Ciudad</label>
                    <input type="text" class="form-control" id="inputAddress" disabled="disabled">
                </div>
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="card-label">
                            Datos del usuario destinatario
                        </h2>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label for="exampleInputEmail1">Nombre del destinatario</label>
                            <input type="text" class="form-control" id="exampleInputE1" aria-describedby="emailHelp"
                                placeholder="Juan Perez" name="recipient_name" required>
                        </div>
                        <div class="col">
                            <label for="exampleInputPassword1">Direccion del destinatario</label>
                            <input type="text" class="form-control" id="exampleInputP1" placeholder="Direccion"
                                name="address_name" required>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row mt-10">
                        <div class="col">
                            <label for="exampleInputEmail1">Tipo de documento</label>
                            <select class="custom-select" id="tipdocumento" name="document_type">
                                <option selected></option>
                                <option value="CC">CC</option>
                                <option value="TE">TE</option>
                                <option value="NN">NN</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="exampleInputPassword1">Numero de documento</label>
                            <input type="number" class="form-control" id="numdocument" placeholder="N° de documento"
                                name="document">
                        </div>
                        <div class="col">
                            <label for="exampleInputPassword1">Telefono</label>
                            <input type="number" class="form-control" id="telp" placeholder="Telefono"
                                name="contact">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row mt-10">
                        <div class="col">
                            <label for="exampleInputPassword1">Correo</label>
                            <input type="mail" class="form-control" id="mailco" placeholder="mail@mail.com"
                                name="email_contact">
                        </div>
                        <div class="col">
                            <div class="form-check mt-10">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Recoger en tienda?
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <label for="exampleInputPassword1">Tiendas</label>
                            <input type="text" class="form-control" id="tienda" placeholder="Seleccione una tienda">
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="card-label">
                            Datos de la Guía
                        </h2>
                    </div>
                </div>
                {{-- datos de la guia --}}
                <div class="container">
                    <div class="row mt-10">
                        <div class="col">
                            <label for="numguide">Numero de guía</label>
                            <input type="number" class="form-control" id="numdguia" placeholder="N° de Guía"
                                name="pre_guide">
                        </div>
                        <div class="col">
                            <label for="numfact">Numero de Factura</label>
                            <input type="text" class="form-control" id="numdfact" placeholder="N° de Factura"
                                name="invoice_number">
                        </div>
                        <div class="col">
                            <label for="venvio">Valor declarado del envió</label>
                            <input type="number" class="form-control" id="telp" placeholder="Telefono" name="declared">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row mt-10">
                        <div class="col">
                            <label for="pieza">Piezas</label>
                            <input type="number" class="form-control" id="pieces" name="pieces">
                        </div>
                        <div class="col">
                            <label for="kilo">kilos</label>
                            <input type="text" class="form-control" id="numeroc" name="kg">
                        </div>
                        <div class="col">
                            <label for="incontact">Nombre del conctacto</label>
                            <input type="text" class="form-control" id="contact" name="invoice_contact">
                        </div>

                        <div class="container">
                            <div class="row mt-10">
                                <label for="textarea">Descripción</label>
                                <textarea class="form-control" id="textarea" rows="3" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5 text-center">
                    <button type="submit" class="btn btn-primary">Crear Orden</button>
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
