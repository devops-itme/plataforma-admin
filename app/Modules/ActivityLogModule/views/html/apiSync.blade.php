@extends('layouts.app')
@section('content')
    @include('layouts.breadCrumbs')

    <div class="card card-custom ">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h2 class="card-label h1">Registro de actividad Sincronizador</h2>
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

            </div>
        </div>
        <div class="card-body">
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="form-filter" style="display:none">
                    {{-- <form action="{{ route('log.index') }}">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Evento:</label>
                                <input type="text" name="event" id="event" class="form-control form-control-solid"
                                    placeholder="Escriba el evento" aria-describedby="helpId"
                                    value="{{ request()->event }}">
                                <small id="helpId" class="text-muted">Nombre del evento</small>
                            </div>
                            <div class="col-12 col-md-3 form-group">
                                <label for="name">Causante:</label>
                                <input type="text" name="causerName" id="causerName" class="form-control form-control-solid"
                                    placeholder="Escriba el nombre" aria-describedby="helpId"
                                    value="{{ request()->causerName }}">
                                <small id="helpId" class="text-muted">Nombre del causante</small>
                            </div>
                            <div class="col-12 col-md-3 form-group">
                                <label for="name"></label>
                                <input type="text" name="causerLastName" id="causerLastName" class="form-control form-control-solid"
                                    placeholder="Escriba el apellido" aria-describedby="helpId"
                                    value="{{ request()->causerLastName }}">
                                <small id="helpId" class="text-muted">Apellido del causante</small>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Acción:</label>
                                <input type="text" name="action" id="action" class="form-control form-control-solid"
                                    placeholder="Escriba la acción" aria-describedby="helpId"
                                    value="{{ request()->action }}">
                                <small id="helpId" class="text-muted">filtro acción</small>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Roles:</label>
                                    <select name="role" class="form-control form-control-solid" id="">
                                    <option value="">Todos</option>
                                    @foreach ($roles as $item)
                                        <option {{ request()->role == $item->name ? 'selected' : '' }} value="{{ $item->name }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <small id="helpId" class="text-muted">filtro roles</small>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Fecha inicial:</label>
                                <input type="date" name="initDate" class="form-control form-control-solid" value="{{ request()->initDate }}">
                                <small id="helpId" class="text-muted">filtro fecha inicial</small>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Fecha final:</label>
                                <input type="date" name="finDate" class="form-control form-control-solid" value="{{ request()->finDate }}">
                                <small id="helpId" class="text-muted">filtro fecha final</small>
                            </div>
                            <div class=" row form-group py-6 m-0 col-md-12">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-light-primary px-6 font-weight-bold btn-block">
                                    Filtrar</button>
                            </div>
                                <div class="col-md-6">
                                    <a href="{{ route('log.index') }}"
                                        class="btn btn-light-danger px-6 font-weight-bold btn-block">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </form> --}}
                </div>
            </div>
            <!--end::Search Form-->
            <table class="table table-sm">
                <thead>
                    <tr {{-- style="text-align: center" --}}>
                        <th></th>
                        <th scope="col">Origen</th>
                        <th scope="col">Detalle de origen</th>
                        <th scope="col">Destino</th>
                        <th scope="col">Detalle de destino</th>
                        <th scope="col">Respuesta obtenida</th>
                        <th scope="col">Hora y fecha</th>
                        <th scope="col">Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($logs) == 0)
                        <td>No se hallaron registros</td>
                        
                    @endif
                    @foreach ($logs as $log)
                        <tr {{-- style="text-align: center" --}}>
                            <td></td>
                            <td>{{ str_replace("_", " ", $log['origin']) }}</td>
                            @foreach ($log['origin_detail'] as $key => $originDetail)
                            
                                @if ($key == 'origin_user')
                                    @if (is_string($originDetail) != true)
                                        <td>--- ---</td>
                                    @else
                                    <td> <b>Usuario: </b> {{ $originDetail ?? 'No se registra usuario'}}</td>
                                    @endif
                                @endif
                            @endforeach
                            <td>{{ str_replace("_", " ", $log['destination']) }}</td>
                            <td>
                                   @foreach ($log['destination_detail'] as $key => $destDetail)
                                   @if ($key == 'destination_action')
                                      <b>Acción: </b> {{ str_replace("_", " ", __($destDetail)) }} <br>
                                   @endif
                                    @if ($key == 'destination_table')
                                        <b>Tabla: </b>  "{{ $destDetail }}" <br>
                                    @endif
                                    {{-- @if ($key == 'destination_url')
                                        Url: {{ $destDetail }} <br>
                                    @endif --}}
                                   @endforeach
                            </td>
                            <td>
                                @foreach ($log['response'] as $key => $response)
                                    @if ($response == null)
                                        No registrada
                                    @endif
                                    @if ($key == 'response')
                                        {{ __($response) }} <br>
                                    @endif
                                    @if ($key == 'response_error')
                                        Error: {{ __($response) }} <br>
                                    @endif
                                    {{-- @if ($key == 'guide_id')
                                        Id de guía: {{ $response }} <br>
                                    @endif --}}
                                    @if ($key == 'guide_number')
                                        No. Guía: {{ $response }} <br>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                {{ date("h:m:s d-m-Y", strtotime($log['created_at'])) }} <br>
                            </td>
                            <td>
                                @if ($log['transaction_state'] == 'ACK')
                                    Recibido
                                @endif

                                @if ($log['transaction_state'] == 'ACK_pending')
                                    Pendiente
                                @endif

                                @if ($log['transaction_state'] == 'LOST')
                                    Perdido
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-left: 30px;">
            {{$logs->appends(request()->input())->links()}}
        </div>
    </div>
@endsection