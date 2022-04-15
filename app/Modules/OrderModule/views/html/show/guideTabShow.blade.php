@include('OrderModule.views.html.modals.createAddressModal')
<!--begin: Datatable-->
<table class="table table-sm" id="guidesTable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Contacto</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Correo</th>
            <th scope="col">Fecha programada</th>
            <th scope="col">Tarifa</th>
            <th scope="col">Estado</th>
            <th scope="col">
                {{-- <div class="d-flex justify-content-end">
                    <a href="#" class="btn btn-primary btn-sm font-weight-bolder" data-toggle="modal" data-target="#modalCreate">
                        <span class="svg-icon svg-icon-md">
                            <i class="fas fa-plus"></i>
                        </span>Crear
                    </a>
                </div> --}}
            </th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <th scope="row">---</th>
                <td>---</td>
                <td>---</td>
                <td>---</td>
                <td>---</td>
                <td>---</td>
                <td>
                        <span class="label label-inline label-light-success font-weight-bold">
                            Activo
                        </span>
                        {{-- <span class="label label-inline label-light-danger font-weight-bold">
                            Inactivo
                        </span> --}}
                </td>
                <td>
                    <div
                        class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                        <a href="#" class="btn btn-icon btn-light-primary btn-sm mr-2">
                            <i class="far fa-folder-open"></i>
                        </a>
                    </div>
                </td>
            </tr>
    </tbody>
</table>
<!--end: Datatable-->
@include('OrderModule.views.html.modals.createGuide')
@include('OrderModule.views.html.modals.editGuide')
