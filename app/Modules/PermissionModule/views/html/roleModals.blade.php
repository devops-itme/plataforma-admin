<!-- Modal Create-->
<div class="modal fade" id="createRolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRolModalTitle">Nuevo Rol</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('roles.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-10">
                            <label for=""> Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-solid"
                                placeholder="Usuario">
                        </div>
                        {{-- <div class="col-md-4">
                        <label for=""> Estado <span class="text-danger">*</span></label>
                        <select name="state" id="state" class="form-control form-control-solid">
                            <option disabled selected> Seleccione </option>
                            <option value="1"> Activo</option>
                            <option value="0"> Inactivo</option>
                        </select>
                    </div> --}}
                        <div class="col-md-2 d-flex justify-content-start align-items-center mt-7">
                            <button class="btn" data-tooltip title="Guardar"><i
                                    class="fad fa-save text-primary" style="font-size:2.3rem"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


{{-- Modal Edit --}}
<div class="modal fade" id="editRolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRolModalTitle">Editar Rol</h5>
            </div>
            <div class="modal-body">
                <form method="post" id="formUpdateRole">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <label for=""> Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name_edit" class="form-control form-control-solid"
                                placeholder="Usuario">
                        </div>
                        <div class="col-md-4">
                            <label for=""> Estado <span class="text-danger">*</span></label>
                            <select name="state" id="state_edit" class="form-control form-control-solid">
                                <option disabled> Seleccione </option>
                                <option value="1"> Activo</option>
                                <option value="0"> Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex justify-content-start align-items-center mt-7">
                            <button class="btn" data-tooltip title="Guardar"><i
                                    class="fad fa-save text-primary" style="font-size:2.3rem"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
