{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Crear cliente
        </h3>
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
    <form action="{{route('clientes.store')}}" method="post">
        @csrf
        <div class="card-body d-flex flex-row flex-wrap">

            <div class="form-group col-md-4">
                <label>Nombres: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{old('name')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Apellidos <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" value="{{old('last_name')}}" />
            </div>
            <div class="form-group col-md-4">
                <label>Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="{{old('email')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Telefono: <span class="text-danger">*</span></label>
                <input type="tel" class="form-control form-control-solid" placeholder="Telefono" name="phone" value="{{old('phone')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Tipo de documento</label>
                {{-- <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" checked="checked" name="radios15_1" />
                        <span></span>
                        Cedula
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="radios15_1" />
                        <span></span>
                        NIT
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="radios15_1" />
                        <span></span>
                        RUT
                    </label>
                </div> --}}
                <select class="form-control form-control-solid" id="document_type" name="document_type">
                    <option selected disabled>Seleccione</option>
                    @foreach($documents as $document)
                        <option value="{{$document->id}}" {{$document->id == old('document_type') ? 'selected' : ''}}>{{$document->name}}</option>
                    @endforeach
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Numero de identificación: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="N° de identificación" name="document_number" value="{{old('document_number')}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Fecha de nacimiento: <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-solid" placeholder="" name="birthday" value="{{old('birthday')}}" />
                <span class="form-text text-muted"></span>
            </div>

            <div class="form-group col-md-4">
                <label for="exampleSelect1">Zona <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid" id="zone" name="zone">
                    <option selected disabled> Seleccione </option>
                    <option value="1" {{old('zone') == 1 ? 'seletced' : ''}}>Zona 1</option>
                    <option value="2" {{old('zone') == 2 ? 'seletced' : ''}}>Zona 2</option>
                    <option value="3" {{old('zone') == 3 ? 'seletced' : ''}}>Zona 3</option>
                    <option value="4" {{old('zone') == 4 ? 'seletced' : ''}}>Zona 4</option>
                    <option value="5" {{old('zone') == 5 ? 'seletced' : ''}}>Zona 5</option>
                </select>
            </div>
            <div class="form-group col-md-4 mb-1">
                <label for="exampleTextarea">Contacto <span class="text-danger">*</span></label>
                <textarea class="form-control form-control-solid" id="exampleTextarea" rows="3" name="contact">{{old('contact')}}</textarea>
            </div>
            <div class="form-group col-md-3 my-3">
                <label for="payment_pediod">Periodo de pago <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid px-2 placeholder-dark-75" id="payment_period" name="payment_period">
                    <option value="1" {{old('payment_period') == 1 ? 'selected' : ''}}>1</option>
                    <option value="2" {{old('payment_period') == 2 ? 'selected' : ''}}>2</option>
                    <option value="3" {{old('payment_period') == 3 ? 'selected' : ''}}>3</option>
                    <option value="4" {{old('payment_period') == 4 ? 'selected' : ''}}>4</option>
                    <option value="5" {{old('payment_period') == 5 ? 'selected' : ''}}>5</option>
                </select>
            </div>
            <div class="form-group col-md-2 mb-0 py-4">
                <label>Credito</label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" name="credit" value="1" {{old('credit') == 1 ? 'checked="checked"' : ''}} />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="credit" value="0" {{old('credit') == 0 ? 'checked="checked"' : ''}} />
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
                        <input type="radio" checked="checked" name="receive_emails" value="1" {{old('receive_emails') == 1 ? 'checked="checked"' : ''}} />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="receive_emails" value="0" {{old('receive_emails') == 0 ? 'checked="checked"' : ''}} />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor FullFill <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="fullfill" value="{{old('fullfill')}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor Handling <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="handling" value="{{old('handling')}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor COD <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="COD_value" value="{{old('COD_value')}}" />
            </div>
            <div class="form-group col-md-4 mb-0 py-4">
                <label>Impuesto <span class="text-danger">*</span></label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" name="taxes" value="1" {{old('taxes') == 1 ? 'checked="checked"' : ''}} />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="taxes" value="0" {{old('taxes') == 0 ? 'checked="checked"' : ''}} />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre de empresa <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="text" name="business_name" value="{{old('business_name')}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre comercial <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="text" name="tradename" value="{{old('tradename')}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Repetir Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password_confirmation" />
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
