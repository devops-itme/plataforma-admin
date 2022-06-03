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
                <div class="container mt-8">
                    {{-- <input type="text" id="order_id" hidden name="order_id" value="{{$order_id ?? null}}"> --}}
                    <label for="branch_off">Ciudades Destino</label>
                    <select name="city" class="custom-select" id="branch_off">          
                        @foreach ($destination['data'] as $destinations)
                            <option value="{{ $destinations['destinationCode'] }}" selected>
                                {{ $destinations['destinationCode'] }} - {{ $destinations['destinationName'] }}</option>      
                        @endforeach
                        <option value="" selected="selected">Seleccionar</option>
                    </select>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col mt-5">
                            <label for="codpais" class="form-label">Cod País</label>
                            <input type="text" class="form-control" name="country" id="codpais" disabled="disabled" value="{{ $destinations['parentCode'] }}">
                        </div>
                        <div class="col mt-5">
                            <label for="codciudad" class="form-label">Cod Ciudad</label>
                            <input type="text" class="form-control" id="codciudad" disabled="disabled"{{--  value="{{ $destinations['destinationCode'] }}" --}}>
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
                            <input type="text" class="form-control" id="recipient_name" aria-describedby="emailHelp"
                                placeholder="" name="recipient_name" class="@error('recipient_name') is-invalid @enderror">
                            @error('recipient_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="address_name">Dirección del destinatario</label>
                            <input type="text" class="form-control" id="address_name" placeholder="Direccion"
                                name="address_name" class="@error('address_name') is-invalid @enderror">
                            @error('address_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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
                            <label for="exampleInputPassword1">Número de documento</label>
                            <input type="number" class="form-control" id="numdocument" placeholder="N° de documento"
                                name="document">
                        </div>
                        <div class="col">
                            <label for="exampleInputPassword1">Teléfono</label>
                            <input type="number" class="form-control" id="telp" placeholder="Telefono" name="phone_contact">
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
                                <input class="form-check-input" type="checkbox" value="" name="chec" id="chec" onchange="comprobar();"/>
                                {{-- <input name="chec" type="checkbox" id="chec" onchange="comprobar();"/> --}}
                                <label class="form-check-label" for="flexCheckDefault">
                                    Recoger en tienda?
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            {{-- <label for="exampleInputPassword1">Tiendas</label>
                            <input type="text" class="form-control" id="tienda" placeholder="Seleccione una tienda--"> --}}
                            <label for="delivery_office">Tiendas</label>
                            <select name="delivery_office" class="custom-select" id="boton">          
                                @foreach ($tiendas['data'] as $tienda)
                                    <option value="{{ $tienda['name'] }}" selected>{{ $tienda['name'] }}</option>      
                                @endforeach
                                <option value="" selected="selected">Seleccionar</option>
                            </select>
                            {{-- <input type="text" class="form-control" id="boton">Este es el input anterior con js --}}
                            {{-- <select name="boton" class="custom-select" id="boton" readonly />
                                <option value="" disabled selected>Seleccionar</option>
                            </select>  --}}
                            {{-- <input name="text" id="boton" readonly /> --}}
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
                            <label for="numguide">Número de guía</label>
                            <input type="number" class="form-control" id="numdguia" placeholder="N° de Guía"
                                name="pre_guide">
                        </div>
                        <div class="col">
                            <label for="numfact">Número de Factura</label>
                            <input type="text" class="form-control" id="numdfact" placeholder="N° de Factura"
                                name="invoice_number">
                        </div>
                        <div class="col">
                            <label for="venvio">Valor declarado del envió</label>
                            <input type="number" class="form-control" id="telp" placeholder="Valor" name="declared">
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
                            <label for="kilo">Kilos</label>
                            <input type="text" class="form-control" id="numeroc" name="kg">
                        </div>
                        <div class="col">
                            <label for="incontact">Nombre del contactó</label>
                            <input type="text" class="form-control" id="contact" name="contact">
                        </div>

                        <div class="container">
                            <div class="row mt-10" >
                                <label for="textarea">Descripción</label>
                                <textarea class="form-control"  id="textarea" rows="3" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5 text-center">
                    <button type="submit" class="btn btn-primary">Crear Guía</button>
                </div>
        </div>
    </div>
    </form>
    </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
function comprobar()
{   
    if (document.getElementById("chec").checked)
      document.getElementById('boton').readOnly = false;
        
    else
      document.getElementById('boton').readOnly = true;
        
}
</script>

{{-- <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#branch_off > option[value=""]').attr('selected', 'selected');
});
</script> --}}



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
{{-- Styles Section --}}
@section('styles')
@endsection
