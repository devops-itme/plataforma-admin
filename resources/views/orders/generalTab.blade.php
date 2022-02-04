<div class="d-flex flex-row flex-wrap">
    <h5 class="my-4 font-weight-bold text-dark col-md-12">Información general de orden</h5>
    <div class="form-group col-md-3">
        <label for="trans_type">Tipo de transporte <span class="text-danger">*</span></label>
        <select name="trans_type" class="form-control form-control-solid" id="trans_type">
            <option selected disabled>Seleccione tipo de transporte</option>
            <option>Moto</option>
            <option>Auto</option>
        </select>
    </div>
    <div class="form-group col-md-2">
        <label>Fecha de programación: <span class="text-danger">*</span></label>
        <input name="order_num" type="date" class="form-control form-control-solid"
            placeholder="" />
        <span class="form-text text-muted"></span>
    </div>
    <div class="form-group col-md-2">
        <label>Hora de programación: <span class="text-danger">*</span></label>
        <input name="order_num" type="time" class="form-control form-control-solid"
            placeholder="" />
        <span class="form-text text-muted"></span>
    </div>
    <div class="form-group col-md-3">
        <label for="pay_method">Metodo de pago <span class="text-danger">*</span></label>
        <select name="pay_method" class="form-control form-control-solid" id="pay_method">
            <option selected disabled>Seleccione Metodo de pago</option>
            <option>Efectivo</option>
            <option>Cheque</option>
        </select>
    </div>
</div>
