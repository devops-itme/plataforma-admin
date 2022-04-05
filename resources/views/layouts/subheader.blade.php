{{-- Subheader --}}
{{-- <div class="subheader justify-content-center pt-2 pb-2" id="kt_subheader">
    <div class="d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center">

            <a href="{{ route('home') }}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip
                title="Dashboard" data-placement="bottom">
                <i class="fas fa-home text-muted"></i>
            </a>

            <a href="{{ route('customers.index') }}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2"
                data-tooltip title="Clientes" data-placement="bottom">
                <i class="fas fa-users text-muted"></i>
            </a>

            <a href="{{ route('messengers.index') }}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2"
                data-tooltip title="Mensajeros" data-placement="bottom">
                <i class="fas fa-people-carry text-muted"></i>
            </a>

            <a href="{{ route('users.index') }}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2"
                data-tooltip title="Usuarios" data-placement="bottom">
                <i class="fas fa-users-cog text-muted"></i>
            </a>

            <a href="#" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Operadores"
                data-placement="bottom">
                <i class="fas fa-user-tie text-muted"></i>
            </a>

            <a href="{{ route('orders.index') }}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2"
                data-tooltip title="Ordenes" data-placement="bottom">
                <i class="fas fa-file-edit text-muted"></i>
            </a>

            <a href="{{ route('permits.index') }}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2"
                data-tooltip title="permisos" data-placement="bottom">
                <i class="fas fa-shield text-muted"></i>
            </a>
            <a href="{{ route('delivery.index') }}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2"
                data-tooltip title="Despachos" data-placement="bottom">
                <i class="fad fa-person-dolly"></i>
            </a>
            <a href="{{ route('deliveryPacking.index') }}"
                class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Despachos Packing"
                data-placement="bottom">
                <i class="fad fa-hand-holding-box"></i>
            </a>
            <a href="{{ route('zone.index') }}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2"
                data-tooltip title="Zonas" data-placement="bottom">
                <i class="fad fa-map-marked-alt"></i>
            </a>
        </div>

    </div>

</div> --}}

<div class="subheader justify-content-center pt-2 pb-2" id="kt_subheader">
    <div class="d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center">
            <nav class="navbar navbar-expand-lg navbar-light ">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item dropdown">
                            <a class="nav-link " href="{{ route('home') }}" id="navbarDropdownMenuLink"
                                role="button" aria-expanded="false"><i class="fas fa-home"></i> Inicio</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link " href="#" id="navbarDropdownMenuLink" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-tools"></i> Operaciones
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="">ODS Orden de Servicio<i
                                            class="fas fa-angle-right"></i></a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" href="{{ route('orders.index') }}">Ordenes de
                                                Servicio</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Clonar/Replicar</a></li>
                                        <li><a class="dropdown-item" href="#">Importar de Excel</a></li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="#">ODS Inter-Sucursal</a></li>
                                <li><a class="dropdown-item" href="#">ODS Planes Corporativos (Ventas)</a></li>
                                <li class="dropdown-submenu subdespacho ">
                                    <a class="dropdown-item" href="#">Despacho<i class="fas fa-angle-right"></i></a>
                                    <ul class="dropdown-menu menudespacho" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item"
                                                href="{{ route('delivery.index') }}">Despachos</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('deliveryPacking.index') }}">Despachos
                                                Packing</a></li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="#">UDPro Driver</a></li>
                                <li><a class="dropdown-item" href="{{ route('messengers.index') }}">Mensajes Entre
                                        Usuarios</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('messengers.index') }}">Mensajes A
                                        Móviles</a></li>
                                <li><a class="dropdown-item" href="#">Asignar Dinero A Móviles</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link " href="#" id="navbarDropdownMenuLink" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="far fa-info-circle"></i> Información
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Mi perfil</a></li>
                                <li><a class="dropdown-item" href="{{ route('users.index') }}">Usuarios</a></li>
                                <li><a class="dropdown-item" href="{{ route('customers.index') }}">Clientes (Web)</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('messengers.index') }}">Mensajeros</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('plans.index') }}">Planes</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link " href="#" id="navbarDropdownMenuLink" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-invoice"></i> Facturación</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="">Liquidación Ondemand Clientes</a></li>
                                <li><a class="dropdown-item" href="#">Liquidación Packs Clientes</a></li>
                                <li><a class="dropdown-item" href="#">Facturas de Móviles</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link " href="#" id="navbarDropdownMenuLink" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-money-check-edit-alt"></i> Nómina</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Conceptos</a></li>
                                <li><a class="dropdown-item" href="#">Moviles Periodos</a></li>
                                <li><a class="dropdown-item" href="#">Moviles Conceptos Parámetros</a></li>
                                <li><a class="dropdown-item" href="#">Colaboradores Cargos</a></li>
                                <li><a class="dropdown-item" href="#">Colaboradores</a></li>
                                <li><a class="dropdown-item" href="#">Colaboradores Periodos</a></li>
                                <li class="dropdown-submenu subcolaboradores">
                                    <a class="dropdown-item" href="">Colaboradores Prestamos<i
                                            class="fas fa-angle-right"></i></a>
                                    <ul class="dropdown-menu menucolaboradores"
                                        aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" href="#">Prestamos</a></li>
                                        <li><a class="dropdown-item" href="#">Pagos</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu submoviles">
                                    <a class="dropdown-item" href="">Móviles Liquidaciones<i
                                            class="fas fa-angle-right"></i></a>
                                    <ul class="dropdown-menu menumoviles" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" href="#">Prestamos</a></li>
                                        <li><a class="dropdown-item" href="#">Pagos</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu subMovPagos">
                                    <a class="dropdown-item" href="">Móviles Pagos<i
                                            class="fas fa-angle-right"></i></a>
                                    <ul class="dropdown-menu menuMovPagos" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" href="#">Prestamos</a></li>
                                        <li><a class="dropdown-item" href="#">Pagos</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu subMovPagos">
                                    <a class="dropdown-item" href="">Móviles Pagos<i
                                            class="fas fa-angle-right"></i></a>
                                    <ul class="dropdown-menu menuMovPagos" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" href="#">Prestamos</a></li>
                                        <li><a class="dropdown-item" href="#">Pagos</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link " href="{{ route('home') }}" id="navbarDropdownMenuLink"
                                role="button" data-toggle="dropdown" aria-expanded="false"><i
                                    class="fas fa-shield"></i> Administración</a>
                            <ul class="dropdown-menu menuMovPagos" aria-labelledby="navbarDropdownMenuLink">
                                @if (Auth::user()->id == 1)
                                    <li><a class="dropdown-item" href="{{ route('permits.index') }}">Permisos</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('log.index') }}">Log de usuario</a>
                                    </li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('statusMatrix.index') }}">Matriz de
                                        estados</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link " href="#" id="navbarDropdownMenuLink" role="button"
                                data-toggle="dropdown" aria-expanded="false"><i class="fas fa-globe"></i> Configuraciones</a>
                            <ul class="dropdown-menu menuMovPagos" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('zone.index') }}">Zonas</a></li>
                                <li><a class="dropdown-item" href="{{ route('parameters.index') }}">Parametros</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('hours.index') }}">Horas</a></li>
                                <li><a class="dropdown-item" href="{{ route('tarifario.index') }}">Tarifario</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
