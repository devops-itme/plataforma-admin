<!-- Formulario Edit-->
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
                    Editar Guias
                </h2>
            </div>
        </div>
    </div>
    <div class="card card-custom">
        <div class="card-header">
            <form class="row g-3" method="post" action="{{ route('shipments.update', $guide->id,['guide_id' => $guide->id]) }}">
               @csrf {{ method_field('PUT') }}
                <div class="container mt-8">
                        {{-- <input type="text" id="order_id" hidden name="order_id" value="{{$order_id ?? null}}"> --}}
                        <label for="branch_off">ciudades destino <span class="text-danger">*</span></label>
                        <select name="city" class="custom-select" id="branch_off">

                            @foreach ($destination['data'] as $destinations)
                                <option value="{{ $destinations['destinationCode'] }}" selected>
                                    {{ $destinations['destinationCode'] }} - {{ $destinations['destinationName'] }}</option>
                            @endforeach
                            <option value="{{$guide->city}}" selected="selected">{{$guide->city}}</option>
                        </select>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col mt-5">
                    <label for="inputCountry" class="form-label">Cod País</label>
                    <input type="text" class="form-control" id="codpais" disabled="disabled" value="{{ $destinations['parentCode'] }}">
                </div>
                <div class="col mt-5">
                <label for="codciudad" class="form-label">Cod Ciudad</label>
                    <input type="text" class="form-control" id="codciudad" disabled="disabled" value="{{$guide->city}}">
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
                            <input type="text" class="form-control" value="{{$guide->recipient_name}}" id="exampleInputE1" aria-describedby="emailHelp"
                             placeholder="" name="recipient_name" required>
                        </div>
                        <div class="col">
                            <label for="address_name">Direccion del destinatario</label>
                            <input type="text" class="form-control" value="{{$guide->address_name}}"  id="exampleInputP1" placeholder="Direccion"
                                name="address_name" required>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row mt-10">
                        <div class="col">
                            <label for="exampleInputEmail1">Tipo de documento</label>
                            <select class="custom-select" id="tipdocumento" name="document_type">
                                <option >{{$guide->document_type}}</option>
                                <option value="CC">CC</option>
                                <option value="TE">TE</option>
                                <option value="NN">NN</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="exampleInputPassword1">Numero de documento</label>
                            <input type="number" class="form-control" value="{{$guide->document}}" id="numdocument" placeholder="N° de documento"
                                name="document">
                        </div>
                        <div class="col">
                            <label for="exampleInputPassword1">Telefono</label>
                            <input type="number" class="form-control"  value="{{$guide->phone_contact}}" id="telp" placeholder="Telefono" name="phone_contact">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row mt-10">
                        <div class="col">
                            <label for="exampleInputPassword1">Correo</label>
                            <input type="mail" class="form-control" value="{{$guide->email_contact}}" id="mailco" placeholder="mail@mail.com"
                                name="email_contact">
                        </div>
                        <div class="col">
                            <div class="form-check mt-10">
                                <input type="checkbox" id="check" onchange="habilitar(this.checked);" checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Recoger en tienda?
                                </label>
                            </div>
                        </div>
                        <div class="col">
                               <label for="delivery_office">Tiendas</label>
                            <select name="delivery_office" class="custom-select" id="delivery_office">
                                @foreach ($tiendas['data'] as $tienda)
                                    <option value="{{ $tienda['name'] }}" selected>{{ $tienda['name'] }}</option>
                                @endforeach
                                <option value="{{$guide->delivery_office}}" selected="selected">{{$guide->delivery_office}}</option>
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
                            <input type="number" class="form-control" value="{{$guide->pre_guide}}" id="numdguia" placeholder="N° de Guía"
                                name="pre_guide">
                        </div>
                        <div class="col">
                            <label for="numfact">Numero de Factura</label>
                            <input type="text" class="form-control" value="{{$guide->invoice_number}}"  id="numdfact" placeholder="N° de Factura"
                                name="invoice_number">
                        </div>
                        <div class="col">
                            <label for="venvio">Valor declarado del envió</label>
                            <input type="number" class="form-control" value="{{$guide->declared}}" id="telp" placeholder="Telefono" name="declared">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row mt-10">
                        <div class="col">
                            <label for="pieza">Piezas</label>
                            <input type="number" class="form-control" value="{{$guide->pieces}}" id="pieces" name="pieces">
                        </div>
                        <div class="col">
                            <label for="kilo">kilos</label>
                            <input type="text" class="form-control" value="{{$guide->kg}}" id="numeroc" name="kg">
                        </div>
                        <div class="col">
                            <label for="incontact">Nombre del conctacto</label>
                            <input type="text" class="form-control" value="{{$guide->contact}}" id="contact" name="contact">
                        </div>

                        <div class="container">
                            <div class="row mt-10">
                                <label for="textarea">Descripción</label>
                                <textarea class="form-control" value="{{$guide->description}}"  id="textarea" rows="3" name="description">{{$guide->description}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5 text-center">
                    <button type="submit" class="btn btn-primary">Actualizar Guia</button>
                </div>
        </div>
    </div>
    </form>
    </div>
    </div>

@endsection


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>
	$(function(){
  	$(document).on('change','#branch_off',function(){ //detectamos el evento change
         var value = $(this).val();
        $('#codciudad').val(value);

/*         $(document).ready(function(){
   $('#branch_off > option[value="0"]').attr('selected', 'selected'); */
});

    });
 /*  }); */
</script>

<script>
    function habilitar(value) {
        if (value == true) {
            // habilitamos
            document.getElementById("delivery_office").disabled = false;
        } else if (value == false) {
            // deshabilitamos
            document.getElementById("delivery_office").disabled = true;
        }
    }
</script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
{{-- Styles Section --}}
@section('styles')
@endsection
