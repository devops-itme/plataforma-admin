{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
{{-- Extends layout --}}
@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-root" style="height: 100vh;">
        <!--begin::Login-->
        <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
            <!--begin::Aside-->
            <div
                class="login-aside order-2 col-4 order-lg-1 d-flex flex-column-fluid flex-lg-row-auto bgi-size-cover bgi-no-repeat p-7 p-lg-10">
                <!--begin: Aside Container-->
                <div class="d-flex flex-row-fluid flex-column justify-content-between">
                    <!--begin::Aside body-->
                    <div class="d-flex flex-column-fluid flex-column flex-center mt-5 mt-lg-0">

                        <!--begin::Signin-->
                        <div class="login-form login-signin col-12 d-flex flex-column justify-content-center">
                            <a href="#" class="mb-15 text-center">
                                <img src="{{ asset('/img/logoME-02.png') }}" class="max-h-50px" alt="" />
                            </a>
                            <div class="text-center mb-10 mb-lg-20">
                                <h2 class="font-weight-bold">Login</h2>
                                <p class="text-muted font-weight-bold">Escribe tu usuario y contraseña</p>
                            </div>
                            <!--begin::Form-->
                            <form class="form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group py-3 m-0">
                                    <input id="email" type="email"
                                        class="form-control h-auto border-0 px-0 placeholder-dark-75 @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Correo">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group py-3 border-top m-0">
                                    <input id="password" type="password"
                                        class="form-control h-auto border-0 px-0 placeholder-dark-75 @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password" placeholder="Contraseña">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- @if (Route::has('password.request'))
                                    <div
                                        class="form-group d-flex flex-wrap justify-content-between align-items-center mt-3">
                                        <a href="{{ route('password.request') }}"
                                            class="text-muted text-hover-primary">Olvide mi contraseña</a>
                                    </div>
                                @endif --}}
                                <div
                                    class="form-group d-flex flex-wrap flex-column justify-content-between align-items-center mt-2">
                                    {{-- <div class="my-3 mr-2">
                                        <span class="text-muted mr-2">No tienes cuenta?</span>
                                        <a href="#" class="font-weight-bold">Registrate</a>
                                    </div> --}}
                                    <button type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">
                                        {{ __('Login') }}
                                    </button>


                                </div>
                            </form>
                            <!--end::Form-->
                        </div>

                    </div>
                    <!--end::Aside body-->
                    <!--begin: Aside footer for desktop-->
                    <div class="d-flex flex-column-auto justify-content-between mt-10">
                        @include('layouts.footer')
                    </div>
                    <!--end: Aside footer for desktop-->
                </div>
                <!--end: Aside Container-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="order-1 order-lg-2 flex-column-auto flex-lg-row-fluid d-flex flex-column p-7"
                style="background-image: url({{ './img/BANNERS-INTERMEDIOS-WEB-MULTIENTREGA-06.jpg' }}); background-repeat: no-repeat; background-size: cover; background-position-x: center;">
                <!--begin::Content body-->
                <div class="d-flex flex-column-fluid flex-lg-center">
                    <div class="d-flex flex-column justify-content-center">
                        <h3 class="display-3 font-weight-bold my-7 text-white">Bienvenido a Multientrega!</h3>
                        <p class="font-weight-bold font-size-lg text-white opacity-80">Plataforma Administrativa.</p>
                    </div>
                </div>
                <!--end::Content body-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
@endsection
