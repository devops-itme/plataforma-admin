{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Crear cliente
        </h3>
    </div>
    @include('layouts.alerts')
    @include('customers.modals.branches.editBranchModal')
    @include('customers.modals.branches.createBranchModal')
    <!--begin::Form-->
    <form action="{{ route('customers.store') }}" method="post">
        @csrf
        <div class="card-body d-flex flex-row flex-wrap">
            <h5 class="mb-5 font-weight-bold text-dark col-md-12">Información basica de cliente</h5>
            <div class="form-group py-3 m-0 col-md-2">
                <label>Tipo de persona</label>
                <select class="form-control form-control-solid" id="slc_type">
                    <option disabled selected> Seleccione </option>
                    <option value="1">Persona natural</option>
                    <option value="2">Persona juridica</option>
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="col-md-7 d-flex px-0" id="naturalCustomer">
                <div class="form-group py-3 m-0 col-md-6">
                    <label>Nombres: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{ old('name') }}" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group py-3 m-0 col-md-6">
                    <label>Apellidos <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" value="{{ old('last_name') }}" />
                </div>
            </div>
            <div class="d-none" id="legalCustomer">
                <div class="form-group py-3 m-0 col-md-6">
                    <label>Nombre de empresa <span class="text-danger">*</span></label>
                    <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="text" name="business_name" value="{{ old('business_name') }}" />
                </div>
                <div class="form-group py-3 m-0 col-md-6">
                    <label>Nombre comercial <span class="text-danger">*</span></label>
                    <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="text" name="tradename" value="{{ old('tradename') }}" />
                </div>
            </div>
            <div class="form-group py-3 m-0 col-md-3">
                <label>Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="{{ old('email') }}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-3">
                <label>Teléfono: <span class="text-danger">*</span></label>
                <input type="tel" class="form-control form-control-solid" placeholder="Teléfono" name="phone" value="{{ old('phone') }}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-3">
                <label>Tipo de documento</label>
                <select class="form-control form-control-solid" id="document_type" name="document_type">
                    <option selected disabled>Seleccione</option>
                    @foreach ($documents as $document)
                    <option value="{{ $document->id }}" {{ $document->id == old('document_type') ? 'selected' : '' }}>{{ $document->name }}
                    </option>
                    @endforeach
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-3">
                <label>Numero de identificación: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="N° de identificación" name="document_number" value="{{ old('document_number') }}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-3">
                <label>Fecha de nacimiento: <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-solid" placeholder="" name="birthday" value="{{ old('birthday') }}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="password" name="password" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Repetir Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="password" name="password_confirmation" />
            </div>
            <div class="col-md-12">
                <ul class="nav nav-light-success nav-pills border-bottom pb-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">General</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sucursales</a>
                    </li>
                    <!-- <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="popover" tabindex="0" data-trigger="focus" data-html="true" data-placement='bottom' title="<span class='label label-warning label-pill label-inline'>Notificación</span>" data-content="Debe crear primero un <span class='label label-inline font-weight-bold label-light-danger'>Cliente</span> con su respectiva <span class='label label-inline font-weight-bold label-light-danger'>Sucursal</span>.">Departamentos</a>
                    </li> -->
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="departament-tab" data-toggle="tab" href="#departament" role="tab" aria-controls="departament" aria-selected="false">Departamentos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-toggle="popover" tabindex="0" data-trigger="focus" data-html="true" data-placement='bottom' title="<span class='label label-warning label-pill label-inline'>Notificación</span>" data-content="Debe crear primero un <span class='label label-inline font-weight-bold label-light-danger'>Cliente</span>.">Usuarios</a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="d-flex flex-wrap mt-3">
                            <h5 class="my-4 font-weight-bold text-dark col-md-12">Información general de cliente</h5>
                            <div class="form-group col-md-3 py-3 m-0">
                                <label for="exampleSelect1">Zona <span class="text-danger">*</span></label>
                                <select class="form-control form-control-solid" id="zone" name="zone">
                                    <option selected disabled> Seleccione </option>
                                    <option value="1" {{ old('zone') == 1 ? 'seletced' : '' }}>Zona 1</option>
                                    <option value="2" {{ old('zone') == 2 ? 'seletced' : '' }}>Zona 2</option>
                                    <option value="3" {{ old('zone') == 3 ? 'seletced' : '' }}>Zona 3</option>
                                    <option value="4" {{ old('zone') == 4 ? 'seletced' : '' }}>Zona 4</option>
                                    <option value="5" {{ old('zone') == 5 ? 'seletced' : '' }}>Zona 5</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 py-3 m-0">
                                <label for="exampleTextarea">Contacto <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-solid" id="exampleTextarea" rows="1" name="contact">{{ old('contact') }}</textarea>
                            </div>
                            <div class="form-group col-md-2 my-3">
                                <label for="payment_pediod">Periodo de pago <span class="text-danger">*</span></label>
                                <select class="form-control form-control-solid px-2 placeholder-dark-75" id="payment_period" name="payment_period">
                                    <option value="" selected disabled> Seleccione </option>
                                    @foreach ($payment_period as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-0 py-4">
                                <label>Credito</label>
                                <div class="radio-inline">
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="credit" value="1" {{ old('credit') == 1 ? 'checked="checked"' : '' }} />
                                        <span></span>
                                        SI
                                    </label>
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="credit" value="0" {{ old('credit') == 0 ? 'checked="checked"' : '' }} />
                                        <span></span>
                                        NO
                                    </label>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group col-md-2 mb-0 py-4">
                                <label>Enviar saldo por Email</label>
                                <div class="radio-inline">
                                    <label class="radio radio-rounded">
                                        <input type="radio" checked="checked" name="receive_emails" value="1" {{ old('receive_emails') == 1 ? 'checked="checked"' : '' }} />
                                        <span></span>
                                        SI
                                    </label>
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="receive_emails" value="0" {{ old('receive_emails') == 0 ? 'checked="checked"' : '' }} />
                                        <span></span>
                                        NO
                                    </label>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-2">
                                <label>Valor FullFill <span class="text-danger">*</span></label>
                                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="number" name="fullfill" value="{{ old('fullfill') }}" />
                            </div>
                            <div class="form-group py-3 m-0 col-md-2">
                                <label>Valor Handling <span class="text-danger">*</span></label>
                                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="number" name="handling" value="{{ old('handling') }}" />
                            </div>
                            <div class="form-group py-3 m-0 col-md-2">
                                <label>Valor COD <span class="text-danger">*</span></label>
                                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75" type="number" name="COD_value" value="{{ old('COD_value') }}" />
                            </div>
                            <div class="form-group col-md-4 mb-0 py-4">
                                <label>Impuesto <span class="text-danger">*</span></label>
                                <div class="radio-inline">
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="taxes" value="1" {{ old('taxes') == 1 ? 'checked="checked"' : '' }} />
                                        <span></span>
                                        SI
                                    </label>
                                    <label class="radio radio-rounded">
                                        <input type="radio" name="taxes" value="0" {{ old('taxes') == 0 ? 'checked="checked"' : '' }} />
                                        <span></span>
                                        NO
                                    </label>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="col-md-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="d-flex flex-row flex-wrap">
                                        <div class="col-md-6 d-flex flex-row flex-wrap border-right">
                                            <h5 class="my-4 font-weight-bold text-dark col-md-12">Información general de orden</h5>
                                            <div class="form-group col-md-6">
                                                <label for="trans_type">Tipo de transporte <span class="text-danger">*</span></label>
                                                <select name="vehicle_type_id" class="form-control form-control-solid" id="trans_type">
                                                    <option selected="" disabled="">Seleccione tipo de transporte</option>
                                                    <option value="1">Moto</option>
                                                    <option value="2">Auto</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pay_method">Metodo de pago <span class="text-danger">*</span></label>
                                                <select name="payment_method_id" class="form-control form-control-solid" id="pay_method">
                                                    <option selected="" disabled="">Seleccione Metodo de pago</option>
                                                    <option value="1">Efectivo</option>
                                                    <option value="2">Cheque</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Fecha de programación: <span class="text-danger">*</span></label>
                                                <input name="schedule_date" type="date" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Hora de programación: <span class="text-danger">*</span></label>
                                                <input name="schedule_time" type="time" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-md-12 m-0 d-flex align-items-center">
                                                <div class="checkbox-inline">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="express_delivery">
                                                        <span></span>
                                                        Marcar Urgente Despacho
                                                    </label>
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="last_destination_return">
                                                        <span></span>
                                                        Retorno Ultimo Destino
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex flex-row flex-wrap">
                                            <h5 class="my-4 font-weight-bold text-dark col-md-12">Seguro de mercancia</h5>
                                            <div class="form-group col-md-6">
                                                <label>Valor asegurado: <span class="text-danger">*</span></label>
                                                <input name="insured_value" type="number" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>A cobrar %: <span class="text-danger">*</span></label>
                                                <input name="percentage_receivable" type="number" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>A cobrar $: <span class="text-danger">*</span></label>
                                                <input name="value_receivable" type="number" class="form-control form-control-solid" placeholder="">
                                                <span class="form-text text-muted"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <!--tabla de datos-->
                                    <table class="table table-sm" id="branch_offices_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre de Sucursal</th>
                                                <th scope="col">Tipo de Sucursal</th>
                                                <th scope="col">Zona de Sucursal</th>
                                                <th scope="col">Contacto de Sucursal</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="#" class="btn btn-primary btn-sm font-weight-bolder" data-toggle="modal" data-target="#modalCreate">
                                                            <span class="svg-icon svg-icon-md">
                                                                <i class="fas fa-plus"></i>
                                                            </span>Crear
                                                        </a>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- DEPARTMENT MODULE --}}
                    <div class="tab-pane fade" id="departament" role="tabpanel" aria-labelledby="departament-tab">
                       <department-tab>

                       </department-tab>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-2">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </div>
    </form>
    <!--end::Form-->
</div>

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection

{{-- Scripts --}}
@section('scripts')

@endsection
@push('scripts')

{{-- <script>
        const directionCity = document.getElementById('branch_office_address');

        google.maps.event.addDomListener(window, 'load', function() {
                    const autocompleteCity = new google.maps.places.Autocomplete(
                        directionCity, {
                            bounds: new google.maps.LatLngBounds(
                                new google.maps.LatLng(40.416775, -3.703790)
                            ),
                            types: ['geocode']
                        }
                    );

                    autocompleteCity.addListener("place_changed", () => {
                        const place = autocompleteCity.getPlace();
                        document.getElementById('branch_office_address').value = place.formatted_address;
                        document.getElementById('branch_office_lat').value = place.geometry.location.lat();
                        document.getElementById('branch_office_lng').value = place.geometry.location.lng();

                    });
    </script> --}}
@endpush
