{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')
    <div class="card card-custom">
        <form action="">
            <div class="card-header d-flex flex-row flex-wrap">
                <div class="card-title">
                    <h4 class="mb-5 font-weight-bold text-dark col-md-12">Datos del Cliente</h4>
                </div>

                <div class="col-md-12 d-flex flex-row flex-wrap">

                    <div class="col-md-4">
                        <div class="col">
                            <label class="col-form-label font-weight-bolder">Cliente:</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="ID del cliente">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col">
                            <label class="col-form-label font-weight-bolder">Dir. Casa:</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name"
                                    placeholder="Escriba la direccion de la casa">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col">
                            <label class="col-form-label font-weight-bolder">Dir. Oficina:</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name"
                                    placeholder="Escriba la direccion de la oficina">
                            </div>
                        </div>
                    </div>

                </div>

            </div>


            <div class="card-body">
                <div class="d-flex flex-row flex-wrap">
                    <div class="col-md-12 d-flex flex-row flex-wrap">
                        <div class="col-md-4">
                            <div class="col">
                                <label class="col-form-label font-weight-bolder">Movil:</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Escriba el numero de celular">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col mb-3">
                                <div class="form-group">
                                    <select name="lista" class="form-control mb-3" id="">
                                        <option value="Seleccionar Estado">Seleccionar Estado</option>
                                    </select>
                                    <select name="lista" class="form-control mb-3" id="">
                                        <option value="Seleccionar pago">Seleccionar Modo de Pago</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-15">
                            <div class="col border">
                                <label class="col-form-label font-weight-bolder">Exclusivos:</label>
                                <div class="form-group d-flex flex-row flex-wrap">
                                    <input type="radio" class="form-control radios mr-2">
                                    <label class="col-form-label mr-20">No</label>
                                    <input type="radio" class="form-control radios mr-2">
                                    <label class="col-form-label mr-20">Solamente</label>
                                    <input type="radio" class="form-control radios mr-2">
                                    <label class="col-form-label">También</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 border-right">
                        <div class="row px-12 mb-5">
                            <input type="checkbox" class="form-control radios mr-2">
                            <label class="col-form-label mr-7">Fecha Creación de Orden</label>
                            <input type="checkbox" class="form-control radios mr-2">
                            <label class="col-form-label mr-7">Fecha de Despacho</label>
                            <input type="checkbox" class="form-control radios mr-2">
                            <label class="col-form-label">Fecha Completado</label>
                        </div>
                        <div class="row px-12 mb-10">
                            <label class="col-form-label font-weight-bolder mr-2">Desde:</label>
                            <input type="date" value="2022-10-02" min="2000-01-01" class="form-control mr-7"
                                style="width: 300px">
                            <label class="col-form-label font-weight-bolder mr-2">Hasta:</label>
                            <input type="date" value="2022-10-02" min="2000-01-01" class="form-control"
                                style="width: 300px">
                        </div>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Orden</th>
                                    <th scope="col">Mensajero</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Fecha de Orden</th>
                                    <th scope="col">Fecha de despacho</th>
                                    <th scope="col">Fecha Completado</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key)
                                <tr>
                                    <th scope="row">{{$key->index + 1}}</th>
                                    <td>{{$key->order_number}}</td>
                                    {{-- {{count($key->getGuides)}} --}}
                                    <td>{{count($key->getGuides) > 0 ? $key->getGuides[0]->getRoute->getMessenger->name??'' : ''}}  {{count($key->getGuides) ? $key->getGuides[0]->getRoute->getMessenger->last_name??'' : ''}}</td>
                                    <td>{{ format_date(date('Y-n-d', strtotime($key->created_at)))}}</td>
                                    <div class="d-none">
                                        {{$value = 0}}
                                        @foreach ($key->getGuides as $item)
                                            {{$value += $item->value }}
                                        @endforeach
                                    </div>
                                    <td>${{number_format($value)}}</td>
                                    <td>{{format_date(date('Y-n-d', strtotime($key->schedule_date)))}}</td>
                                    <td>{{count($key->getGuides) > 0 ? format_date(date('Y-n-d', strtotime($key->getGuides[0]->getRoute->created_at))) : ''}}</td>
                                    <td></td>
                                    <td>{{$key->getStatusMatrix->name??''}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex flex-row flex-wrap scroll scroll-pull mb-3 border-bottom max-h-300px">
                            <h5 class="mb-5 font-weight-bold text-dark col-md-12">Información del Cliente</h5>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Nro Orden:</div>
                                <div class="line-height-xl">109-00379017</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Cliente:</div>
                                <div class="line-height-xl">Heinis Panama, S.A.</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Telefono:</div>
                                <div class="line-height-x1">838-8996</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Contacto:</div>
                                <div class="line-height-xl">Jean Paul Palomino</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Transporte:</div>
                                <div class="line-height-xl">Moto</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">Movil:</div>
                                <div class="line-height-xl">381, YEMAYEL ARIEL, M-0745</div>
                            </div>
                            <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">1: San Francisco:</div>
                                <div class="line-height-xl">San Francisco:Panama, Banco General, Cualquier Sucursal</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">2: San Francisco:</div>
                                <div class="line-height-xl">San Francisco:Panama:Caja de Seguro Social, Cualquier Sucursal
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="font-weight-bolder mb-1">3: Panamá Viejo:</div>
                                <div class="line-height-xl">Panamá:Panama, Multientrega, Entregar Comprobante</div>
                            </div>
                        </div>
                        <div class="d-flex flex-row flex-wrap align-items-center justify-content-center">
                            <div class=" row form-group">
                                <input type="text" class="form-control col-md-6" name="name" value="Canridad: 49"
                                    style="color: red">
                                <input type="text" class="form-control col-md-6" name="name" value="Total: $511.00"
                                    style="color: red">
                            </div>
                            <div class="col-md-12">
                                <a href="#" class="btn btn-light-success font-weight-bold" style="width: 100%">Aceptar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
{{-- Styles Section --}}
@section('styles')
@endsection
