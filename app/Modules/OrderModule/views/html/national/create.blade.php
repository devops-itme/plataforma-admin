{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Crear orden
            </h3>
        </div>
        @include('layouts.alerts')

        <form id="order-form" action="{{ route('orders.store') }}" method="post">
            @csrf

            <div class="card-body d-flex flex-row flex-wrap pt-2">
                @if (Auth::user()->getRole->name == 'Admin')
                    <div class="form-group col-md-3">
                        <label for="customer">Cliente <span class="text-danger">*</span></label>
                        <select name="user_id" class="select2-customers form-control form-control-solid" id="customer">
                            <option id="user_id" value="" selected disabled>Seleccione un cliente</option>
                            @foreach ($customers as $customer)
                                <option {{ old('customer') == $customer->getUser->id ? 'selected ' : '' }}
                                    value="{{ $customer->getUser->id }}">
                                    {{ $customer->getUser->name . ' ' . $customer->getUser->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="user_id" id="customer_id" value="{{ Auth::user()->id }}">
                @endif

                <div class="form-group col-md-3">
                    <label for="order_type">Tipo de orden <span class="text-danger">*</span></label>
                    <select name="order_type" class="form-control form-control-solid" id="order_type">
                        <option selected disabled>Seleccione tipo de orden</option>
                        @foreach ($order_type as $order)
                            <option {{ old('order_type') == $order->id ? 'selected ' : '' }} value="{{ $order->id }}">
                                {{ $order->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="address">Dirección origen <span class="text-danger">*</span></label>
                    <select name="address_id" class="form-control form-control-solid" id="address">
                        <option value="" disabled selected>Seleccione</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="user_departments">Departamento</label>
                    <select name="department_id" id="user_departments" class="form-control form-control-solid">
                        <option value="" selected disabled> Seleccione </option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="user_branch_office">Sucursal</label>
                    <select name="branch_office_id" id="user_branch_office" class="form-control form-control-solid">
                        <option value="" selected disabled> Seleccione </option>
                    </select>
                </div>

                @if (Auth::user()->getRole->name == 'Admin')
                    <div class="form-group col-md-3">
                        <label for="vehicle_type_id">Tipo de transporte <span class="text-danger">*</span></label>
                        <select name="vehicle_type_id" class="form-control form-control-solid" id="vehicle_type_id">
                            <option value="" selected disabled>Seleccione tipo de transporte</option>
                            @foreach ($transport_type as $item)
                                <option value="{{ $item->id }}"
                                    {{ $order->vehicle_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="form-group col-md-3">
                    <label>Fecha de programación: <span class="text-danger">*</span></label>
                    <input name="schedule_date" id="schedule_date" type="date" class="form-control form-control-solid"
                        placeholder="" />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Hora de programación: <span class="text-danger">*</span></label>
                    <select name="schedule_time_range" class="form-control form-control-solid" id="schedule_time_range">
                        <option value="" disabled selected>Seleccione </option>
                    </select>
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-6">
                    <label for="description">Descripción <span class="text-danger">*</span></label>
                    <textarea name="order_description" cols="10" rows="2"
                        class="form-control form-control-solid">{{ $order->description }}</textarea>
                </div>

                <div class="form-group col-md-12 m-0 d-flex align-items-center">
                    <div class="checkbox-inline">
                        <label class="checkbox">
                            <input type="checkbox" name="urgent_dispatch" />
                            <span></span>
                            Marcar Urgente Despacho
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="return_last_destination" />
                            <span></span>
                            Retorno Ultimo Destino
                        </label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="guides" id="guides">
        </form>

        <form id="guide_form" class="guide_form">
            <div class="card-header row flex-wrap border-0 pt-6 pb-0">
                <h3 class="card-title col-10">
                    Datos de destino
                </h3>

                <div class="card-toolbar col-2">
                    <button class="btn btn-primary font-weight-bolder" id="add-guide-btn" type="button" data-tooltip
                        title="CREAR">
                        <span class="svg-icon svg-icon-md">
                            <i class="fas fa-plus"></i>
                        </span>Añadir destino
                    </button>
                </div>
            </div>
            <div class="card-body d-flex flex-row flex-wrap pt-2">
                <div class="form-group col-md-2">
                    <label for="guide_address">Dirección destino <span class="text-danger">*</span></label>
                    <select name="guide_address" class="form-control form-control-solid" id="guide_address">
                        <option disabled selected>Seleccione </option>
                    </select>
                </div>


                <div class="form-group col-md-3">
                    <label for="district">Tarifa <span class="text-danger">*</span></label>
                    <select name="rate" class="form-control form-control-solid" id="rate">
                        <option selected disabled value="">Seleccione Tarifa</option>
                        @foreach ($rates as $item)
                            <option value="{{ $item->id }}" {{ request()->rate == $item->id ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Valor: <span class="text-danger">*</span></label>
                    <input name="value" id="value" type="number" class="form-control form-control-solid" disabled />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Valor Corp: <span class="text-danger">*</span></label>
                    <input name="corp_value" id="corp_value" type="number" class="form-control form-control-solid"
                        disabled />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Contacto: <span class="text-danger">*</span></label>
                    <input name="contact" id="contact" type="text" class="form-control form-control-solid" placeholder="" />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3 pt-2">
                    <label>Teléfono contacto </label>
                    <input name="phone_contact" type="tel" id="phone_contact" class="form-control form-control-solid"
                        placeholder="" />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Contacto Email: </label>
                    <input name="email_contact" id="email_contact" type="email" class="form-control form-control-solid"
                        placeholder="" />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3 d-flex align-items-center">
                    <div class="checkbox-inline">
                        <label class="checkbox">
                            <input type="checkbox" name="same_day_delivery" id="same_day_delivery" />
                            <span></span>
                            Some Day Delivery
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="sign" id="sign" />
                            <span></span>
                            Firmar
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="take_photo" id="take_photo" />
                            <span></span>
                            Tomar Foto
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="description">Descripción <span class="text-danger">*</span></label>
                    <textarea name="guide_description" id="guide_description" cols="10" rows="2"
                        class="form-control form-control-solid">{{ $order->description }}</textarea>
                </div>
                @include('OrderModule.views.html.national.guideContentTab')
            </div>
            @include('OrderModule.views.html.national.guideList')
        </form>


        <div class="card-footer d-flex justify-content-end">
            <button type="submit" id="create-order-btn" class="btn btn-primary mr-2">Crear Orden</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </div>
        @include('OrderModule.views.html.modals.guideDestino')
    </div>


@endsection
