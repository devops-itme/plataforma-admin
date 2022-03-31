{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')

<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Detalle del usuario
        </h3>
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
    <form action="" method="post">
        @csrf @method('PUT')
        <div class="card-body d-flex flex-row flex-wrap">

            <div class="form-group col-md-3">
                <label>Nombres: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid disabled" placeholder="Nombres" name="name" value="{{$user->name}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Apellidos <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" value="{{$user->last_name}}" />
            </div>
            <div class="form-group col-md-3">
                <label>Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="{{$user->email}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Estado</label>
                <select class="form-control form-control-solid" id="document_type" name="state">
                    <option value="1" {{$user->state==1?'selected':''}} > Activo</option>
                    <option value="0" {{$user->state==0?'selected':''}} > Inactivo</option>
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Teléfono: <span class="text-danger">*</span></label>
                <input type="tel" class="form-control form-control-solid" placeholder="Teléfono" name="phone" value="{{$user->phone}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Rol</label>
                <select class="form-control form-control-solid" id="document_type" name="role">
                    <option selected disabled>Seleccione</option>
                    @foreach ($roles as $role )
                        <option {{$user->role==$role->id?'selected ':''}} value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Tipo de documento</label>
                <select class="form-control form-control-solid" id="document_type" name="document_type">
                    <option selected disabled>Seleccione</option>
                    @foreach ($document_types as $type )
                        <option {{$user->document_type==$type->id?'selected ':''}} value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-3">
                <label>Número de identificación: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="N° de identificación" name="document_number" value="{{$user->document_number}}" />
                <span class="form-text text-muted"></span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="reset" class="btn btn-secondary"><a href="{{ route('users.index') }}" class="text-muted">Volver</a></button>
        </div>
    </form>
    <!--end::Form-->
</div>


@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
