<div class="d-flex flex-row flex-wrap">
    <div class="col-md-6 d-flex flex-row flex-wrap border-right">
        <h5 class="my-4 font-weight-bold text-dark col-md-12">Información general de orden</h5>
        <div class="form-group col-md-6">
            <label for="trans_type">Tipo de transporte <span class="text-danger">*</span></label>
            <select name="vehicle_type_id" class="form-control form-control-solid" id="trans_type">
                <option selected disabled value="">Seleccione tipo de transporte</option>
                @foreach ($transport_type as $item)
                    <option value="{{ $item->id }}" {{ $item->id == old('trans_type') ? 'selected' : '' }} >{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="pay_method">Metodo de pago <span class="text-danger">*</span></label>
            <select name="payment_method" class="form-control form-control-solid" id="pay_method">
                <option selected disabled>Seleccione Metodo de pago</option>
                @foreach ($payment_method as $item)
                    <option value="{{ $item->id }}" {{ $item->id == old('pay_method') ? 'selected' : '' }} >{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Fecha de programación: <span class="text-danger">*</span></label>
            <input name="schedule_date" id="schedule_date" type="date" class="form-control form-control-solid" placeholder="" />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>Hora de programación: <span class="text-danger">*</span></label>
            <select name="schedule_time_range" class="form-control form-control-solid" id="schedule_time_range">
                <option disabled selected>Seleccione </option>
            </select>
            <span class="form-text text-muted"></span>
        </div>
        <input type="hidden" name="schedule_time" id="schedule_time">
        <div class="form-group col-md-6">
            <label for="address">Dirección origen <span class="text-danger">*</span></label>
            <select name="customer_address" class="form-control form-control-solid" id="address">
                <option disabled selected value="">Seleccione </option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="description">Descripción <span class="text-danger">*</span></label>
            <textarea name="description_order" cols="10" rows="2" class="form-control form-control-solid"></textarea>
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
            <label>Valor asegurado: </label>
            <input name="insured_value" type="number" class="form-control form-control-solid" placeholder="" />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>A cobrar %: </label>
            <input name="percentage_to_collect" type="number" class="form-control form-control-solid" placeholder="" />
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>A cobrar $: </label>
            <input name="money_to_collect" type="number" class="form-control form-control-solid" placeholder="" />
            <span class="form-text text-muted"></span>
        </div>
    </div>
</div>
