{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    <div class="d-flex flex-row flex-wrap">
        <div class="col-md-8 scroll scroll-pull max-h-550px">
            <div class="card card-custom gutter-b">

                <div class="card-body">
                    <h3>Zonas</h3>
                    <div id="map" style="height: 420px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 scroll scroll-pull max-h-500px">
            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    <div class="card-title">
                        <h3 class="card-label" id="info-label">Adicionar</h3>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.alerts')
                    <form action="{{ route('zones.store') }}" id="zone-form" method="POST">
                        @csrf
                        <input type="hidden" name="coordinates" id="coordinates">
                        <div class="form-group py-3 m-0 col-md-12">
                            <label>Nombre: </label>
                            <input type="text" class="form-control" id="input-name" name="name"
                                placeholder="Nombre de zona" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <select class="form-control" id="select-country" name="country">
                                <option selected disabled>Seleccione pais</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <select class="form-control" id="select-province" name="province">
                                <option>Seleccione provincia</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <select class="form-control" id="select-district" name="district">
                                <option>Seleccione distrito</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <select class="form-control" id="select-corregimiento" name="corregimiento">
                                <option>Seleccione corregimiento</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <select multiple class="form-control" id="select-neighborhood" name="neighborhood[]">
                                <option>Seleccione barrio</option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-light-primary font-weight-bold mr-2">Guardar</button>
                        </div>
                    </form>
                    <div class="tab-pane fade" id="zone-edit" role="tabpanel" aria-labelledby="zone-edit">
                        ...
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            Lista de zonas
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button class="btn btn-light-success mr-2 px-6 font-weight-bold btn-filter">
                            <span class="svg-icon svg-icon-md">
                                <i class="fas fa-arrow-down" aria-hidden="true"></i>
                            </span>Filtro
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="mb-1">
                        <div class="form-filter" style="display:none">
                            <form action="{{ route('zones.index') }}">
                                <div class="row align-items-center">
                                    <div class="form-group py-3 m-0 col-md-4">
                                        <label>Nombre:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Nombre"
                                            name="name" value="{{ request()->name }}" />
                                        <span class="form-text text-muted">Filtro nombre</span>
                                    </div>

                                    <div class="form-group py-3 m-0 col-md-3">
                                        <label for="exampleSelect1">Pais: </label>
                                        <select class="form-control form-control-solid" id="country" name="country_id">
                                            <option selected disabled> Seleccione </option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ request()->country_id != '' && request()->country_id == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="form-text text-muted">Filtro pais</span>
                                    </div>
                                    <div class="form-group py-3 m-0 col-md-2">
                                        <label for="exampleSelect1">Estado: </label>
                                        <select class="form-control form-control-solid" id="zone" name="state">
                                            <option selected disabled> Seleccione </option>
                                            <option value="1" {{ request()->state == 1 ? 'selected' : '' }}>Activo
                                            </option>
                                            <option value="0"
                                                {{ request()->state != '' && request()->state == 0 ? 'selected' : '' }}>
                                                Inactivo
                                            </option>
                                        </select>
                                        <span class="form-text text-muted">Filtro estado</span>
                                    </div>
                                    <div class=" row form-group py-6 m-0 col-md-3">
                                        <div class="col-md-6">
                                            <button type="submit"
                                                class="btn btn-light-primary px-6 font-weight-bold btn-block">
                                                Filtrar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('zones.index') }}"
                                                class="btn btn-light-danger px-6 font-weight-bold btn-block">Limpiar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Nombre de la zona</th>
                                <th scope="col">Nombre del país</th>
                                <th scope="col">Estado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($zones as $zone)
                                <tr id="zone-id-{{ $zone->id }}">
                                    <th>{{ $zone->name }}</th>
                                    <td>{{ $zone->getNeighborhoods[0]->getCorregimiento->getDistrict->getProvince->getCountry->name?? ''}}</td>
                                    <td>{{ $zone->state == 1 ? 'Activo' : 'Inactivo' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">

                                            <button id="{{ $zone->id }}"
                                                class="edit-btn btn btn-icon btn-light-success btn-sm mr-2" data-tooltip
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a onclick="deleteResource('/zonas/'+{{ $zone->id }}+'?response_format=json',false,'zone-id-'+{{ $zone->id }})"
                                                class="btn btn-icon btn-light-danger btn-sm mr-2" data-tooltip
                                                title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-md-12 d-flex align-items-center justify-content-end">
                        {{ $zones->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
