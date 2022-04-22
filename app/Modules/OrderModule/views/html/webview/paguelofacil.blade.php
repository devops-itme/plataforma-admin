<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Multientrega</title>
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('/img/favicon-2.png') }}" />

    <!-- Scripts -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9MFKCZ2zM_6wtlJCiaSdalzbubH_tKFk&libraries=places"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/tooltip.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/apexcharts.js') }}"></script>
    <script src="{{ asset('js/selectBranchOffice.js') }}"></script>


    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/duotone.css"
        integrity="sha384-R3QzTxyukP03CMqKFe0ssp5wUvBPEyy9ZspCB+Y01fEjhMwcXixTyeot+S40+AjZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css"
        integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tooltip.css') }}">

    {{-- <style>
        .card {
            box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 500px;
        }

        .card .text {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card .text img {
            height: 170px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .card .text h3 {
            font-size: 40px;
            font-weight: 400;
        }

        .card .text p:nth-of-type(1) {
            color: rgb(35, 182, 219);
            font-size: 15px;
            margin-top: -5px;
        }

        .card .text p:nth-of-type(2) {
            margin: 10px;
            width: 90%;
            text-align: center;
        }

        .card .links {
            width: 30%;
            display: flex;
            justify-content: space-evenly;
        }

        .card .links i {
            color: rgb(35, 182, 219);
            font-size: 20px;
            cursor: pointer;
        }

        .card .links i:hover {
            color: rgb(29, 157, 189);
        }

    </style> --}}


</head>

<body
    class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled subheader-fixed">
    <div id="app">
        <main class="d-flex flex-column flex-root" style="height: 100vh;">
            <div class="d-flex flex-row flex-column-fluid page">
                <div class="card text-center">
                    <div class="card-header text-uppercase font-weight-bold h1">
                        Detalle de la orden
                    </div>

                    <div class="card-body">
                        @if (!is_null($response ?? null))
                            @if (!is_null($total ?? null))
                                <h5 class="card-title">Total a pagar: US${{ $total }}</h5>
                            @endif
                            @if (!is_null($response['Estado'] ?? null))
                                <h5 class="card-title">Transferencia {{ $response['Estado'] }}</h5>

                                <input type="hidden" name="state" id="state" value="{{ $response['Estado'] }}">
                                <input type="hidden" name="notification_type" id="notification_type"
                                    value="payment_notification">
                            @endif
                            @if (!is_null($response['Fecha'] ?? null) && !is_null($response['Hora'] ?? null))
                                <p class="card-text">{{ $response['Fecha'] }} - {{ $response['Hora'] }}</p>
                            @endif
                        @endif
                        <img src="{{ asset('/img/logoME-02.png') }}" width="300px">

                    </div>
                    <div class="card-footer">
                        @if (!is_null($response['Estado'] ?? null))
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        @endif
                        @if (!is_null($response['data']['url'] ?? null))
                            <a href={{ $response['data']['url'] }} class="btn btn-primary">Ir a pagar</a>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
