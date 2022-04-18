<div class="d-flex flex-row flex-wrap">
    <div class="col-md-6 d-flex flex-row flex-wrap border-right">
        <h5 class="my-4 font-weight-bold text-dark col-md-12">Información general de orden</h5>
        <div class="form-group col-md-6">
            <label for="trans_type">Tipo de transporte <span class="text-danger">*</span></label>
            <select name="trans_type" class="form-control form-control-solid" id="trans_type" disabled>
                <option>Seleccione tipo de transporte</option>
                @foreach ($transport_type as $item)
                <option value="{{ $item->id }}" {{$order->vehicle_type_id == $item->id ? 'selected' : ''}} >{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="pay_method">Metodo de pago <span class="text-danger">*</span></label>
            <select name="pay_method" class="form-control form-control-solid" id="pay_method" disabled>
                <option disabled>Seleccione Metodo de pago</option>
                <option {{$order->payment_method_id == 1 ? 'selected' : ''}}>Efectivo</option>
                <option {{$order->payment_method_id == 2 ? 'selected' : ''}}>Cheque</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Fecha de programación: <span class="text-danger">*</span></label>
            <input name="order_num" type="date" class="form-control form-control-solid" placeholder="" value="{{$order->schedule_date}}" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>Hora de programación: <span class="text-danger">*</span></label>
            <select name="schedule_time_range" class="form-control form-control-solid" id="schedule_time_range" disabled>
                <option>Seleccione </option>
                <option selected value="{{$order->schedule_time_range}}">{{$order->schedule_time_range}}</option>
            </select>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label for="address">Dirección origen <span class="text-danger">*</span></label>
            <select name="cus_add_show" class="form-control form-control-solid" id="address" disabled>
                <option disabled selected>Seleccione </option>
                @foreach ($customer_addresses as $address)
                    <option value="{{$address->id}}" {{$address->id == $order->address_id ? 'selected' : ''}}> {{$address->name}} </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="description">Descripción <span class="text-danger">*</span></label>
            <textarea name="description_order" cols="10" rows="2" class="form-control form-control-solid">{{$order->description}}</textarea>
        </div>
        <div class="form-group col-md-12 m-0 d-flex align-items-center">
            <div class="checkbox-inline">
                <label class="checkbox">
                    <input type="checkbox" name="CheckState" {{$order->urgent_dispatch == 1 ? 'checked' : ''}} disabled/>
                    <span></span>
                    Marcar Urgente Despacho
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="CheckState" {{$order->return_last_destination == 1 ? 'checked' : ''}} disabled/>
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
            <input name="save_value" type="number" class="form-control form-control-solid" value="{{$order->insured_value}}" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>A cobrar %: <span class="text-danger">*</span></label>
            <input name="collet_porcent" type="number" class="form-control form-control-solid" value="{{$order->percentage_to_collect}}" disabled/>
            <span class="form-text text-muted"></span>
        </div>
        <div class="form-group col-md-6">
            <label>A cobrar $: <span class="text-danger">*</span></label>
            <input name="collet_cash" type="number" class="form-control form-control-solid" value="{{$order->money_to_collect}}" disabled/>
            <span class="form-text text-muted"></span>
        </div>
    </div>
</div>
