{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
@include('layouts.breadCrumbs')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h2 class="card-label h1">Usuarios - Banco {{$bankData->getCustomer->business_name}}
                    {{-- <div class="text-muted pt-2 font-size-sm">Datatable initialized from HTML table</div> --}}
                </h2>
            </div>
            @include('layouts.alerts')
            <div class="card-toolbar">
                 <!--begin::Button filter-->
                 <button class="btn btn-light-success mr-2 px-6 font-weight-bold btn-filter">
                    <span class="svg-icon svg-icon-md">
                        <i class="fas fa-arrow-down" aria-hidden="true"></i>
                    </span>Filtro
                </button>
                <!--end::Button filter-->
                <!--begin::Dropdown-->
                <div class="dropdown dropdown-inline mr-2">
                    <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                        fill="#000000" opacity="0.3" />
                                    <path
                                        d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                        fill="#000000" />
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
                <a href="{{route('bankUsers.create', $bankData->id)}}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <i class="fas fa-plus"></i>
                    </span>Crear</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Search Form-->
            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="form-filter" style="display:none">
                    <form action="">
                        <div class="row align-items-center">
                            <div class="form-group py-3 m-0 col-md-3">
                                <label>Nombre del cliente:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Nombre" name="name"
                                    value="{{ request()->name }}" />
                                <span class="form-text text-muted">Filtro nombre</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-3">
                                <label>Correo del cliente:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="email@example.com" name="email"
                                    value="{{ request()->email }}" />
                                <span class="form-text text-muted">Filtro correo</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-3">
                                <label>Teléfono del cliente:</label>
                                <input type="text" class="form-control form-control-solid" placeholder="+1 (616) 337-9576" name="phone"
                                    value="{{ request()->phone }}" />
                                <span class="form-text text-muted">Filtro teléfono</span>
                            </div>
                            <div class="form-group py-3 m-0 col-md-3">
                                <label for="exampleSelect1">Estado: </label>
                                        <select class="form-control form-control-solid" id="zone" name="state">
                                            <option selected disabled> Seleccione </option>
                                            <option value="1" {{ request()->state == 1 ? 'selected' : '' }}>Activo</option>
                                            <option value="0" {{ (request()->state != '' && request()->state == 0) ? 'selected' : '' }}>Inactivo</option>
                                        </select>
                                <span class="form-text text-muted">Filtro estado</span>
                            </div>
                            <div class=" row form-group py-6 m-0 col-md-12">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-light-primary px-6 font-weight-bold btn-block"> Filtrar</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('customers.index') }}" class="btn btn-light-danger px-6 font-weight-bold btn-block">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->


            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Email</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users) > 0)
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                @if($user->state == 1)
                                    <td>
                                        <span class="label label-inline label-light-success font-weight-bold">
                                            Activo
                                        </span>
                                    </td>
                                @else
                                    <td>
                                        <span class="label label-inline label-light-danger font-weight-bold">
                                            Inactivo
                                        </span>
                                    </td>
                                @endif
                                <td>
                                    <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">

                                        <a href="{{route('bankUsers.show', [$user->parent_id, $user->id])}}" class="btn btn-icon btn-light-primary btn-sm mr-2">
                                            <i class="fad fa-folder-open"></i>
                                        </a>
                                        <a href="{{route('bankUsers.edit', [$user->parent_id, $user->id])}}" class="btn btn-icon btn-light-success btn-sm mr-2">
                                            <i class="fad fa-edit"></i>
                                        </a>
                                        {{-- <form action="{{route('customers.destroy', $bank->id)}}" method="{{'post'}}">
                                            @csrf @method('DELETE') --}}
                                            <button type="button" onclick="confirmDelete('/usuario-banco/'+{{$user->parent_id}}+'/'+{{$user->id}})" class="btn btn-icon btn-light-danger btn-sm mr-2">
                                                <i class="fad fa-trash-alt"></i>
                                            </button>
                                        {{-- </form> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="8" class="text-center">¡No hay usuarios registrados!</td>
                        </tr>
                    @endif
                </tbody>
            </table>


            <!--end: Datatable-->
        </div>
    </div>

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection
