<table class="table table-sm">
    <thead>
        <tr class="text-center">
            <th scope="col">Nombres</th>
            <th scope="col">Descripción</th>
            <th scope="col">Estado</th>
            <th scope="col">
                <a href="#"
                    class="btn btn-icon btn-light-success btn-sm mr-2" data-tooltip
                    title="Crear" data-toggle="modal" data-target="#modalCrear"><i class="fad fa-plus"></i>
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($plans as $key)
            <tr class="text-center">
                <td>{{$key->name}}</td>
                <td>{{$key->description}}</td>
                <td>
                    <span class="label label-inline label-light-{{$key->state == 1 ? 'success' : 'danger'}} font-weight-bold">
                        {{$key->state == 1 ? 'Activo' : 'Inactivo'}}
                    </span>
                </td>
                <td>
                    <div class="d-flex justify-content-center aling-items-center flex-wrap flex-row">
                        {{-- <a href="#"
                            class="btn btn-icon btn-light-primary btn-sm mr-2" data-tooltip
                            title="Detalle"><i class="fad fa-folder-open"></i>
                        </a> --}}
                        <button id="{{$key->id}}" name="planEditBtn"
                            class="btn btn-icon btn-light-info btn-sm mr-2" data-tooltip title="Editar">
                            <i class="fad fa-edit" data-toggle="modal" data-target="#modalEditar"></i>
                        </button>
                        <button type="button"
                            role="button" class="btn btn-icon btn-light-danger btn-sm mr-2"
                            data-tooltip title="Eliminar"
                            onclick="confirmDelete('/planes/'+{{ $key->id }})">
                            <i class="fad fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>

        @endforeach
    </tbody>
</table>
@include('plans.modalCrear')
@include('plans.modalEditar')
