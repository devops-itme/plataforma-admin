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
                        <li><a class="dropdown-item" href="#">Planes Corporativos (Ventas)</a></li>
                        <li><a class="dropdown-item" href="#">Despachos</a></li>
                        <li><a class="dropdown-item" href="#">UDPro Driver</a></li>
                        <li><a class="dropdown-item" href="#">Mensajes Entre Usuarios</a></li>
                        <li><a class="dropdown-item" href="#">Mensajes A Móviles</a></li>
                        <li><a class="dropdown-item" href="#">Asignar Dinero A Móviles</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>


</body>

</html>










<!-- 
<div class="dropdown">
    <button type="button" class="btn btn-primary" data-toggle="dropdown">
        Dropdown button
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item dropdown-toogle" id="dropdown" role="button" data-toggle="dropdown" style="display: flex; justify-content: space-between; align-items: center;" href="#">ODS Exclusivas<i class="fas fa-angle-right"></i>

        </a>
        <a class="dropdown-item" href="#">ODS ExtraOrdinarias
        </a>
        <a class="dropdown-item" href="#">ODS Inter-Sucursal</a>
        <a class="dropdown-item" href="#">ODS Planes Corporativos (Ventas)</a>
        <a class="dropdown-item" href="#">ODS Planes Corporativos (Ventas)</a>
        <a class="dropdown-item" href="#">Despachos</a>
        <a class="dropdown-item" href="#">UDPro Driver</a>
        <a class="dropdown-item" href="#">Mensajes Entre Usuarios</a>
        <a class="dropdown-item" href="#">Mensajes a Móviles</a>
        <a class="dropdown-item" href="#">Asignar Dinero A Móviles</a>
        <a class="dropdown-item" href="#">Asignar Dinero A Móviles</a>

    </div>
</div> -->

<!-- <div class="dropdown" style="position:relative">
    <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Click Aquí <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li>
            <a class="trigger right-caret">Level 1</a>
            <ul class="dropdown-menu sub-menu">
                <li><a href="#">Level 2</a></li>
                <li>
                    <a class="trigger right-caret">Level 2</a>
                    <ul class="dropdown-menu sub-menu">
                        <li><a href="#">Level 3</a></li>
                        <li><a href="#">Level 3</a></li>
                        <li>
                            <a class="trigger right-caret">Level 3</a>
                            <ul class="dropdown-menu sub-menu">
                                <li><a href="#">Level 4</a></li>
                                <li><a href="#">Level 4</a></li>
                                <li><a href="#">Level 4</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#">Level 2</a></li>
            </ul>
        </li>
        <li><a href="#">Level 1</a></li>
        <li><a href="#">Level 1</a></li>
    </ul>
</div> -->