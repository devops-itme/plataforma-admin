{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')

    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Ordenes
                </h3>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm text-center" id="tabListOrders">
                <thead class="">
                    <tr>
                        <th scope="col">NO. GUIA</th>
                        <th scope="col">REFERENCIA</th>
                        <th scope="col">CLIENTE</th>
                        <th scope="col">TIPO</th>
                        <th scope="col">FECHA - HORA</th>
                        <th scope="col">CONTACTO</th>
                        <th scope="col">SUCURSAL</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <th>1000</th>
                        <td>---</td>
                        <td></td>
                        <td>Nacional</td>
                        <td>07-4-2022 - 4:12 PM</td>
                        <td>Alejandra Gomez</td>
                        <td>---</td>
                        <td> <span class="label label-inline label-light-success font-weight-bold">
                                Activo
                            </span></td>
                        <td>
                            <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                                <a href="#" class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip title="Detalle">
                                    <i class="far fa-folder-open"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-light-success btn-sm mr-2" data-tooltip title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-light-danger btn-sm mr-2" data-tooltip title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>2001</th>
                        <td>---</td>
                        <td></td>
                        <td>Internacional</td>
                        <td>07-4-2022 - 4:12 PM</td>
                        <td>Maria Jose</td>
                        <td>---</td>
                        <td> <span class="label label-inline label-light-success font-weight-bold">
                                Activo
                            </span></td>
                        <td>
                            <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                                <a href="#" class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip title="Detalle">
                                    <i class="far fa-folder-open"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-light-success btn-sm mr-2" data-tooltip title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-light-danger btn-sm mr-2" data-tooltip title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>9610</th>
                        <td>---</td>
                        <td></td>
                        <td>Internacional</td>
                        <td>07-4-2022 - 4:12 PM</td>
                        <td>Nancy Auxiliadora</td>
                        <td>---</td>
                        <td> <span class="label label-inline label-light-success font-weight-bold">
                                Activo
                            </span></td>
                        <td>
                            <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                                <a href="#" class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip title="Detalle">
                                    <i class="far fa-folder-open"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-light-success btn-sm mr-2" data-tooltip title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-light-danger btn-sm mr-2" data-tooltip title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

@endsection
{{-- Styles Section --}}
@section('styles')
@endsection
