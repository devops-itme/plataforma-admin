{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')

<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Crear mensajero
        </h3>
    </div>
    <!--begin::Form-->
    <form>
        <div class="card-body d-flex flex-row flex-wrap">

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
                <label for="type_doc">Tipo de documento <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid" id="type_doc">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>Numero de identificación: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="N° de identificación" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Placa de vehiculo: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Fecha de ingreso: <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-solid" placeholder="" />
                <span class="form-text text-muted"></span>
            </div>

            <div class="form-group col-md-4">
                <label>Porcentaje de producción: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Exclusivo</label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" checked="checked" name="exclusive" />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="exclusive" />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Contrato <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="text" name="contrat" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password_first" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
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
