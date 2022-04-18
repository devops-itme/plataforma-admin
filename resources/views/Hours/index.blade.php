@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')
    <div class="content" id="app">
        <div class="row">
            <div class="col-md-7">
                @include('layouts.alerts')
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title"> Días </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        Día
                                    </th>
                                    <th>
                                        Hora desde
                                    </th>
                                    <th>
                                        Hora hasta
                                    </th>
                                    <th>
                                        Opciones
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($pickupdays as $day)
                                    <tr>
                                        <td>{{__($day->getDay->name)}}</td>
                                        <td>{{format_hour($day->init_time)}}</td>
                                        <td>
                                            {{format_hour($day->end_time)}}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                                                <button name="editHour" class="btn btn-icon btn-light-success btn-sm mr-2"
                                                    data-tooltip title="Editar"
                                                    data-toggle="modal" data-target="#editHour" id="{{$day->id}}">
                                                    <i class="fad fa-edit"></i>
                                                </button>
                                                <button type="button" onclick="confirmDelete('/horas/'+{{ $day->id }})"
                                                    class="btn btn-icon btn-light-danger btn-sm mr-2" data-tooltip title="Eliminar">
                                                    <i class="fad fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            {{-- <button type="button" class="btn btn-primary btn-rd" name="btnShowParameters" id="{{$parameter->id}}">
                                                <i class="fad fa-eye" style="padding:0px;"></i>
                                            </button> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col">
                                <h4 class="card-title"> Registrar hora </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('hours.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for=""> Día <span class="text-danger">*</span></label>
                                    <select name="day" class="form-control form-control-solid">
                                        <option value="" selected disabled> Seleccione </option>
                                        @foreach ($days as $item)
                                            <option value="{{$item->id}}"> {{$item->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for=""> Desde <span class="text-danger">*</span></label>
                                    <input type="time" name="from" class="form-control form-control-solid">
                                </div>
                                <div class="col-md-4">
                                    <label for=""> Hasta <span class="text-danger">*</span></label>
                                    <input type="time" name="to" class="form-control form-control-solid">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12 d-flex justify-content-end align-items-center">
                                    <button class="btn btn-success"> Registrar </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Hours.editHourModal')
@endsection
