{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h2 class="card-label h1">Usuariooooo</h2>
            </div>
            @include('layouts.alerts')
            <div class="card-toolbar">
                <!--begin::Button filter-->
                <button class="btn btn-light-success mr-2 px-6 font-weight-bold btn-filter">
                    <span class="svg-icon svg-icon-md">
                        <i class="fas fa-arrow-down" aria-hidden="true"></i>
                    </span>Filtro
                </button>
                <!--end::Button-->

                <!--begin::Button-->
                <a href="{{ route('users.create') }}" class="btn btn-primary font-weight-bolder" data-tooltip
                    title="CREAR">
                    <span class="svg-icon svg-icon-md">
                        <i class="fas fa-plus"></i>
                    </span>Crear</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="form-filter" style="display:none">
                    <form action="{{ route('users.index') }}">
                        <div class="row align-items-center">
                            <div class="form-group py-3 m-0 col-md-4">
                                <label>Nombre:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Nombre" name="name"
                                    value="{{ request()->name }}" />
                                <span class="form-text text-muted">Filtro nombre</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-4">
                                <label>Número de documento:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Número de documento"
                                    name="document" value="{{ request()->document }}" />
                                <span class="form-text text-muted">Filtro documento</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-4">
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
                                <label for="exampleSelect1">Rol: </label>
                                <select class="form-control form-control-solid" id="zone" name="role_id">
                                    <option selected disabled> Seleccione </option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ request()->role_id != '' && request()->role_id == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="form-text text-muted">Filtro de rol</span>
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
                                    <a href="{{ route('users.index') }}"
                                        class="btn btn-light-danger px-6 font-weight-bold btn-block">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Search Form-->
            
            <!--begin: Datatable-->
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Nombres</th>
                        <th scope="col">Número de documento</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr id="user-id-{{ $user->id }}">
                            <th scope="row">{{ $user->name }}</th>
                            <td>{{ $user->document_number }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->getRole->name ?? '---' }}</td>
                            <td>
                                @if ($user->state == 1)
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

                                    <a href="{{ route('users.show', $user->id) }}"
                                        class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip title="Detalle">
                                        <i class="far fa-folder-open"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="btn btn-icon btn-light-success btn-sm mr-2" data-tooltip title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if ($user->id != 1)
                                        <a onclick="deleteResource('/usuarios/'+{{ $user->id }}+'?response_format=json',false,'user-id-'+{{ $user->id }})"
                                            role_id="button" id="deleteMessenger"
                                            class="btn btn-icon btn-light-danger btn-sm mr-2" data-tooltip title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
