{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Detalles sucursal
        </h3>
    </div>
    <div class="card-body d-flex flex-row flex-wrap">
        <div class="form-group col-md-4">
            <label>Nombre de sucursal: </label>
            <input type="text" class="form-control form-control-solid" placeholder="Nombre sucursal" name="branch_office_name" value="{{$office->name}}" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Tipo de sucursal</label>
            <select class="form-control form-control-solid" id="branch_office_type" name="branch_office_type" disabled>
                <option selected disabled>Seleccione</option>
                @foreach($documents as $document)
                    <option value="{{$document->id}}" {{$document->id == $office->type ? 'selected' : ''}}>{{$document->name}}</option>
                @endforeach
            </select>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Descripción de sucursal:</label>
            <textarea class="form-control form-control-solid" id="exampleTextarea" rows="3" name="branch_office_description" disabled>{{$office->description}}</textarea>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Zona de sucursal:</label>
            <select class="form-control form-control-solid" id="document_type" name="branch_office_zone" disabled>
                <option selected disabled>Seleccione</option>
                @foreach($documents as $document)
                    <option value="{{$document->id}}" {{$document->id == $office->zone_id ? 'selected' : ''}}>{{$document->name}}</option>
                @endforeach
            </select>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Dirección de sucursal: </label>
            <input type="text" class="form-control form-control-solid" placeholder="Dirección" name="branch_office_address" value="{{$office->address}}" id="branch_office_address" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <input type="hidden" name="branch_office_lat" id="branch_office_lat">
        <input type="hidden" name="branch_office_lng" id="branch_office_lng">
        <div class="form-group col-md-4">
            <label>Email de sucursal: </label>
            <input type="text" class="form-control form-control-solid" placeholder="Email" name="branch_office_email" value="{{$office->email}}" disabled />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Contacto de sucursal: </label>
            <input type="text" class="form-control form-control-solid" placeholder="Contacto" name="branch_office_contact" value="{{$office->contact}}" disabled />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Tipo de documento sucursal:</label>
            <select class="form-control form-control-solid" id="document_type" name="branch_office_document_type" disabled>
                <option selected disabled>Seleccione</option>
                @foreach($documents as $document)
                    <option value="{{$document->id}}" {{$document->id == $office->document_type ? 'selected' : ''}}>{{$document->name}}</option>
                @endforeach
            </select>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Documento de sucursal: </label>
            <input type="text" class="form-control form-control-solid" placeholder="Número de documento" name="branch_office_document_number" value="{{$office->document_number}}" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Metodo de pago:</label>
            <select class="form-control form-control-solid" id="document_type" name="branch_office_payment_method" disabled>
                <option selected disabled>Seleccione</option>
                @foreach($documents as $document)
                    <option value="{{$document->id}}" {{$document->id == $office->payment_method ? 'selected' : ''}}>{{$document->name}}</option>
                @endforeach
            </select>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Teléfono de sucursal: </label>
            <input type="text" class="form-control form-control-solid" placeholder="Teléfono" name="branch_office_phone" value="{{$office->phone}}" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-4">
            <label>Modo de uso:</label>
            <select class="form-control form-control-solid" id="document_type" name="branch_office_usage_mode" disabled>
                <option selected disabled>Seleccione</option>
                @foreach($documents as $document)
                    <option value="{{$document->id}}" {{$document->id == $office->usage_mode ? 'selected' : ''}}>{{$document->name}}</option>
                @endforeach
            </select>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-2 mb-0 py-4">
            <label>¿Sucursal predeterminada?</label>
            <div class="radio-inline">
                <label class="radio radio-rounded">
                    <input type="radio" name="branch_office_default" value="1" {{$office->default == 1 ? 'checked="checked"' : ''}} disabled/>
                    <span></span>
                    SI
                </label>
                <label class="radio radio-rounded">
                    <input type="radio" name="branch_office_default" value="0" {{$office->default == 0 ? 'checked="checked"' : ''}} disabled/>
                    <span></span>
                    NO
                </label>
            </div>
            <span class="form-text text-muted"></span>
        </div>
    </div>
</div>
@endsection
