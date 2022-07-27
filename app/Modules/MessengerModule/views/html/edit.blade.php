{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Editar mensajero
            </h3>
        </div>
        @include('layouts.alerts')
        <!--begin::Form-->
        <form action="{{route('messengers.update', $messenger->id)}}" method="POST" id="formUpdateMessenger"  enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card-body d-flex flex-row flex-wrap">
                <div class="form-group col-md-4">
                    <label>Nombres: <span class="text-danger">*</span></label>
                    <input name="name" type="text" class="form-control form-control-solid" placeholder="Nombres"
                        value="{{ $messenger->user->name }}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Apellidos <span class="text-danger">*</span></label>
                    <input name="last_name" type="text" class="form-control form-control-solid" placeholder="Apellidos"
                        value="{{ $messenger->user->last_name }}" />
                </div>
                <div class="form-group col-md-4">
                    <label>Email: <span class="text-danger">*</span></label>
                    <input name="email" type="email" class="form-control form-control-solid" placeholder="Email"
                        value="{{ $messenger->user->email }}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Teléfono: <span class="text-danger">*</span></label>
                    <input name="phone" type="tel" class="form-control form-control-solid" placeholder="Teléfono"
                        value="{{ $messenger->user->phone }}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="type_doc">Tipo de documento <span class="text-danger">*</span></label>
                    <select class="form-control form-control-solid" id="document_type" name="document_type">
                        <option selected disabled>Seleccione</option>
                        @foreach ($document_type as $document)
                            <option value="{{ $document->id }}"
                                {{ $document->id == $messenger->user->document_type ? 'selected' : '' }}>
                                {{ $document->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Número de identificación: <span class="text-danger">*</span></label>
                    <input name="document_number" type="text" class="form-control form-control-solid"
                        placeholder="N° de identificación" value="{{ $messenger->user->document_number }}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Placa de vehículo: <span class="text-danger">*</span></label>
                    <input name="vehicle_plate" type="text" class="form-control form-control-solid" placeholder=""
                        value="{{ $messenger->vehicle_plate }}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Fecha de ingreso: <span class="text-danger">*</span></label>
                    <input name="admission_date" type="date" class="form-control form-control-solid" placeholder=""
                        value="{{ $messenger->admission_date }}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Fecha de nacimiento: <span class="text-danger"></span></label>
                    <input name="birth_date" type="date" class="form-control form-control-solid" placeholder=""
                        value="{{ $messenger->birth_date }}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Porcentaje de producción: <span class="text-danger">*</span></label>
                    <input name="production_percentage" type="text" class="form-control form-control-solid" placeholder=""
                        value="{{ $messenger->production_percentage }}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Exclusivo</label>
                    <div class="radio-inline">
                        <label class="radio radio-rounded">
                            <input type="radio" name="exclusive" value="1"
                                {{ $messenger->exclusive == 1 ? 'checked ' : '' }} />
                            <span></span>
                            SI
                        </label>
                        <label class="radio radio-rounded">
                            <input type="radio" name="exclusive" value="0"
                                {{ $messenger->exclusive == 0 ? 'checked ' : '' }} />
                            <span></span>
                            NO
                        </label>
                    </div>
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="type_doc">Tipo de contrato <span class="text-danger">*</span></label>
                    <select name="contract_type_id" class="form-control form-control-solid" id="type_contract">
                        <option selected disabled>Seleccione tipo de contrato</option>
                        @foreach($contract_type as $contract)
                            <option {{$contract->id == $messenger->contract_type_id ? 'selected ':''}}  value="{{$contract->id}}">{{$contract->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group py-3 m-0 col-md-4">
                    <label>Contrato <span class="text-danger"></span></label>
                    <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="file"
                        name="contract" value="{{ $messenger->contract }}" />
                </div>
                <div class="form-group py-3 m-0 col-md-4">
                    <label>Contraseña <span class="text-danger">*</span></label>
                    <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="password"
                        name="password" />
                </div>
                <div class="form-group py-3 m-0 col-md-4">
                    <label>Repetir Contraseña <span class="text-danger">*</span></label>
                    <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="password"
                        name="password_confirmation" />
                </div>
                <div class="form-group py-3 m-0 col-md-4">
                <label>Movil <span class="text-danger">*</span></label>
                <input name="number" type="text" class="form-control form-control-solid" placeholder="" value="{{ $messenger->number }}" />
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
