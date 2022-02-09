<div class="d-flex flex-row flex-wrap">
    <div class="col-md-6 d-flex flex-row flex-wrap border-right">
        <h5 class="my-4 font-weight-bold text-dark col-md-12">Información general de orden</h5>
        <div class="form-group col-md-6">
            <label for="trans_type">Tipo de transporte <span class="text-danger">*</span></label>
            <select name="trans_type" class="form-control form-control-solid" id="trans_type" disabled>
                <option>Seleccione tipo de transporte</option>
                <option selected>Moto</option>
                <option>Auto</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="pay_method">Metodo de pago <span class="text-danger">*</span></label>
            <select name="pay_method" class="form-control form-control-solid" id="pay_method" disabled>
                <option disabled>Seleccione Metodo de pago</option>
                <option selected>Efectivo</option>
                <option>Cheque</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Fecha de programación: <span class="text-danger">*</span></label>
            <input name="order_num" type="date" class="form-control form-control-solid" placeholder="" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>Hora de programación: <span class="text-danger">*</span></label>
            <input name="order_num" type="time" class="form-control form-control-solid" placeholder="" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-12 m-0 d-flex align-items-center">
            <div class="checkbox-inline">
                <label class="checkbox">
                    <input type="checkbox" name="CheckState" checked disabled/>
                    <span></span>
                    Marcar Urgente Despacho
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="CheckState" disabled/>
                    <span></span>
                    Retorno Ultimo Destino
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-6 d-flex flex-row flex-wrap">
        <h5 class="my-4 font-weight-bold text-dark col-md-12">Seguro de mercancia</h5>
        <div class="form-group col-md-6">
            <label>Valor asegurado: <span class="text-danger">*</span></label>
            <input name="save_value" type="number" class="form-control form-control-solid" value="1.00" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>A cobrar %: <span class="text-danger">*</span></label>
            <input name="collet_porcent" type="number" class="form-control form-control-solid" value="1.00" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>A cobrar $: <span class="text-danger">*</span></label>
            <input name="collet_cash" type="number" class="form-control form-control-solid" value="1.00" disabled/>
            <span class="form-text text-muted"></span>
        </div>
    </div>
</div>
