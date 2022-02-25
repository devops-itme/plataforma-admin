{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h2 class="card-label h1">Sucursales - Banco {{$bankData->getCustomer->business_name}}
                {{-- <div class="text-muted pt-2 font-size-sm">Datatable initialized from HTML table</div> --}}
            </h2>
        </div>
        @include('layouts.alerts')

        {{--<div class="card-toolbar">
            <!--begin::Button filter-->
            <button class="btn btn-light-success mr-2 px-6 font-weight-bold btn-filter">
                <span class="svg-icon svg-icon-md">
                    <i class="fas fa-arrow-down" aria-hidden="true"></i>
                </span>Filtro
            </button>
            <!--end::Button filter-->
            <!--begin::Dropdown-->
            <div class="dropdown dropdown-inline mr-2">
                <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
                                <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>Exportar
                </button>
                <!--begin::Dropdown Menu-->
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <!--begin::Navigation-->
                    <ul class="navi flex-column navi-hover py-2">
                        <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                            Escoger:</li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="la la-print"></i>
                                </span>
                                <span class="navi-text">Print</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="la la-copy"></i>
                                </span>
                                <span class="navi-text">Copy</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="la la-file-excel-o"></i>
                                </span>
                                <span class="navi-text">Excel</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="la la-file-text-o"></i>
                                </span>
                                <span class="navi-text">CSV</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="la la-file-pdf-o"></i>
                                </span>
                                <span class="navi-text">PDF</span>
                            </a>
                        </li>
                    </ul>
                    <!--end::Navigation-->
                </div>
                <!--end::Dropdown Menu-->
            </div>
            <!--end::Dropdown-->
            <!--begin::Button-->
            <a href="{{route('branchOffices.create', $bankData->id)}}" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <i class="fas fa-plus"></i>
                </span>Crear</a>

            <!--end::Button-->
        </div>--}}

    </div>
    <div class="card-body">
        <!--begin: Search Form-->
        <!--begin::Search Form-->
        <div class="mb-7">
            <div class="form-filter" style="display:none">
                <form action="">
                    <div class="row align-items-center">
                        <div class="form-group py-3 m-0 col-md-4">
                            <label>Nombre sucursal:</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Nombre" name="name" value="{{ request()->name }}" />
                            <span class="form-text text-muted">Filtro nombre</span>
                        </div>
                        <div class="form-group py-3 m-0 col-md-4">
                            <label>Descripción sucursal:</label>
                            <textarea type="text" class="form-control form-control-solid" name="description"> {{ request()->description }} </textarea>
                            <span class="form-text text-muted">Filtro descripcion</span>
                        </div>
                        <div class="form-group py-3 m-0 col-md-4">
                            <label>Dirección sucursal:</label>
                            <input type="text" class="form-control form-control-solid" placeholder="23 Main Street, New York, NY 10030" name="address" value="{{ request()->address }}" />
                            <span class="form-text text-muted">Filtro direccion</span>
                        </div>
                        <div class="form-group py-3 m-0 col-md-4">
                            <label>Correo sucursal:</label>
                            <input type="text" class="form-control form-control-solid" placeholder="email@example.com" name="email" value="{{ request()->email }}" />
                            <span class="form-text text-muted">Filtro correo</span>
                        </div>
                        <div class="form-group py-3 m-0 col-md-4">
                            <label>Teléfono sucursal:</label>
                            <input type="text" class="form-control form-control-solid" placeholder="+1 (616) 337-9576" name="phone" value="{{ request()->phone }}" />
                            <span class="form-text text-muted">Filtro teléfono</span>
                        </div>
                        <div class="form-group py-3 m-0 col-md-4">
                            <label for="exampleSelect1">Predeterminada: </label>
                            <select class="form-control form-control-solid" id="zone" name="default">
                                <option selected disabled> Seleccione </option>
                                <option value="1" {{ request()->default == 1 ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ (request()->default != '' && request()->default == 0) ? 'selected' : '' }}>No</option>
                            </select>
                            <span class="form-text text-muted">Filtro estado</span>
                        </div>

                        <div class=" row form-group py-6 m-0 col-md-12">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-light-primary px-6 font-weight-bold btn-block"> Filtrar</button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('customers.index')}}" class="btn btn-light-danger px-6 font-weight-bold btn-block">Limpiar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Search Form-->
        <!--end: Search Form-->
        <!--begin: Datatable-->

        <form action="#">
            <table class="table table-sm">
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
                <tbody>
                    <tr>
                        <th scope="row">---</th>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>
                            <span class="label label-inline label-light-success font-weight-bold">
                                Activo
                            </span>

                        </td>
                        <td>
                            <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                                <a href="#" class="btn btn-icon btn-light-primary btn-sm mr-2">
                                    <i class="far fa-folder-open"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-light-success btn-sm mr-2" data-toggle="modal" data-target="#modalEdit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" role="button" class="btn btn-icon btn-light-danger btn-sm mr-2">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Modal Create-->
            <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCreateLabel">Crear Sucursal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="far fa-times h5"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-row flex-wrap">
                                <div class="form-group col-md-3">
                                    <label>Nombre de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Nombre sucursal" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Tipo de sucursal</label>
                                    <select class="form-control form-control-solid" id="" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($branch_office_type as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                        {{ $item->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Descripción de sucursal:</label>
                                    <textarea class="form-control form-control-solid" id="exampleTextarea" rows="1" name="">{{--{{ old('branch_office_description') }}--}}</textarea>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Zona de sucursal:</label>
                                    <select class="form-control form-control-solid" id="document_type" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($documents as $document)
                                    <option value="{{ $document->id }}" {{ $document->id == old('branch_office_zone') ? 'selected' : '' }}>
                                        {{ $document->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Dirección de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Dirección" name="" value="" id="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <input type="hidden" name="" id="">
                                <input type="hidden" name="" id="g">
                                <div class="form-group col-md-4">
                                    <label>Email de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Email" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Contacto de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Contacto" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Tipo de documento sucursal:</label>
                                    <select class="form-control form-control-solid" id="document_type" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($documents as $document)
                                    <option value="{{ $document->id }}" {{ $document->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                        {{ $document->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Documento de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Número de documento" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Metodo de pago:</label>
                                    <select class="form-control form-control-solid" id="payment_method" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($payment_method as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                        {{ $item->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Teléfono de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Teléfono" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="d-none" id="slcPlan">
                                    <label>Planes:</label>
                                    <select class="form-control form-control-solid" id="document_type" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($documents as $document)
                                    <option value="{{ $document->id }}" {{ $document->id == old('branch_office_usage_mode') ? 'selected' : '' }}>
                                        {{ $document->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="d-none" id="useMode">
                                    <label>Modo de uso:</label>
                                    <select class="form-control form-control-solid" id="document_type" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($use_mode as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == old('branch_office_usage_mode') ? 'selected' : '' }}>
                                        {{ $item->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-2 mb-0 py-4">
                                    <label>¿Sucursal predeterminada?</label>
                                    <div class="radio-inline">
                                        <label class="radio radio-rounded">
                                            <input type="radio" checked="checked" name="" value="1" />
                                            <span></span>
                                            SI
                                        </label>
                                        <label class="radio radio-rounded">
                                            <input type="radio" name="branch_office_default" value="0" />
                                            <span></span>
                                            NO
                                        </label>
                                    </div>
                                    <span class="form-text text-muted"></span>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary font-weight-bold">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal edit-->
            <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Editar Sucursal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="far fa-times h5"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-row flex-wrap">
                                <div class="form-group col-md-3">
                                    <label>Nombre de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Nombre sucursal" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Tipo de sucursal</label>
                                    <select class="form-control form-control-solid" id="" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($branch_office_type as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                        {{ $item->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Descripción de sucursal:</label>
                                    <textarea class="form-control form-control-solid" id="exampleTextarea" rows="1" name=""></textarea>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Zona de sucursal:</label>
                                    <select class="form-control form-control-solid" id="document_type" name="branch_office_zone">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($documents as $document)
                                    <option value="{{ $document->id }}" {{ $document->id == old('branch_office_zone') ? 'selected' : '' }}>
                                        {{ $document->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Dirección de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Dirección" name="" value="" id="branch_office_address" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <input type="hidden" name="" id="">
                                <input type="hidden" name="" id="">
                                <div class="form-group col-md-4">
                                    <label>Email de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Email" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Contacto de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Contacto" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Tipo de documento sucursal:</label>
                                    <select class="form-control form-control-solid" id="document_type" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($documents as $document)
                                    <option value="{{ $document->id }}" {{ $document->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                        {{ $document->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Documento de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Número de documento" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Metodo de pago:</label>
                                    <select class="form-control form-control-solid" id="payment_method" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($payment_method as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                        {{ $item->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Teléfono de sucursal: </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Teléfono" name="" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="d-none" id="slcPlan">
                                    <label>Planes:</label>
                                    <select class="form-control form-control-solid" id="document_type" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($documents as $document)
                                    <option value="{{ $document->id }}" {{ $document->id == old('branch_office_usage_mode') ? 'selected' : '' }}>
                                        {{ $document->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="d-none" id="useMode">
                                    <label>Modo de uso:</label>
                                    <select class="form-control form-control-solid" id="document_type" name="">
                                        <option selected disabled>Seleccione</option>
                                        {{--@foreach ($use_mode as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == old('branch_office_usage_mode') ? 'selected' : '' }}>
                                        {{ $item->name }}
                                        </option>
                                        @endforeach--}}
                                    </select>
                                    <span class="form-text text-muted"></span>
                                </div>
                                <div class="form-group col-md-2 mb-0 py-4">
                                    <label>¿Sucursal predeterminada?</label>
                                    <div class="radio-inline">
                                        <label class="radio radio-rounded">
                                            <input type="radio" checked="checked" name="branch_office_default" value="1" />
                                            <span></span>
                                            SI
                                        </label>
                                        <label class="radio radio-rounded">
                                            <input type="radio" name="branch_office_default" value="0" />
                                            <span></span>
                                            NO
                                        </label>
                                    </div>
                                    <span class="form-text text-muted"></span>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary font-weight-bold">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        <!--end: Datatable-->
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
        <button type="reset" class="btn btn-secondary">Limpiar</button>
    </div>
</div>


@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
