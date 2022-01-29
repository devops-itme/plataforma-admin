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
    @include('layouts.alerts')
    <!--begin::Form-->
    <form method="POST" action="{{route('messenger.store')}}" id="formCreateMessenger">
        @csrf
        <div class="card-body d-flex flex-row flex-wrap">

            <div class="form-group col-md-4">
                <label>Nombres: <span class="text-danger">*</span></label>
                <input name="name" type="text" class="form-control form-control-solid" placeholder="Nombres" value="{{old('name')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Apellidos <span class="text-danger">*</span></label>
                <input name="last_name" type="text" class="form-control form-control-solid" placeholder="Apellidos" value="{{old('last_name')}}" />
            </div>
            <div class="form-group col-md-4">
                <label>Email: <span class="text-danger">*</span></label>
                <input name="email" type="email" class="form-control form-control-solid" placeholder="Email" value="{{old('email')}}"/>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Telefono: <span class="text-danger">*</span></label>
                <input name="phone" type="tel" class="form-control form-control-solid" placeholder="Telefono" value="{{old('phone')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label for="type_doc">Tipo de documento <span class="text-danger">*</span></label>
                <select name="document_type" class="form-control form-control-solid" id="type_doc">
                    <option selected disabled>Seleccione tipo de documento</option>
                    @foreach($document_type as $document)
                        <option {{old('document')==$document->id?'selected ':''}}  value="{{$document->id}}">{{$document->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>Numero de identificación: <span class="text-danger">*</span></label>
                <input name="document_number" type="text" class="form-control form-control-solid" placeholder="N° de identificación" value="{{old('document_number')}}"/>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Placa de vehiculo: <span class="text-danger">*</span></label>
                <input name="vehicle_plate" type="text" class="form-control form-control-solid" placeholder="" value="{{old('vehicle_plate')}}"/>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Fecha de ingreso: <span class="text-danger">*</span></label>
                <input name="admission_date" type="date" class="form-control form-control-solid" placeholder="" value="{{old('admission_date')}}"/>
                <span class="form-text text-muted"></span>
            </div>

            <div class="form-group col-md-4">
                <label>Porcentaje de producción: <span class="text-danger">*</span></label>
                <input name="production_percentage" type="number" class="form-control form-control-solid" placeholder="" value="{{old('production_percentage')}}"/>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Exclusivo</label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" checked="checked" name="exclusive" value="1" />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="exclusive" value="0" />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Contrato <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="file" name="contract" value="{{old('contract')}}"/>
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Repetir Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password_confirmation"/>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" id="btn-create-messenger" class="btn btn-primary mr-2">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </div>
    </form>
    <!--end::Form-->
</div>

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
