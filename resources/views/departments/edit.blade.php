{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Editar departamento
            </h3>
        </div>
        @include('layouts.alerts')
        <!--begin::Form-->
        <form action="{{ route('departments.update', ['departamento'=>$department->id, 'user_id' => $user_id]) }}" method="POST" id="formUpdateMessenger"
            enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card-body d-flex flex-row flex-wrap">
                <div class="card-body d-flex flex-row flex-wrap">
                    @if (!is_null($branch_offices))
                        <div class="form-group col-md-12">
                            <label>Sucursales</label>
                            <select class="form-control form-control-solid" id="branch_office_id" name="branch_office_id">
                                <option selected disabled>Seleccione</option>
                                @foreach ($branch_offices as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $department->branch_office_id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted"></span>
                        </div>
                    @else
                        <input type="number" hidden name="branch_office_id" value="{{ $branch_office_id }}">
                    @endif
                    <div class="form-group col-md-6">
                        <label>Nombres: <span class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control form-control-solid" placeholder="Nombre"
                            value="{{ $department->name }}" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Estado</label>
                        <select class="form-control form-control-solid" id="document_type" name="state">
                            <option selected disabled>Seleccione</option>
                            <option value="1" {{ $department->state == 1 ? 'selected' : '' }}> Activo</option>
                            <option value="0" {{ $department->state == 0 ? 'selected' : '' }}> Inactivo</option>
                        </select>
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Descripción</label>
                        <textarea name="description" class="form-control form-control-solid" cols="30"
                            rows="10">{{ $department->description }}</textarea>
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
