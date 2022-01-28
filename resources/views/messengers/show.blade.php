{{-- Extends layout --}}
@extends('layouts.app')
{{-- Content --}}
@section('content')

<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h2 class="card-label h1">Ver mensajero
            </h2>
        </div>
    </div>
    <div class="card-body">
        <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
            <h5 class="mb-10 font-weight-bold text-dark">Review your Details and Submit</h5>
            <!--begin::Item-->
            <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bolder mb-3">Your Account Details:</div>
                <div class="line-height-xl">John Wick
                <br>Phone: +61412345678
                <br>Email: johnwick@reeves.com</div>
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="border-bottom mb-5 pb-5">
                <div class="font-weight-bolder mb-3">Your Address Details:</div>
                <div class="line-height-xl">Address Line 1
                <br>Address Line 2
                <br>Melbourne 3000, VIC, Australia</div>
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div>
                <div class="font-weight-bolder">Payment Details:</div>
                <div class="line-height-xl">Card Number: xxxx xxxx xxxx 1111
                <br>Card Name: John Wick
                <br>Card Expiry: 01/21</div>
            </div>
            <!--end::Item-->
        </div>
    </div>
</div>

@endsection

{{-- Styles Section --}}
@section('styles')

@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('js/pages/crud/ktdatatable/base/html-table.js') }}" type="text/javascript"></script>
@endsection
