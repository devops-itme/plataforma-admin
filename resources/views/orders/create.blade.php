{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')

<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Crear orden
        </h3>
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
    <form method="POST" action="{{route('messenger.store')}}" id="formCreateMessenger"  enctype="multipart/form-data">
        @csrf
        <div class="card-body d-flex flex-row flex-wrap pt-2">
            <h5 class="my-4 font-weight-bold text-dark col-md-12">Información basica de orden</h5>
            <div class="form-group col-md-2">
                <label>Numero de orden: <span class="text-danger">*</span></label>
                <input name="order_num" type="text" class="form-control form-control-solid" placeholder="333" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label for="type_doc">Tipo de orden <span class="text-danger">*</span></label>
                <select name="orden_type" class="form-control form-control-solid" id="order_type">
                    <option selected disabled>Seleccione tipo de orden</option>
                        <option>Ondeman</option>
                        <option>Multiple</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="type_doc">Cliente <span class="text-danger">*</span></label>
                <select name="customers" class="form-control form-control-solid selectpicker" id="customers">
                    <option selected disabled>Seleccione Cliente</option>
                        <option>Cliente 1</option>
                        <option>Cliente 2</option>
                        <option>Cliente 3</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Fecha de ingreso: <span class="text-danger">*</span></label>
                <input name="admission_date" type="date" class="form-control form-control-solid" placeholder="" value="{{old('admission_date')}}"/>
                <span class="form-text text-muted"></span>
            </div>

            <div class="form-group col-md-2">
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
