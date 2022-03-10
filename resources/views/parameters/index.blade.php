@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')
    <div class="content" id="app">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title">Parametros</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('parameters.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Nombre<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-solid">
                                <small id="helpId" class="text-muted">Ejemplo: Tipo de documento, tipo de
                                    pago</small>
                            </div>
                            <div class="form-group">
                                <label for="">Descripcion<span class="text-danger">*</span></label>
                                <textarea required ref="description" cols="30" rows="5"
                                    type="text" name="description" id="" class="form-control form-control-solid"
                                    placeholder="Ingrese Descripcion"></textarea>
                                <small id="helpId" class="text-muted">Ejemplo: Parametro para ....</small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block"> Crear </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @include('layouts.alerts')
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Descripcion
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                    <th>
                                        Opciones
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($parameters as $parameter)
                                    <tr>
                                        <td>{{__($parameter->name)}}</td>
                                        <td>{{$parameter->description??'Sin descripción' }}</td>
                                        <td>
                                            <span class="label label-inline label-light-{{$parameter->state == 1 ? 'success':'danger'}} font-weight-bold">
                                                {{$parameter->state == 1 ? 'Activo':'Inactivo'}}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-rd">
                                                <i class="fad fa-eye" style="padding:0px;"></i>
                                            </button>
                                            <button type="button" class="btn btn-success btn-rd">
                                                <i class="fad fa-edit" style="padding:0px;"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-rd">
                                                <i class="fad fa-trash-alt" style="padding:0px;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
