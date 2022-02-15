{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')

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
            <button type="button" class="btn btn-primary btn-sm text-uppercase" data-toggle="modal" data-target="#idAddRole"><i class="fa fa-plus"></i>Agregar rol</button>
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
              <tr>
                <td class="text-uppercase">{{$role->name}}</td>
                <td>
                  <span class="badge badge-{{Config::get('const.states')[$role->state]['color']}} text-uppercase">{{Config::get('const.states')[$role->state]['name']}}</span>
                </td>
                <td class="text-center">
                  <button class="btn btn-primary btn-sm btn-fab btn-icon">
                    <i class="fa fa-pencil"></i>
                  </button>
                  <button class="btn btn-danger btn-sm btn-fab btn-icon">
                    <i class="fa fa-trash"></i>
                  </button>
                  <button class="btn btn-info btn-sm btn-fab btn-icon">
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
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h4 class="card-title">Permisos</h4>
          </div>
          <div class="col text-right">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar
              permisos</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-12">
            <div class="card my-2">
              <div class="card-body">
                <div class="row">
                  <div class="col-3 align-self-center">
                    <h6 class="mb-0 text-muted font-weight-bold">Dashboard</h6>
                  </div>
                  <div class="col-9 align-self-center">
                    <div class="form-check">
                      <label class="form-check-label text-uppercase font-weight-bold">
                        <input class="form-check-input" type="checkbox">
                        ver
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





@endsection