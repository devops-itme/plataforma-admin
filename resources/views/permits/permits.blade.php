{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.alerts')
@include('permits.roleModals')
<div class="row">
  <div class="col-md-5">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h4 class="card-title">Roles</h4>
          </div>
          <hr>
          <div class="col text-right">
            <button type="button" class="btn btn-primary btn-sm text-uppercase" data-toggle="modal" data-target="#createRolModal"><i class="fa fa-plus"></i>Agregar rol</button>
            <button class="btn btn-primary btn-sm btn-filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table__contenedor">
          <thead class="thead-light">
            <tr>
              <th>Nombre</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($roles as $role)
              <tr id="{{$role->id}}" role-name="{{$role->name}}">
                <td class="text-uppercase">{{$role->name}}</td>
                <td>
                  <span class="badge badge-{{Config::get('const.states')[$role->state]['color']}} text-uppercase">{{Config::get('const.states')[$role->state]['name']}}</span>
                </td>
                <td class="text-center">
                  <button name="btnEditRole" id="btnRole-{{$role->id}}" class="btn btn-primary btn-sm btn-fab btn-icon" data-toggle="modal" data-target="#editRolModal" data-tooltip title="Editar">
                    <i class="fa fa-pencil"></i>
                  </button>
                  <button class="btn btn-danger btn-sm btn-fab btn-icon" data-tooltip title="Eliminar" onclick="confirmDelete('/roles/'+{{$role->id}})">
                    <i class="fa fa-trash"></i>
                  </button>
                  <button class="btn btn-info btn-sm btn-fab btn-icon configuration-btn" data-tooltip title="Configurar">
                    <i class="fa fa-cog"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="card formclass">
      <form id="permits-form" method="POST">
        @csrf @method('PUT')

        <div class="card-header">
          <div class="row">
            <div class="col">
              <h4 id="permits-label" class="card-title">Permisos</h4>
            </div>
            <div class="col text-right">
              <button type="submit" class="btn btn-primary btn-sm d-none" id="submit-btn"><i class="fas fa-save"></i> Guardar
                permisos</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-12">
                <div class="card my-2">
                    <div class="card-body" id="card-body">
                    </div>
                </div>
            </div>
          </div>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection
