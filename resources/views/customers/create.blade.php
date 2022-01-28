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
    <!--begin::Form-->
    <form>
        <div class="card-body row">

            <div class="form-group col-md-4">
                <label>Nombres: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Nombres" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Apellidos <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Apellidos" />
            </div>
            <div class="form-group col-md-4">
                <label>Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Telefono: <span class="text-danger">*</span></label>
                <input type="tel" class="form-control form-control-solid" placeholder="Telefono" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Tipo de documento</label>
                <div class="radio-inline">
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
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Numero de identificación: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="N° de identificación" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Fecha de nacimiento: <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-solid" placeholder="" />
                <span class="form-text text-muted"></span>
            </div>

            <div class="form-group col-md-4">
                <label for="exampleSelect1">Zona <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid" id="exampleSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="form-group col-md-4 mb-1">
                <label for="exampleTextarea">Contacto <span class="text-danger">*</span></label>
                <textarea class="form-control form-control-solid" id="exampleTextarea" rows="3"></textarea>
            </div>
            <div class="form-group col-md-3 my-3">
                <label for="payment_pediod">Periodo de pago <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid px-2 placeholder-dark-75" id="payment_pediod">
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
                        <input type="radio" checked="checked" name="credit" />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="credit" />
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
                        <input type="radio" checked="checked" name="send_ballances" />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="send_ballances" />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor FullFill <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="fullfill_value" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor Handling <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="handling_value" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor COD <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="cod_value" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre de empresa <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="bussines_name" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre comercial <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="tradename" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password_first" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Repetir Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password_repeat" />
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" class="btn btn-primary mr-2">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </div>
    </form>
    <!--end::Form-->
</div>

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
