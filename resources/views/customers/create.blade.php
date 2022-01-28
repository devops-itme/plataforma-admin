{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Crear cliente
        </h3>
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
    <form action="{{route('clientes.store')}}" method="post">
        @csrf
        <div class="card-body d-flex flex-row flex-wrap">

            <div class="form-group col-md-4">
                <label>Nombres: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Apellidos <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" />
            </div>
            <div class="form-group col-md-4">
                <label>Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Telefono: <span class="text-danger">*</span></label>
                <input type="tel" class="form-control form-control-solid" placeholder="Telefono" name="phone" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Tipo de documento</label>
                {{-- <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" checked="checked" name="radios15_1" />
                        <span></span>
                        Cedula
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="radios15_1" />
                        <span></span>
                        NIT
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="radios15_1" />
                        <span></span>
                        RUT
                    </label>
                </div> --}}
                <select class="form-control form-control-solid" id="document_type" name="document_type">
                    <option selected disabled>Seleccione</option>
                    @foreach($documents as $document)
                        <option value="{{$document->id}}">{{$document->name}}</option>
                    @endforeach
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Numero de identificación: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="N° de identificación" name="document_number" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Fecha de nacimiento: <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-solid" placeholder="" name="birthday" />
                <span class="form-text text-muted"></span>
            </div>

            <div class="form-group col-md-4">
                <label for="exampleSelect1">Zona <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid" id="zone" name="zone">
                    <option selected disabled> Seleccione </option>
                    <option value="1">Zona 1</option>
                    <option value="2">Zona 2</option>
                    <option value="3">Zona 3</option>
                    <option value="4">Zona 4</option>
                    <option value="5">Zona 5</option>
                </select>
            </div>
            <div class="form-group col-md-4 mb-1">
                <label for="exampleTextarea">Contacto <span class="text-danger">*</span></label>
                <textarea class="form-control form-control-solid" id="exampleTextarea" rows="3" name="contact"></textarea>
            </div>
            <div class="form-group col-md-3 my-3">
                <label for="payment_pediod">Periodo de pago <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid px-2 placeholder-dark-75" id="payment_period" name="payment_period">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="form-group col-md-2 mb-0 py-4">
                <label>Credito</label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" checked="checked" name="credit" value="1" />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="credit" value="0" />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-2 mb-0 py-4">
                <label>Enviar saldo por Email</label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" checked="checked" name="receive_emails" value="1" />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="receive_emails" value="0" />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor FullFill <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="fullfill" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor Handling <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="handling" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor COD <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="COD_value" />
            </div>
            <div class="form-group col-md-4 mb-0 py-4">
                <label>Impuesto <span class="text-danger">*</span></label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" name="taxes" value="1" />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" checked="checked" name="taxes" value="0" />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre de empresa <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="text" name="business_name" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre comercial <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="text" name="tradename" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Repetir Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password_repeat" />
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </div>
    </form>
    <!--end::Form-->
</div>

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
