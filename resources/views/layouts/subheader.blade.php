{{-- Subheader --}}
<div class="subheader justify-content-center pt-2 pb-2" id="kt_subheader">
    <div class="d-flex align-items-center justify-content-center flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center">

            <a href="{{route('home')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Dashboard" data-placement="bottom">
                <i class="fas fa-home text-muted"></i>
            </a>

            <a href="{{route('banks.index')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Bancos" data-placement="bottom">
                <i class="fas fa-university text-muted"></i>
            </a>

            <a href="{{route('clientes.index')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Clientes" data-placement="bottom">
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

            <a href="{{route('order.index')}}" class="btn btn-light btn-hover-primary btn-sm btn-icon mr-2" data-tooltip title="Ordenes" data-placement="bottom">
                <i class="fas fa-file-edit text-muted"></i>
            </a>
        </div>
    </div>
</div>
