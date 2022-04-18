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
                <div class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                    <a href="#" class="btn btn-primary btn-sm font-weight-bolder" data-toggle="modal"
                        data-target="#modalCreate" data-tooltip title="CREAR">
                        <span class="svg-icon svg-icon-md">
                            <i class="fas fa-plus"></i>
                        </span>Crear
                    </a>
                    {{-- <a href="#" class="btn btn-success btn-sm font-weight-bolder" data-toggle="modal"
                        data-target="#modalImport" data-tooltip title="IMPORTAR">
                        <span class="svg-icon svg-icon-md">
                            <i class="fad fa-upload"></i>
                        </span>Importar
                    </a> --}}
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<!--end: Datatable-->

@include('OrderModule.views.html.modals.createGuide')
@include('OrderModule.views.html.modals.editGuide')
@include('OrderModule.views.html.modals.importGuidesModal')
