<div class="modal fade" id="modalCreateUser" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Crear Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times h5"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-row flex-wrap">
                    <div class="col-md-4">
                        <label for=""> Nombres <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="user_name" class="form-control form-control-solid" placeholder="Jack Steven">
                    </div>
                    <div class="col-md-4">
                        <label for=""> Apellidos <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" id="user_last_name" class="form-control form-control-solid" placeholder="Morris Smith">
                    </div>
                    <div class="col-md-4">
                        <label for=""> Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" id="user_email" class="form-control form-control-solid" placeholder="jackmsmith@example.com">
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for=""> Teléfono <span class="text-danger">*</span></label>
                            <input type="phone" name="phone" id="user_phone" class="form-control form-control-solid" placeholder="+1 (246) 207-8182">
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for=""> Contraseña </label>
                            <input type="password" name="pasword" id="user_password" class="form-control form-control-solid" placeholder="************">
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for=""> Confirmar contraseña </label>
                            <input type="password" name="password_confirm" id="user_password_confirm" class="form-control form-control-solid" placeholder="************">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveUser">Guardar</button>
            </div>
        </div>
    </div>
</div>
