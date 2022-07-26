{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h2 class="card-label h1">Mensajeros
                    {{-- <div class="text-muted pt-2 font-size-sm">Datatable initialized from HTML table</div> --}}
                </h2>
            </div>
            @include('layouts.alerts')
            <div class="card-toolbar">
                <!--begin::Button filter-->
                <button class="btn btn-light-success mr-2 px-6 font-weight-bold btn-filter">
                    <span class="svg-icon svg-icon-md">
                        <i class="fas fa-arrow-down" aria-hidden="true"></i>
                    </span>Filtro
                </button>
                <!--end::Button filter-->

                <!--begin::Button-->
                <a href="{{ route('messengers.create') }}" class="btn btn-primary font-weight-bolder" data-tooltip
                    title="CREAR">
                    <span class="svg-icon svg-icon-md">
                        <i class="fas fa-plus"></i>
                    </span>Crear</a>
                <!--end::Button-->
                {{-- <form action="{{route('messengers.import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" id="file">
                    <button  class="btn btn-primary font-weight-bolder ml-2" type="submit">Importar</button>
                </form> --}}
            </div>
        </div>
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="form-filter" style="display:none">
                    <form action="{{ route('messengers.index') }}">
                        <div class="row align-items-center">
                            <div class="form-group py-3 m-0 col-md-3">
                                <label>Nombre:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Nombre" name="name"
                                    value="{{ request()->name }}" />
                                <span class="form-text text-muted">Filtro nombre</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-3">
                                <label>Número de documento:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Número de documento"
                                    name="document" value="{{ request()->document }}" />
                                <span class="form-text text-muted">Filtro documento</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-3">
                                <label>Correo:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="email@example.com"
                                    name="email" value="{{ request()->email }}" />
                                <span class="form-text text-muted">Filtro correo</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-3">
                                <label>Teléfono :</label>
                                <input type="text" class="form-control form-control-solid" placeholder="+1 (616) 337-9576"
                                    name="phone" value="{{ request()->phone }}" />
                                <span class="form-text text-muted">Filtro teléfono</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-3">
                                <label>Place:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Placa de vehículo"
                                    name="vehicle_plate" value="{{ request()->vehicle_plate }}" />
                                <span class="form-text text-muted">Filtro placa</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-3">
                                <label for="exampleSelect1">Estado: </label>
                                <select class="form-control form-control-solid" id="zone" name="state">
                                    <option selected disabled> Seleccione </option>
                                    <option value="1" {{ request()->state == 1 ? 'selected' : '' }}>Activo</option>
                                    <option value="0"
                                        {{ request()->state != '' && request()->state == 0 ? 'selected' : '' }}>
                                        Inactivo
                                    </option>
                                </select>
                                <span class="form-text text-muted">Filtro estado</span>
                            </div>
                            <div class=" row form-group py-6 m-0 col-md-6">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-light-primary px-6 font-weight-bold btn-block">
                                        Filtrar</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('messengers.index') }}"
                                        class="btn btn-light-danger px-6 font-weight-bold btn-block">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->


            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Nombres</th>
                        <th scope="col">Número de documento</th>
                        <th scope="col">Placa</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($messengers) > 0)
                        @foreach ($messengers as $item)
                            <tr>
                                <th scope="row">{{ $item->user->name . ' ' . $item->user->last_name }}</th>
                                <td>{{ $item->user->document_number }}</td>
                                <td>{{ $item->vehicle_plate }}</td>
                                <td>{{ $item->user->email }}</td>
                                <td>{{ $item->user->phone }}</td>
                                <td>
                                    @if ($item->user->state == 1)
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
                                        <a href="{{ route('messengers.show', $item->id) }}"
                                            class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip
                                            title="Detalle"><i class="fad fa-folder-open"></i>
                                        </a>
                                        <a href="{{ route('messengers.edit', $item->id) }}"
                                            class="btn btn-icon btn-light-success btn-sm mr-2" data-tooltip title="Editar">
                                            <i class="fad fa-edit"></i>
                                        </a>
                                        <button type="button" onclick="deleteResource('{{route('messengers.destroy', $item->id)}}', true)"
                                            role="button" id="deleteMessenger" class="btn btn-icon btn-light-danger btn-sm mr-2"
                                            data-tooltip title="Eliminar">
                                            <i class="fad fa-trash-alt"></i>
                                            {{-- <form action="{{route('customers.destroy', $customer->id)}}" method="{{'post'}}">
                                                        @csrf @method('DELETE') --}}
                                            {{-- </form> --}}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <th colspan="8" class="text-center">¡No se encontraron resultados!</td>
                    @endif
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
        <div class="">
            {{ $messengers->links() }}
        </div>
    </div>

@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
