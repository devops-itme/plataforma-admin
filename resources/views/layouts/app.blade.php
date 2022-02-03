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
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9MFKCZ2zM_6wtlJCiaSdalzbubH_tKFk&libraries=places">
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{asset('js/tooltip.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/alert.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{asset('js/apexcharts.js')}}"></script>
    {{-- <script src="{{asset('js/uikit.min.js')}}"></script>
    <script src="{{asset('js/uikit-icons.min.js')}}"></script> --}}


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/duotone.css" integrity="sha384-R3QzTxyukP03CMqKFe0ssp5wUvBPEyy9ZspCB+Y01fEjhMwcXixTyeot+S40+AjZ" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/tooltip.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('css/uikit.min.css')}}"> --}}
</head>
<body class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled subheader-fixed">
    <div id="app">
        <main class="d-flex flex-column flex-root" style="height: 100vh;">
            <div class="d-flex flex-row flex-column-fluid page">
                <div class="@guest d-flex flex-column flex-row-fluid @else d-flex flex-column flex-row-fluid wrapper  @endguest" id="kt_wrapper">
                    @guest
                        <div class="d-flex flex-column flex-column-fluid" id="kt_content">
                            <div>
                                @yield('content')
                            </div>
                        </div>
                    @else
                        @include('layouts.header')

                        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                            @include('layouts.subheader')
                            <div class="p-5">
                                @yield('content')
                            </div>
                        </div>
                        @include('layouts.footer')
                    @endguest
                </div>
            </div>
        </main>
    </div>
</body>
</html>
