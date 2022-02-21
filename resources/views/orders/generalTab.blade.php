<div class="d-flex flex-row flex-wrap">
    <div class="col-md-6 d-flex flex-row flex-wrap border-right">
        <h5 class="my-4 font-weight-bold text-dark col-md-12">Información general de orden</h5>
        <div class="form-group col-md-6">
            <label for="trans_type">Tipo de transporte <span class="text-danger">*</span></label>
            <select name="vehicle_type_id" class="form-control form-control-solid" id="trans_type">
                <option selected disabled>Seleccione tipo de transporte</option>
                <option value="1">Moto</option>
                <option value="2">Auto</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="pay_method">Metodo de pago <span class="text-danger">*</span></label>
            <select name="payment_method" class="form-control form-control-solid" id="pay_method">
                <option selected disabled>Seleccione Metodo de pago</option>
                <option value="1">Efectivo</option>
                <option value="2">Cheque</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Fecha de programación: <span class="text-danger">*</span></label>
            <input name="schedule_date" type="date" class="form-control form-control-solid" placeholder="" />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>Hora de programación: <span class="text-danger">*</span></label>
            <input name="schedule_time" type="time" class="form-control form-control-solid" placeholder="" />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-12 m-0 d-flex align-items-center">
            <div class="checkbox-inline">
                <label class="checkbox">
                    <input type="checkbox" name="urgent_dispatch"/>
                    <span></span>
                    Marcar Urgente Despacho
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="return_last_destination"/>
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
            <input name="insured_value" type="number" class="form-control form-control-solid" placeholder="" />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>A cobrar %: <span class="text-danger">*</span></label>
            <input name="percentage_to_collect" type="number" class="form-control form-control-solid" placeholder="" />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>A cobrar $: <span class="text-danger">*</span></label>
            <input name="money_to_collect" type="number" class="form-control form-control-solid" placeholder="" />
            <span class="form-text text-muted"></span>
        </div>
    </div>
</div>
