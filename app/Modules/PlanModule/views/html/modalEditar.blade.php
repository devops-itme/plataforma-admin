<!-- Modal-->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="post" id="formUpdate">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre del plan</label>
                        <input name="name" type="text" class="form-control form-control-solid" placeholder="Nombre" id="plan_name_edit" />
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <input name="description" type="text" class="form-control form-control-solid" placeholder="Descripción" id="plan_description_edit"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
