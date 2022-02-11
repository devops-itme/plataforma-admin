{{-- Subheader --}}
<div class="subheader justify-content-center pt-2 pb-2" id="kt_subheader">
    <div class="d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center">

            <a href="{{route('home')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Dashboard" data-placement="bottom">
                <i class="fas fa-home text-muted"></i>
            </a>

            <a href="{{route('customers.index')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Clientes" data-placement="bottom">
                <i class="fas fa-users text-muted"></i>
            </a>

            <a href="{{route('messengers.index')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Mensajeros" data-placement="bottom">
                <i class="fas fa-people-carry text-muted"></i>
            </a>

            <a href="{{route('users.index')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Usuarios" data-placement="bottom">
                <i class="fas fa-users-cog text-muted"></i>
            </a>

            <a href="#" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Operadores" data-placement="bottom">
                <i class="fas fa-user-tie text-muted"></i>
            </a>

            <a href="{{route('orders.index')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Ordenes" data-placement="bottom">
                <i class="fas fa-file-edit text-muted"></i>
            </a>

            <a href="{{route('permits.index')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="permisos" data-placement="bottom">
                <i class="fas fa-shield text-muted"></i>
            </a>
        </div>

    </div>

</div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylenav.css">
    <title>Document</title>
    <style>
        .navbar-nav li:hover>ul.dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            position: relative
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
        }

        .subcolaboradores>.menucolaboradores {
            top: 65%;
            left: 100%;
        }

        .submoviles>.menumoviles {
            top: 75%;
            left: 100%;
        }

        .subMovPagos>.menuMovPagos {
            top: 85%;
            left: 100%;
        }

        .dropdown-item {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-40">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">


                <li class="nav-item dropdown">
                    <a class="nav-link " href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
                        Operaciones
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li class="dropdown-submenu">
                            <a class="dropdown-item" href="">ODS ExtraOrdinarias <i class="fas fa-angle-right"></i></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Ordenes de Servicio</a></li>
                                <li><a class="dropdown-item" href="#">Clonar/Replicar</a></li>
                                <li><a class="dropdown-item" href="#">Importar de Excel</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#">ODS Inter-Sucursal</a></li>
                        <li><a class="dropdown-item" href="#">ODS Planes Corporativos (Ventas)</a></li>
                        <li><a class="dropdown-item" href="#">Despachos</a></li>
                        <li><a class="dropdown-item" href="#">UDPro Driver</a></li>
                        <li><a class="dropdown-item" href="#">Mensajes Entre Usuarios</a></li>
                        <li><a class="dropdown-item" href="#">Mensajes A Móviles</a></li>
                        <li><a class="dropdown-item" href="#">Asignar Dinero A Móviles</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link " href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
                        Información
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="">Mi perfil</a></li>
                        <li><a class="dropdown-item" href="#">Clientes (Web)</a></li>
                        <li><a class="dropdown-item" href="#">Móviles</a></li>
                        <li><a class="dropdown-item" href="#">Planes</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link " href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
                        Facturación </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="">Liquidación Ondemand Clientes</a></li>
                        <li><a class="dropdown-item" href="#">Liquidación Packs Clientes</a></li>
                        <li><a class="dropdown-item" href="#">Facturas de Móviles</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link " href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
                        Nómina</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Conceptos</a></li>
                        <li><a class="dropdown-item" href="#">Moviles Periodos</a></li>
                        <li><a class="dropdown-item" href="#">Moviles Conceptos Parámetros</a></li>
                        <li><a class="dropdown-item" href="#">Colaboradores Cargos</a></li>
                        <li><a class="dropdown-item" href="#">Colaboradores</a></li>
                        <li><a class="dropdown-item" href="#">Colaboradores Periodos</a></li>
                        <li class="dropdown-submenu subcolaboradores">
                            <a class="dropdown-item" href="">Colaboradores Prestamos<i class="fas fa-angle-right"></i></a>
                            <ul class="dropdown-menu menucolaboradores" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Prestamos</a></li>
                                <li><a class="dropdown-item" href="#">Pagos</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu submoviles">
                            <a class="dropdown-item" href="">Móviles Liquidaciones<i class="fas fa-angle-right"></i></a>
                            <ul class="dropdown-menu menumoviles" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Prestamos</a></li>
                                <li><a class="dropdown-item" href="#">Pagos</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu subMovPagos">
                            <a class="dropdown-item" href="">Móviles Pagos<i class="fas fa-angle-right"></i></a>
                            <ul class="dropdown-menu menuMovPagos" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Prestamos</a></li>
                                <li><a class="dropdown-item" href="#">Pagos</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>