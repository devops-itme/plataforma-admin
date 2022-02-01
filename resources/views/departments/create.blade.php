{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')

<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Crear departamento
        </h3>
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
    <form method="POST" action="{{route('department.store')}}">
        @csrf
        <div class="card-body d-flex flex-row flex-wrap">

            <div class="form-group col-md-6">
                <label>Nombres: <span class="text-danger">*</span></label>
                <input name="name" type="text" class="form-control form-control-solid" placeholder="Nombre" value="{{old('name')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-6">
                <label>Estado</label>
                <select class="form-control form-control-solid" id="document_type" name="state">
                    <option selected disabled>Seleccione</option>
                    <option value="1" {{old('state')==1?'selected':''}} > Activo</option>
                    <option value="0" {{old('state')==0?'selected':''}} > Inactivo</option>
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-12">
                <label>Descripción</label>
                <textarea name="description" class="form-control form-control-solid" cols="30" rows="10">
                    {{old('description')}}
                </textarea>
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
