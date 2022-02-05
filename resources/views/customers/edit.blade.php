{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')

<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Editar cliente
        </h3>
    </div>
    @include('layouts.alerts')
    <!--begin::Form-->
    <form action="{{route('customers.update', $customer->id)}}" method="post">
        @csrf @method('PUT')
        <div class="card-body d-flex flex-row flex-wrap">

            <div class="form-group col-md-4">
                <label>Nombres: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Nombres" name="name" value="{{$customer->getUser->name}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Apellidos <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="Apellidos" name="last_name" value="{{$customer->getUser->last_name}}" />
            </div>
            <div class="form-group col-md-4">
                <label>Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="{{$customer->getUser->email}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Telefono: <span class="text-danger">*</span></label>
                <input type="tel" class="form-control form-control-solid" placeholder="Telefono" name="phone" value="{{$customer->getUser->phone}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Tipo de documento</label>
                <select class="form-control form-control-solid" id="document_type" name="document_type">
                    <option selected disabled>Seleccione</option>
                    @foreach($documents as $document)
                        <option value="{{$document->id}}" {{$document->id == $customer->getUser->document_type ? 'selected' : ''}}>{{$document->name}}</option>
                    @endforeach
                </select>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Numero de identificación: <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid" placeholder="N° de identificación" name="document_number" value="{{$customer->getUser->document_number}}" />
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group col-md-4">
                <label>Fecha de nacimiento: <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-solid" placeholder="" name="birthday" value="{{$customer->birthday}}" />
                <span class="form-text text-muted"></span>
            </div>

            <div class="form-group col-md-4">
                <label for="exampleSelect1">Zona <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid" id="zone" name="zone">
                    <option selected disabled> Seleccione </option>
                    <option {{$customer->zone_id == 1 ? 'selected' : ''}}>1</option>
                    <option {{$customer->zone_id == 2 ? 'selected' : ''}}>2</option>
                    <option {{$customer->zone_id == 3 ? 'selected' : ''}}>3</option>
                    <option {{$customer->zone_id == 4 ? 'selected' : ''}}>4</option>
                    <option {{$customer->zone_id == 5 ? 'selected' : ''}}>5</option>
                </select>
            </div>
            <div class="form-group col-md-4 mb-1">
                <label for="exampleTextarea">Contacto <span class="text-danger">*</span></label>
                <textarea class="form-control form-control-solid" id="exampleTextarea" rows="3" name="contact">{{$customer->contact}}</textarea>
            </div>
            <div class="form-group col-md-3 my-3">
                <label for="payment_pediod">Periodo de pago <span class="text-danger">*</span></label>
                <select class="form-control form-control-solid px-2 placeholder-dark-75" id="payment_pediod" name="payment_period">
                    <option {{$customer->payment_period == 1 ? 'selected' : ''}}>1</option>
                    <option {{$customer->payment_period == 2 ? 'selected' : ''}}>2</option>
                    <option {{$customer->payment_period == 3 ? 'selected' : ''}}>3</option>
                    <option {{$customer->payment_period == 4 ? 'selected' : ''}}>4</option>
                    <option {{$customer->payment_period == 5 ? 'selected' : ''}}>5</option>
                </select>
            </div>
            <div class="form-group col-md-2 mb-0 py-4">
                <label>Credito</label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" name="credit" {{$customer->credit == 1 ? 'checked="checked"' : ''}} value="1" />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="credit" {{$customer->credit == 0 ? 'checked="checked"' : ''}} value="0" />
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
                        <input type="radio" checked="checked" name="receive_emails" value="1" {{$customer->receive_emails == 1 ? 'checked="checked"' : ''}}/>
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="receive_emails" value="0" {{$customer->receive_emails == 0 ? 'checked="checked"' : ''}}/>
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor FullFill <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="fullfill" value="{{$customer->fullfill}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor Handling <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="handling" value="{{$customer->handling}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-4">
                <label>Valor COD <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="number" name="COD_value" value="{{$customer->COD_value}}" />
            </div>
            <div class="form-group col-md-4 mb-0 py-4">
                <label>Impuesto <span class="text-danger">*</span></label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" name="taxes" value="1" {{$customer->taxes == '1' ? 'checked="checked"' : ''}} />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="taxes" value="0" {{$customer->taxes == '0' ? 'checked="checked"' : ''}} />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre de empresa <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="text" name="business_name" value="{{$customer->business_name}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Nombre comercial <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="text" name="tradename" value="{{$customer->tradename}}" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password" />
            </div>
            <div class="form-group py-3 m-0 col-md-6">
                <label>Repetir Contraseña <span class="text-danger">*</span></label>
                <input class="form-control h-auto form-control-solid px-2 placeholder-dark-75"
                    type="password" name="password_repeat" />
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
