@extends('layouts.app')
@section('content')
    @include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Detalle de la orden
            </h3>
        </div>
        @include('layouts.alerts')

        <div class="card-body d-flex flex-row flex-wrap pt-2">
            <div class="form-group col-md-3">
                <label>Numero de orden:</label>
                <p class="form-control form-control-solid">{{ $order->order_number }}</p>
                <span class="form-text text-muted"></span>
            </div>

            @if (Auth::user()->getRole->name == 'Admin')
                <div class="form-group col-md-3">
                    <label for="customer">Cliente</label>
                    <p class="form-control form-control-solid">{{ $order->getUser->name . ' ' . $order->getUser->last_name }}
                    </p>
                </div>
            @else
                <input type="hidden" name="user_id" id="customer_id" value="{{ Auth::user()->id }}">
            @endif

            <div class="form-group col-md-3">
                <label for="order_type">Tipo de orden</label>
                <p class="form-control form-control-solid">{{ $order->getOrderType->name }}</p>
            </div>

            <div class="form-group col-md-3">
                <label for="address">Dirección origen</label>
                <textarea class="form-control" name="address" disabled>{{$order->getAddress->name ?? $order->address_name }}</textarea>
            </div>

            <div class="form-group col-md-3">
                <label for="user_departments">Departamento</label>
                <p class="form-control form-control-solid">{{ $order->getDepartment->name ?? 'No registra' }}</p>
            </div>

            <div class="form-group col-md-3">
                <label for="user_branch_office">Sucursal</label>
                <p class="form-control form-control-solid">{{ $order->getBranchOffice->name ?? 'No registra' }}</p>
            </div>

            @if (Auth::user()->getRole->name == 'Admin')
                <div class="form-group col-md-3">
                    <label for="vehicle_type_id">Tipo de transporte</label>
                    <p class="form-control form-control-solid">
                        {{ $order->getGuides[0]->getTransportType->name ?? 'No registra' }}</p>
                </div>
            @endif

            <div class="form-group col-md-3">
                <label>Fecha de programación:</label>
                <input name="schedule_date" id="schedule_date" type="date" class="form-control form-control-solid"
                    placeholder="" value="{{ $order->schedule_date }}" disabled/>
            </div>

            <div class="form-group col-md-3">
                <label>Hora de programación:</label>
                <p class="form-control form-control-solid">{{ $order->schedule_time_range ?? 'No registra' }}</p>
            </div>

            <div class="form-group col-md-6">
                <label for="description">Descripción</label>
                <textarea disabled name="order_description" cols="10" rows="2" class="form-control form-control-solid" disabled>{{ $order->description }}</textarea>
            </div>

            <div class="form-group col-md-12 m-0 d-flex align-items-center">
                <div class="checkbox-inline">
                    <label class="checkbox">
                        <input disabled type="checkbox" name="urgent_dispatch"
                            {{ $order->urgent_dispatch == 1 ? 'checked' : '' }} />
                        <span></span>
                        Marcar Urgente Despacho
                    </label>
                    <label class="checkbox">
                        <input disabled type="checkbox" name="return_last_destination" id="return_last_destination"
                            {{ $order->return_last_destination == 1 ? 'checked' : '' }} />
                        <span></span>
                        Retorno Ultimo Destino
                    </label>
                </div>
            </div>
        </div>
        <input type="hidden" name="guides" id="guides">
        @include('OrderModule.views.html.show.guideList')

    </div>
@endsection
