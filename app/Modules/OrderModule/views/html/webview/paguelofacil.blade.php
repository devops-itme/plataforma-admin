<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Multientrega</title>
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('/img/favicon-2.png') }}" />

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/tooltip.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/apexcharts.js') }}"></script>
  

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

   

</head>

<body
    class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled subheader-fixed">
    <div id="app">
        <main class="d-flex flex-column flex-root" style="height: 100vh;">
            <div class="d-flex flex-row flex-column-fluid page">
                <div class="card text-center col-12">
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
                                <input type="hidden" name="total" id="total" value="{{ $response['total'] }}">
                                <input type="hidden" name="fcm_token" id="fcm_token" value="{{ $response['fcm_token'] }}">
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
                            <a href={{ $response['data']['url'] }} class="btn-block btn-lg btn-primary">Ir a pagar</a>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
