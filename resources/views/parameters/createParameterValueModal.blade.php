<!-- Modal -->
<div class="modal fade" id="modalCreateParameter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h4 class="card-title">Crear parametro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <form id="formCreateParameter">
                        @csrf
                        <div class="form-group">
                            <label for="">Nombre<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-solid" id="parameter_name">
                            <small id="helpId" class="text-muted">Ejemplo: Tipo de documento, tipo de
                                pago</small>
                        </div>
                        <div class="form-group">
                            <label for="">Descripcion<span class="text-danger">*</span></label>
                            <textarea required ref="description" cols="30" rows="5"
                                type="text" name="description" id="parameter_description" class="form-control form-control-solid"
                                placeholder="Ingrese Descripcion"></textarea>
                            <small id="helpId" class="text-muted">Ejemplo: Parametro para ....</small>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-end">
                            <input type="checkbox" class="parameterState" name="state" id="parameter_state_edit"/>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnStoreParameter">Guardar</button>
            </div>
        </div>
    </div>
</div>
