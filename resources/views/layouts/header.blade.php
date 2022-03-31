{{-- Header --}}
<div id="kt_header" class="header header-fixed ">

    {{-- Container --}}
    <div class="container-fluid d-flex align-items-center justify-content-between">

        {{-- Header Menu --}}
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div class="header-logo">
                <a href="#">
                    <img alt="Logo" style="object-fit: contain; width: 160px;"
                        src="{{ asset('img/logoME-03.png') }}" />
                </a>
            </div>
        </div>

        <div class="dropdown ml-auto ">
                <a class="btn dropdown-toggle px-0 mr-3" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-bell text-white"></i>
                    <span class="badge rounded-pill text-white bg-danger position-absolute top-0">1</span>
                </a>

                <div class="dropdown-menu dropdown-menu-width mr-37" aria-labelledby="dropdownMenuLink">
                    <div class="col-sm-12 scroll scroll-pull max-h-300px">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Notificacion 1</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional
                                    content.</p>
                                <a href="#" class="btn btn-primary d-block">Ver detalle</a>
                                <div class="separator separator-dashed separator-border-2 col-md-12 my-4"></div>
                                <h5 class="card-title">Notificacion 2</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional
                                    content.</p>
                                <a href="#" class="btn btn-primary d-block">Ver detalle</a>
                                <div class="separator separator-dashed separator-border-2 col-md-12 my-4"></div>
                                <h5 class="card-title">Notificacion 3</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional
                                    content.</p>
                                <a href="#" class="btn btn-primary d-block">Ver detalle</a>
                            </div>
                            <div class="card-footer text-muted text-center py-0 cursor-pointer">
                                <a href="#" class="text-dark col-md-12">Ver todo</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="btn-group">
            <a href="perfil" class="btn btn-primary">{{ Auth::user()->getRole->name }}</a>
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right" style="z-index: 1">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    <div>
                        <p class="mb-0">Cerrar Sesión</p>
                    </div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
