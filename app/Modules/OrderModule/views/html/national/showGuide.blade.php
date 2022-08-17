@extends('layouts.app')
@section('content')
    @include('layouts.breadCrumbs')
    <div class="card card-custom">
{{--         <div class="card-header">
            <h3 class="card-title">
                Editar orden
            </h3>
        </div> --}}
        @include('layouts.alerts')

        <form id="guide_form" action="{{ route('guides.store') }}" method="POST">
            @csrf
            <div class="card-header border-0 pt-6 pb-0">
                <h3 class="card-title col-10">
                    Datos de destino
                </h3>

{{--                 <div class="card-toolbar col-2">
                    <button class="btn btn-primary font-weight-bolder" type="submit" id="add-guide-btn" type="button"
                        data-tooltip title="CREAR">
                        <span class="svg-icon svg-icon-md">
                            <i class="fas fa-plus"></i>
                        </span>Añadir destino
                    </button>
                </div> --}}
            </div>
            <div class="card-body d-flex flex-row flex-wrap pt-2">
                {{-- <input type="hidden" name="order_id" value="{{ $order->id }}"> --}}
                {{-- <input type="hidden" name="guide_return_last_destination" id="guide_return_last_destination" value="0"> --}}
                <div class="form-group col-md-3">
                    <label for="guide_address">Dirección destino: <span class="text-danger">*</span></label>
                    <input  name="guide_address" class="form-control form-control-solid" value="{{$guide->address_name ?? 'No Registra'}}" disabled>

                </div>

                <div class="form-group col-md-3">
                    <label for="district">Tarifa: <span class="text-danger">*</span></label>
                    <input  name="rate" class="form-control form-control-solid" value="{{$guide->rate ?? 'No Registra'}}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label>Valor: <span class="text-danger">*</span></label>
                    <input name="value" id="value" type="number" class="form-control form-control-solid" value="{{$guide->value ?? 'No Registra'}}" disabled >
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Valor Corp: <span class="text-danger">*</span></label>
                    <input name="corp_value" id="corp_value" type="number" class="form-control form-control-solid"
                        disabled value="{{$guide->corp_value ?? 'No Registra'}}"/>
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Contacto: <span class="text-danger">*</span></label>
                    <input name="contact" id="contact" type="text" class="form-control form-control-solid" disabled
                    value="{{$guide->contact ?? 'No Registra'}}"/>
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3 pt-2">
                    <label>Teléfono contacto: <span class="text-danger">*</span></label>
                    <input name="phone_contact" type="tel" id="phone_contact" class="form-control form-control-solid"
                        disabled value="{{$guide->phone_contact ?? 'No Registra'}}"/>
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Contacto Email: </label>
                    <input name="email_contact" id="email_contact" type="email" class="form-control form-control-solid"
                        disabled value="{{$guide->email_contact ?? 'No Registra'}}"/>
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3 d-flex align-items-center">
                    <div class="checkbox-inline">
                        <label class="checkbox">
                            <input type="checkbox" disabled name="same_day_delivery" id="same_day_delivery" value="{{$guide->same_day_delivery}}"/>
                            <span></span>
                            Some Day Delivery
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" disabled name="sign" id="sign" value="{{$guide->sing}}"/>
                            <span></span>
                            Firmar
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" disabled name="take_photo" id="take_photo"  value="{{$guide->take_photo}}" />
                            <span></span>
                            Tomar Foto
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="description">Descripción: <span class="text-danger">*</span></label>
                    <textarea name="guide_description" id="guide_description" cols="10" disabled rows="2"
                        class="form-control form-control-solid">{{ $guide->description ?? 'No Registra' }}</textarea>
                </div>

{{--                 @include('OrderModule.views.html.national.guideContentTab')
            </div>
            @include('OrderModule.views.html.national.guideList') --}}
        </form>
       {{-- <input type="hidden" name="guides" id="guides"> --}}
        {{-- <div class="card-footer d-flex justify-content-end">
            <button type="submit" id="create-order-btn" class="btn btn-primary mr-2">Actualizar Orden</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </div> --}}

    </div>

    <div class="card-footer d-flex justify-content-end">
        <button type="reset" class="btn btn-secondary"><a href={{ route('orders.index') }}
                class="text-muted">Volver</a></button>
    </div>
@endsection
