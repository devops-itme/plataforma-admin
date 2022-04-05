{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')

    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Tarifario
            </h3>
        </div>

        <form action="" method="">

            <div class="card-body d-flex flex-row flex-wrap">

                <div class="form-group col-md-4">
                    <label>Tipo de paquete:</label>
                    <select class="form-control form-control-solid" id="" name="" required>
                        <option selected disabled>Seleccione</option>
                        <option>Paquete chileno</option>
                        <option>Paquete no chileno </option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Zona:</label>
                    <select class="form-control form-control-solid" name="" required>
                        <option selected disabled>Seleccione</option>
                        <option>Norte</option>
                        <option>Sur</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Tiempo estimado:</label>
                    <input type="text" class="form-control form-control-solid" placeholder="Estime el tiempo" name=""
                        value="" />
                </div>

                <div class="form-group col-md-3 py-3">
                    <label>Libra adicional por peso:</label>
                    <input type="number" class="form-control form-control-solid" placeholder="Cantidad de Libra adicional"
                        name="" value="" />
                </div>

                <div class="form-group col-md-3 py-3">
                    <label>Libra adicional por tamaño(Vol.)</label>
                    <input type="number" class="form-control form-control-solid"
                        placeholder="Cantidad de Libra adicional x Tamaño" name="" value="" />
                </div>

                <div class="form-group col-md-3 py-3">
                    <label>% Por entrega inmediata</label>
                    <input type="number" class="form-control form-control-solid" placeholder="Porcentaje x entrega" name=""
                        value="" />
                </div>

                <div class="form-group col-md-3 py-3 mt-10">
                    <label class="checkbox">
                        <input type="checkbox" name="return_last_destination" />
                        <span class="mr-2"></span>Tarifa especial
                    </label>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                <button type="reset" class="btn btn-secondary">Limpiar</button>
            </div>
        </form>
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
