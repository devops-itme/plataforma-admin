{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')


<div class="card card-custom gutter-b">
    <div class="card-header card-header-tabs-line">
        <div class="card-title">
            <h3 class="card-label">Despachos</h3>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#pordespachar">Por despachar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#despachados">Despachados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#completados">Completados</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-body px-5">
        <div class="d-flex flex-row flex-wrap">
            <div class="col-md-8 border-right">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pordespachar" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                        @include('deliveries.byShipment.shipmentIndex')
                    </div>
                    <div class="tab-pane fade" id="despachados" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                        2
                    </div>
                    <div class="tab-pane fade" id="completados" role="tabpanel" aria-labelledby="kt_tab_pane_3">
                        3
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h5>asdasd</h5>
            </div>
        </div>
    </div>
</div>


@endsection
