<div class="modal fade" id="modalDestino" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Detalle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times h5"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="address_name">Dirección destino <span class="text-danger">*</span></label>
                    <input name="address_name" id="address_name" type="text" class="form-control form-control-solid" disabled/>
                    </div>


                    {{-- <div class="form-group col-md-3">
                        <label for="district">Tarifa <span class="text-danger">*</span></label>
                        <input name="rate" id="rate" type="text" class="form-control form-control-solid" disabled/>
                        
                    </div> --}}

                    <div class="form-group col-md-3">
                        <label>Valor: <span class="text-danger">*</span></label>
                        <input name="value" id="value" type="number" class="form-control form-control-solid" disabled
                            disabled />
                        <span class="form-text text-muted"></span>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Valor Corp: <span class="text-danger">*</span></label>
                        <input name="corp_value" id="corp_value" type="number" class="form-control form-control-solid"
                            disabled />
                        <span class="form-text text-muted"></span>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Contacto: <span class="text-danger">*</span></label>
                        <input name="contact" id="contact" type="text" class="form-control form-control-solid"
                            disabled />
                        <span class="form-text text-muted"></span>
                    </div>

                    <div class="form-group col-md-3 pt-2">
                        <label>Teléfono contacto </label>
                        <input name="phone_contact" type="tel" id="phone_contact"
                            class="form-control form-control-solid" disabled />
                        <span class="form-text text-muted"></span>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Contacto Email: </label>
                        <input name="email_contact" id="email_contact" type="email"
                            class="form-control form-control-solid" disabled />
                        <span class="form-text text-muted"></span>
                    </div>

                    <div class="form-group col-md-3 d-flex align-items-center">
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" disabled name="same_day_delivery" id="same_day_delivery" />
                                <span></span>
                                Some Day Delivery
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" disabled name="sign" id="sign" />
                                <span></span>
                                Firmar
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" disabled name="take_photo" id="take_photo" />
                                <span></span>
                                Tomar Foto
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="description">Descripción <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" cols="10" disabled rows="2" class="form-control form-control-solid"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                        data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
