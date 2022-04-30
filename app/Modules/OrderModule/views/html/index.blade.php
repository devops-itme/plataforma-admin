{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h2 class="card-label h1">Ordenes</h2>
            </div>
            @include('layouts.alerts')
            <div class="card-toolbar">
                <!--begin::Button filter-->

                <button class="btn btn-light-success mr-2 px-6 font-weight-bold btn-filter">
                    <span class="svg-icon svg-icon-md">
                        <i class="fas fa-arrow-down" aria-hidden="true"></i>
                    </span>Filtro
                </button>
              
                <a href="{{ route('orders.record') }}" class="btn btn-light-primary font-weight-bolder mr-2">
                    <i class="fas fa-history"></i>
                    Historial</a>

                <a href="{{ route('orders.create') }}" class="btn btn-primary font-weight-bolder" data-tooltip
                    title="CREAR">
                    <span class="svg-icon svg-icon-md">
                        <i class="fas fa-plus"></i>
                    </span>Crear</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="form-filter" style="display:none">
                    <form action="">
                        <div class="row align-items-center">
                            <div class="form-group py-3 m-0 col-md-4">
                                <label>Número de orden:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Orden_1"
                                    name="number" value="{{ request()->number }}" />
                                <span class="form-text text-muted">Filtro numero</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-4">
                                <label for="exampleSelect1">Tipo de orden:</label>
                                <select class="form-control form-control-solid" name="order_type">
                                    <option selected disabled> Seleccione </option>
                                    @foreach ($order_type as $key)
                                        <option value="{{ $key->id }}"
                                            {{ $key->id == request()->order_type ? 'selected' : '' }}>{{ $key->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="form-text text-muted">Filtro tipo de orden</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-4">
                                <label>Nombre del cliente:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Sabrina Jackson"
                                    name="name" value="{{ request()->name }}" />
                                <span class="form-text text-muted">Filtro nombre</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-4">
                                <label>Desde:</label>
                                <input type="date" class="form-control form-control-solid" placeholder="" name="from"
                                    value="{{ request()->from }}" />
                                <span class="form-text text-muted">Filtro desde</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-4">
                                <label>Hasta:</label>
                                <input type="date" class="form-control form-control-solid" placeholder="" name="to"
                                    value="{{ request()->to }}" />
                                <span class="form-text text-muted">Filtro hasta</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-4">
                                <label for="exampleSelect1">Estado: </label>
                                <select class="form-control form-control-solid" id="zone" name="state">
                                    <option selected disabled> Seleccione </option>
                                    @foreach ($status_matrix as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == request()->state ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="form-text text-muted">Filtro estado</span>
                            </div>
                            <div class=" row form-group py-6 m-0 col-md-12">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-light-primary px-6 font-weight-bold btn-block">
                                        Filtrar</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('orders.index') }}"
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
                        <th scope="col">Número de orden</th>
                        <th scope="col">Tipo de orden</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Fecha y Hora de creación</th>
                        <th scope="col">Estado de pago</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($orders) > 0)
                        @foreach ($orders as $order)
                            <tr>
                                <th scope="row">{{ $order->order_number??'No registra' }}</th>
                                <td>
                                    @if ($order->getOrderType->name == 'Ondemand')
                                        <span class="label label-inline label-light-warning font-weight-blog">
                                            Ondemand
                                        </span>
                                    @else
                                        <span class="label label-inline label-light-info font-weight-blog">
                                            Packaking
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $order->getUser ? $order->getUser->name." ".$order->getUser->last_name : 'No registra' }}
                                </td>
                                <td>{{ format_date(date('Y-n-d', strtotime($order->created_at)))}} <b>{{date('h:m A', strtotime($order->created_at))}}</b></td>
                                <td>
                                    {{$order->paid == 1 ? 'Pagado': 'Pendiente'}}
                                </td>
                                <td>
                                    {{$order->getStatusMatrix->name??'No registra'}}
                                </td>
                                <td>
                                    @if ($order->order_type == 35 && $order->status_matrix_id == 1 )
                                        <button type="button" id="porDespacharOndemand" value="{{$order->id}}" class="btn btn-icon btn-light-info btn-sm mr-2" data-tooltip title="Enviar a por despachar">
                                            <i class="fad fa-hand-holding-box"></i>
                                        </button>
                                    @endif
                                    @if ($order->order_type == 36 && $order->status_matrix_id == 1)
                                        <button type="button" id="porDespacharPackaging" value="{{$order->id}}" class="btn btn-icon btn-light-info btn-sm mr-2" data-tooltip title="Enviar a por despachar">
                                            <i class="fad fa-hand-holding-box"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                                        <a href="ordenes-listado"
                                            class="btn btn-icon btn-light btn-sm mr-2" data-tooltip title="Listado">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip title="Detalle">
                                            <i class="fad fa-folder-open"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order->id) }}"
                                            class="btn btn-icon btn-light-success btn-sm mr-2" data-tooltip title="Editar">
                                            <i class="fad fa-edit"></i>
                                        </a>
                                        <button type="button" onclick="confirmDelete('/ordenes/'+{{ $order->id }})"
                                            class="btn btn-icon btn-light-danger btn-sm mr-2" data-tooltip title="Eliminar">
                                            <i class="fad fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="8" class="text-center">¡No hay ordenes registradas!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <!--end: Datatable-->
            <div class="col-md-12 d-flex align-items-center justify-content-end">
                {{$orders->links()}}
            </div>
        </div>
    </div>


@endsection
{{-- Styles Section --}}
@section('styles')
@endsection
