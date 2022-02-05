{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Crear orden
            </h3>
        </div>
        @include('layouts.alerts')
        <!--begin::Form-->
        <form>
            @csrf
            <div class="card-body d-flex flex-row flex-wrap pt-2">
                <h5 class="my-4 font-weight-bold text-dark col-md-12">Información basica de orden</h5>
                <div class="form-group col-md-2">
                    <label>Numero de orden: <span class="text-danger">*</span></label>
                    <input name="order_num" type="text" class="form-control form-control-solid" placeholder="333" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-2">
                    <label for="order_type">Tipo de orden <span class="text-danger">*</span></label>
                    <select name="orden_type" class="form-control form-control-solid" id="order_type">
                        <option selected disabled>Seleccione tipo de orden</option>
                        <option>Ondeman</option>
                        <option>Multiple</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="customers">Cliente <span class="text-danger">*</span></label>
                    <select name="customers" class="form-control" id="customers">
                        <option selected disabled>Seleccione Cliente</option>
                        <option>Cliente 1</option>
                        <option>Cliente 2</option>
                        <option>Cliente 3</option>
                    </select>
                </div>
                <div class="form-group col-md-1 d-flex align-items-center flex-row pt-6">
                    <button type="button" class="btn btn-icon btn-light-success btn-sm mr-2" data-toggle="modal"
                        data-target="#detailCustomer">
                        <i class="fad fa-eye"></i>
                    </button>

                    <a href="{{ route('customers.create') }}" class="btn btn-icon btn-light-primary btn-sm mr-2">
                        <i class="fad fa-plus"></i>
                    </a>
                </div>
                <div class="form-group col-md-2">
                    <label for="rates">Tarifa <span class="text-danger">*</span></label> <a
                        href="#"><small>Ver</small></a>
                    <select name="rates" class="form-control" id="rates">
                        <option selected disabled>Seleccione Tarifa</option>
                        <option>Tarifa 1</option>
                        <option>Tarifa 2</option>
                        <option>Tarifa 3</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Gastos de envio: <span class="text-danger">*</span></label>
                    <input name="send_cost" type="text" class="form-control form-control-solid" placeholder="333" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="col-md-12">
                    <ul class="nav nav-light-success nav-pills border-bottom pb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab"
                                aria-controls="general" aria-selected="true">General</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">Pedidos / Destinos</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            @include('orders.generalTab')
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @include('orders.guideTab')
                        </div>
                    </div>
                </div>


                {{-- <div class="form-group col-md-2">
                <label>Fecha de ingreso: <span class="text-danger">*</span></label>
                <input name="admission_date" type="date" class="form-control form-control-solid" placeholder="" value="{{old('admission_date')}}"/>
                <span class="form-text text-muted"></span>
            </div> --}}

                {{-- <div class="form-group col-md-2">
                <label>Exclusivo</label>
                <div class="radio-inline">
                    <label class="radio radio-rounded">
                        <input type="radio" checked="checked" name="exclusive" value="1" />
                        <span></span>
                        SI
                    </label>
                    <label class="radio radio-rounded">
                        <input type="radio" name="exclusive" value="0" />
                        <span></span>
                        NO
                    </label>
                </div>
                <span class="form-text text-muted"></span>
            </div> --}}
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" id="btn-create-messenger" class="btn btn-primary mr-2">Guardar</button>
                <button type="reset" class="btn btn-secondary">Limpiar</button>
            </div>
        </form>
        <!--end::Form-->
    </div>
    @include('orders.detailCustomer')

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
