<!--begin: Datatable-->
<table class="table table-sm">
    <thead>
        <tr>
            <th scope="col">Nombres</th>
            <th scope="col">Numero de documento</th>
            <th scope="col">Correo</th>
            <th scope="col">Telefono</th>
            <th scope="col">Estado</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <th scope="row">---</th>
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
                        <a href="#"
                            class="btn btn-icon btn-light-success btn-sm mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#"
                            role="button"
                            class="btn btn-icon btn-light-danger btn-sm mr-2">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </td>
            </tr>
    </tbody>
</table>
<!--end: Datatable-->
