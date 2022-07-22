{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h2 class="card-label h1">Tarifas</h2>
            </div>
            <div class="card-toolbar">
                <button class="btn btn-light-success mr-2 px-6 font-weight-bold btn-filter" data-toggle="collapse"
                    data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <span class="svg-icon svg-icon-md">
                        <i class="fas fa-arrow-down" aria-hidden="true"></i>
                    </span>Filtro
                </button>

                <a href="{{ route('rates.create') }}" class="btn btn-primary font-weight-bolder" data-tooltip
                    title="CREAR">
                    <span class="">
                        <i class="fas fa-plus"></i>
                    </span>Crear</a>
            </div>
        </div>
        <div class="card-body">
            <div id="collapseExample" class="col-md mx-auto mt-4 collapse mb-4" style="">
                <form action="{{ route('rates.index') }}">
                    <div class="row align-items-center">
                        <div class="form-group py-3 m-0 col-md-3">
                            <label for="exampleSelect1">Tipo de tarifa: </label>
                            <select class="form-control form-control-solid" id="package_type" name="package_type">
                                <option selected disabled> Seleccione </option>
                                @foreach ($package_types as $package_type)
                                    <option value="{{ $package_type->id }}"
                                        {{ request()->package_type != '' && request()->package_type == $package_type->id ? 'selected' : '' }}>
                                        {{ $package_type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Filtro Tipo de tarifa</span>
                        </div>
                        <div class="form-group py-3 m-0 col-md-3">
                            <label>Valor base :</label>
                            <input type="number" class="form-control form-control-solid" placeholder="" name="base_value"
                                value="{{ request()->base_value }}" />
                            <span class="form-text text-muted">Filtro Valor base</span>
                        </div>
                        <div class="form-group py-3 m-0 col-md-3">
                            <label for="exampleSelect1">Zona: </label>
                            <select class="form-control form-control-solid" id="select-zone" name="zone_id">
                                <option selected disabled> Seleccione </option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}"
                                        {{ request()->zone_id != '' && request()->zone_id == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Filtro Zona</span>
                        </div>
                        <div class="form-group py-3 m-0 col-md-3">
                            <label for="exampleSelect1">Barrio: </label>
                            <select class="form-control form-control-solid" id="select-neighborhood" name="neighborhood_id">
                                <option selected disabled> Seleccione </option>
                                @foreach ($neighborhoods as $neighborhood)
                                    <option value="{{ $neighborhood->id }}"
                                        {{ request()->neighborhood_id != '' && request()->neighborhood_id == $neighborhood->id ? 'selected' : '' }}>
                                        {{ $neighborhood->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted">Filtro Barrio</span>
                        </div>
                        <div class="form-group py-3 m-0 col-md-2">
                            <label for="exampleSelect1">Estado: </label>
                            <select class="form-control form-control-solid" id="zone" name="state">
                                <option selected disabled> Seleccione </option>
                                <option value="1" {{ request()->state == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0"
                                    {{ request()->state != '' && request()->state == 0 ? 'selected' : '' }}>Inactivo
                                </option>
                            </select>
                            <span class="form-text text-muted">Filtro estado</span>
                        </div>
                        <div class=" row form-group py-6 m-0 col-md-4">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-light-primary px-6 font-weight-bold btn-block">
                                    Filtrar</button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('rates.index') }}"
                                    class="btn btn-light-danger px-6 font-weight-bold btn-block">Limpiar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Tipo de tarifa</th>
                        <th scope="col">Valor base</th>
                        <th scope="col">Zona</th>
                        <th scope="col">Barrio</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($rates) == 0)
                        <tr>
                            <th colspan="9" class="text-center">
                                <h2 class="card-label mt-2"> No se encontraron resultados
                                </h2>
                            </th>
                        </tr>
                    @endif
                    @foreach ($rates as $rate)
                        <tr id="rate-id-{{ $rate->id }}">
                            <th>{{ $rate->id ?? '' }}</th>
                            <th>{{ $rate->getPackageType->name ?? '' }}</th>
                            <th>${{ $rate->base_value ?? '' }}</th>
                            <th>{{ $rate->getZone->name ?? '' }}</th>
                            <th>{{ $rate->getNeighborhood->name ?? '' }}</th>
                            <td>
                                @if ($rate->state == 1)
                                    <span class="label label-inline label-light-success font-weight-bold">
                                        Activo
                                    </span>
                                @else
                                    <span class="label label-inline label-light-danger font-weight-bold">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                                    <!-- <a href="{{ route('rates.show', $rate->id) }}"
                                        class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip title="Detalle">
                                        <i class="far fa-folder-open"></i>
                                    </a> -->
                                    <a href="{{ route('rates.edit', $rate->id) }}"
                                        class="btn btn-icon btn-light-success btn-sm mr-2" data-tooltip title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a onclick="deleteResource('/tarifas/'+{{ $rate->id }}+'?response_format=json',false,'rate-id-'+{{ $rate->id }})"
                                        role_id="button" class="btn btn-icon btn-light-danger btn-sm mr-2" data-tooltip
                                        title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-md-12 d-flex align-items-center justify-content-end">
                {{ $rates->links() }}
            </div>
        </div>
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
