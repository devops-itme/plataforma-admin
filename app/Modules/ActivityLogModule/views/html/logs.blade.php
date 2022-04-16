@extends('layouts.app')
@section('content')
    @include('layouts.breadCrumbs')

    <div class="card card-custom ">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h2 class="card-label h1">Registro de acciones de los usuarios</h2>
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
                    <form action="{{ route('log.index') }}">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Evento</label>
                                <input type="text" name="event" id="event" class="form-control"
                                    placeholder="Escriba el evento" aria-describedby="helpId"
                                    value="{{ request()->event }}">
                                <small id="helpId" class="text-muted">Nombre del evento</small>
                            </div>
                            <div class="col-12 col-md-3 form-group">
                                <label for="name">Causante</label>
                                <input type="text" name="causerName" id="causerName" class="form-control"
                                    placeholder="Escriba el nombre" aria-describedby="helpId"
                                    value="{{ request()->causerName }}">
                                <small id="helpId" class="text-muted">Nombre del causante</small>
                            </div>
                            <div class="col-12 col-md-3 form-group">
                                <label for="name"></label>
                                <input type="text" name="causerLastName" id="causerLastName" class="form-control"
                                    placeholder="Escriba el apellido" aria-describedby="helpId"
                                    value="{{ request()->causerLastName }}">
                                <small id="helpId" class="text-muted">Apellido del causante</small>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Acción</label>
                                <input type="text" name="action" id="action" class="form-control"
                                    placeholder="Escriba la acción" aria-describedby="helpId"
                                    value="{{ request()->action }}">
                                <small id="helpId" class="text-muted">filtro acción</small>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Role</label>
                                <select name="role" class="form-control" id="">
                                    <option value="">Todos</option>
                                    @foreach ($roles as $item)
                                        <option {{ request()->role == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <small id="helpId" class="text-muted">filtro role</small>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Fecha inicial</label>
                                <input type="date" name="initDate" class="form-control" value="{{ request()->initDate }}">
                                <small id="helpId" class="text-muted">filtro fecha inicial</small>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="name">Fecha final</label>
                                <input type="date" name="finDate" class="form-control" value="{{ request()->finDate }}">
                                <small id="helpId" class="text-muted">filtro fecha final</small>
                            </div>
                            <div class=" row form-group py-6 m-0 col-md-4">
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
                    </form>
                </div>
            </div>
            <!--end::Search Form-->
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col">Evento</th>
                        <th scope="col">Causante</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Acción</th>
                        <th scope="col">Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <td></td>
                            <td>{{ ucfirst($item->log_name) }}</td>
                            <td>{{ $item->causer ? $item->causer->fullName : 'Sistema' }}</td>
                            <td>{{ $item->causer ? $item->causer->role : 'Indefinido' }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at->format('d/m/Y h:i A') }}</td>
                        </tr>
                    @endforeach
                    {{-- @foreach ($logs as $item)
                        <tr>
                            <td>{{ $item->log_name ?? '' }}</td>
                            <td>{{ $item->getCauser->name ?? ('' . ' ' . $item->getCauser->last_name ?? '') }}</td>
                            <td>{{ $item->getCauser->getRole->name ?? '' }}</td>
                            <td>{{ $item->description ?? '' }}</td>
                            <td>{{ format_date(date($item->created_at)) . ' ' . date('h:i A', strtotime($item->created_at)) ?? '' }}
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
@endsection
