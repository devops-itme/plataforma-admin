@extends('layouts.app')
@section('content')
    @include('layouts.breadCrumbs')
    <div class="card card-custom">
        <form id="update-guide-form" action="{{ route('guides.update', $guide->id) }}" method="POST">
            <div class="card-header row flex-wrap border-0 pt-6 pb-0">
                @csrf @method('PUT')
                <h3 class="card-title col-10">
                    Datos de destino
                </h3>

                <div class="card-toolbar" >
                    <a href="{{ route('orders.edit', $guide_id) }}">
                    <button class="btn btn-light-primary"
                            type="button" data-tooltip title="Volver a la orden">
                            Volver</button></a>

                    <button class="btn btn-primary font-weight-bolder" id="update-guide-btn" type="button" data-tooltip
                        title="CREAR">
                        <span class="svg-icon svg-icon-md">
                        </span>Actualizar destino
                    </button>
                </div>
            </div>

            @include('layouts.alerts')
            <div class="card-body d-flex flex-row flex-wrap pt-2">
                <div class="form-group col-md-2">
                    <label for="guide_address">Dirección destino <span class="text-danger">*</span></label>
                    <select name="address_id" class="form-control form-control-solid" id="guide_address">
                        <option selected disabled value="">Seleccione</option>
                        @foreach ($addresses as $item)
                            <option value="{{ $item->id }}" {{ $guide->address_id == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-1 mb-0 d-flex align-items-center justify-content-start">
                    <a class="btn" data-toggle="modal" data-target="#modalCreateAddress" data-dismiss="modal">
                        <i class="fad fa-plus-circle text-info"></i>
                    </a>
                </div>

                {{-- <div class="form-group col-md-3">
                <label for="district">Tarifa <span class="text-danger">*</span></label>
                <select name="rate" class="form-control form-control-solid" id="rate">
                    <option selected disabled value="">Seleccione Tarifa</option>
                    @foreach ($rates as $item)
                        <option value="{{ $item->id }}" {{ request()->rate == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
            </div> --}}

                <div class="form-group col-md-3">
                    <label>Valor: <span class="text-danger">*</span></label>
                    <input name="value" id="value" type="number" class="form-control form-control-solid"
                        value="{{ $guide->value }}" disabled />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Valor Corp: <span class="text-danger">*</span></label>
                    <input name="corp_value" id="corp_value" type="number" class="form-control form-control-solid"
                        value="{{ $guide->corp_value }}" disabled />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Contacto: <span class="text-danger">*</span></label>
                    <input name="contact" id="contact" value="{{ $guide->contact }}" type="text"
                        class="form-control form-control-solid" placeholder="" />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3 pt-2">
                    <label>Teléfono contacto </label>
                    <input name="phone_contact" type="tel" id="phone_contact" value="{{ $guide->phone_contact }}"
                        class="form-control form-control-solid" placeholder="" />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3">
                    <label>Contacto Email: </label>
                    <input name="email_contact" id="email_contact" value="{{ $guide->email_contact }}" type="email"
                        class="form-control form-control-solid" placeholder="" />
                    <span class="form-text text-muted"></span>
                </div>

                <div class="form-group col-md-3 d-flex align-items-center">
                    <div class="checkbox-inline">
                        <label class="checkbox">
                            <input type="checkbox" {{ $guide->same_day_delivery == 1 ? 'checked' : '' }}
                                name="same_day_delivery" id="same_day_delivery" />
                            <span></span>
                            Some Day Delivery
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" {{ $guide->sign == 1 ? 'checked' : '' }} name="sign" id="sign" />
                            <span></span>
                            Firmar
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" {{ $guide->take_photo == 1 ? 'checked' : '' }} name="take_photo"
                                id="take_photo" />
                            <span></span>
                            Tomar Foto
                        </label>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="guide_description">Descripción <span class="text-danger">*</span></label>
                    <textarea name="guide_description" cols="10" rows="2" class="form-control form-control-solid"> {{ $guide->description }}</textarea>
                </div>

                <input type="hidden" name="boxes" id="boxes" value="{{ $guide->boxes }}">
                @include('OrderModule.views.html.national.guideContentTab')
            </div>
        </form>
    </div>
@endsection
