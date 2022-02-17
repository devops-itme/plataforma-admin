{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    @include('layouts.breadCrumbs')


    <div class="row">
        <div class="col-md-4 card-container-perfil">
            <div class="card card-round ">
                <div class="image"><img
                        src="https://png.pngtree.com/thumb_back/fw800/back_our/20190625/ourmid/pngtree-overshoot-computer-desktop-background-image_259786.jpg"
                        alt="...">
                </div>
                <div class="card-body text-center card-body-user">
                    <div class="avatar">
                        <img src="https://cietalca.cl/intranet/wp-content/themes/cera/assets/images/avatars/user-avatar.png"
                            class="mb-7" alt="">
                        <h5 class="title mb-7">Admin</h5>
                        <p class="description mb-2">
                            @ Admin
                        </p>
                    </div>
                    <p class="description mb-1">
                        Datos del Administrador
                    </p>
                    <form action="#" class="col-md-12">
                        <input type="file" name="foto" class="form-control mb-4">
                        <div class="row">
                            <div class="col-md-12"><button type="submit" class="btn btn-primary btn-round">Actualizar
                                    Foto</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 text-center">
            <form action="" class="col-md-12">

                    <div class="card mb-7 card-round">
                        <div class="card-header">
                            <h2 class="title">Editar Perfil</h2>
                        </div>
                        <div class="card-body card-round">
                            <div class="row">
                                <label class="col-md-3 col-form-label">Nombre</label>

                                <div class="form-group col-md-9">
                                    <input type="text" class="form-control" name="name" placeholder="Name"
                                        required="required">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">Email</label>

                                <div class="form-group col-md-9">
                                    <input type="email" name="email" placeholder="Email" required="required"
                                        class="form-control">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12"><button type="submit"
                                        class="btn btn-primary btn-round">Actualizar
                                        Cambios</button></div>
                            </div>
                        </div>
                    </div>

            </form>


            <form action="#" method="POST" class="col-md-12 ">
                <div class="card card-round">
                    <div class="card-header">
                        <h2 class="title">Cambiar Contraseña</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <label class="col-md-3 col-form-label">Contraseña antigua</label>
                            <div class="form-group col-md-9">
                                <input type="password" class="form-control" name="old-password"
                                    placeholder="Contraseña antigua" required="required">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Nueva contraseña</label>
                            <div class="form-group col-md-9">
                                <input type="password" class="form-control" name="password" placeholder="Contraseña"
                                    required="required">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Confirmar Contraseña</label>

                            <div class="form-group col-md-9">
                                <input type="password" name="password-confirmation" placeholder="Confirme contraseña"
                                    required="required" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center"><button type="submit"
                                    class="btn btn-primary btn-round">Actualizar Cambios</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
@endsection
