{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')

    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Tarifario
            </h3>
        </div>

        @include('layouts.alerts')

        <form action="{{ route('rates.store') }}" method="POST">
            @csrf
            <div class="card-body d-flex flex-row flex-wrap">

                <div class="form-group col-md-3">
                    <label>Tipo de paquete: <span class="text-danger">*</span></label>
                    <select class="form-control form-control-solid" id="" name="package_type" required>
                        <option selected disabled>Seleccione tipo de paquete</option>
                        @foreach ($package_types as $package_type)
                            <option {{ old('package_type') == $package_type->id ? 'selected ' : '' }}
                                value="{{ $package_type->id }}">{{ $package_type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Zona: <span class="text-danger">*</span></label>
                    <select class="form-control form-control-solid" name="zone_id" id="select-zone" required>
                        <option selected disabled value="">Seleccione zona</option>
                        @foreach ($zones as $zone)
                            <option {{ old('zone_id') == $zone->id ? 'selected ' : '' }} value="{{ $zone->id }}">
                                {{ $zone->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Barrio: <span class="text-danger">*</span></label>
                    <input type="hidden" name="old_neighborhood_id" id="old-neighborhood-id" value="{{old('neighborhood_id')}}">
                    <select class="form-control form-control-solid" name="neighborhood_id" id="select-neighborhood"
                        required>
                        <option selected disabled value="">Seleccione</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Tiempo estimado(en horas): <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-solid" placeholder="Estime el tiempo"
                        name="estimated_time" value="{{ old('estimated_time') }}" />
                </div>

                <div class="form-group col-md-3 py-3">
                    <label>Valor base(en dolares): <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-solid" placeholder="Cantidad de Libra adicional"
                        name="base_value" value="{{ old('base_value') }}" />
                </div>

                <div class="form-group col-md-3 py-3">
                    <label>Libra adicional por peso: <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-solid" placeholder="Cantidad de Libra adicional"
                        name="extra_for_weight" value="{{ old('extra_for_weight') }}" />
                </div>

                <div class="form-group col-md-3 py-3">
                    <label>Libra adicional por tamaño(Vol.) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-solid"
                        placeholder="Cantidad de Libra adicional x Tamaño" name="extra_per_size"
                        value="{{ old('extra_per_size') }}" />
                </div>

                <div class="form-group col-md-3 py-3">
                    <label>% Por entrega inmediata <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-solid" placeholder="Porcentaje x entrega"
                        name="percentage_immediate_delivery" value="{{ old('percentage_immediate_delivery') }}" />
                </div>

                <div class="form-group row col-md-3 ml-1">
                    <label class="checkbox">
                        <input type="checkbox" name="special_rate" {{ old('special_rate') === 'on' ? 'checked' : '' }} />
                        <span class="mr-2"></span>Tarifa especial
                    </label>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                <button type="reset" class="btn btn-secondary">Limpiar</button>
            </div>
        </form>
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
