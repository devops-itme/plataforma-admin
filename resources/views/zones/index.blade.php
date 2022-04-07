{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    <div class="d-flex flex-row flex-wrap">
        <div class="col-md-8">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            Zonas
                        </h3>
                    </div>
                    <div class="card-toolbar col-8 justify-content-around">
                        <div class="form-group mb-0">
                            <select class="form-control">
                                <option>Seleccione</option>

                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <select class="form-control">
                                <option>Seleccione</option>

                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <select class="form-control">
                                <option>Seleccione</option>

                            </select>
                        </div>
                        <a href="#" class="btn btn-light-primary font-weight-bold"><i class="fad fa-filter"></i>
                            Filtrar</a>
                    </div>
                </div>
                <div class="card-body">
                    <h3>My Google Maps Demo</h3>
                    <div id="map" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">


            <div class="card card-custom">
                <div class="card-header card-header-tabs-line">
                    <div class="card-title">
                        <h3 class="card-label">Acciones</h3>
                    </div>
                    <div class="card-toolbar">
                        <ul class="nav nav-bold nav-tabs-line nav-tabs ">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#zone-list">Lista de zonas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#addition">Adiccionar</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @include('layouts.alerts')
                        <div class="tab-pane fade show active" id="zone-list" role="tabpanel" aria-labelledby="zone-list">
                            <h6 class="my-2 font-weight-bold text-dark">Lista de zonas</h6>
                            <div class="list-group">
                                @foreach ($zones as $zone)
                                    <a href="#" class="list-group-item list-group-item-action">{{ $zone->name ?? '' }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="addition" role="tabpanel" aria-labelledby="addition">
                            <form action="{{ route('zones.store') }}" method="POST">
                                @csrf
                                <div class="form-group py-3 m-0 col-md-12">
                                    <label>Nombre: </label>
                                    <input type="text" class="form-control" name="name" placeholder="Nombre de zona" />
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
                                {{-- <div class="form-group py-3 m-0 col-md-12">
                                    <label class="font-weight-bolder">Puntos: </label>
                                    <span>Malambo, Soledad city...</span>
                                    <span class="form-text text-muted"></span>
                                </div> --}}
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="submit"
                                        class="btn btn-light-primary font-weight-bold mr-2">Guardar</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="zone-edit" role="tabpanel" aria-labelledby="zone-edit">
                            ...
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
