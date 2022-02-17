<!-- Modal Create-->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Crear Sucursal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times h5"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-row flex-wrap">
                    <div class="form-group col-md-3">
                        <label>Nombre de sucursal: </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Nombre sucursal" name="branch_office_name" id="branch_office_name" value="{{ old('branch_office_name') }}" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Tipo de sucursal</label>
                        <select class="form-control form-control-solid" id="branch_office_type" name="branch_office_type">
                            <option selected disabled>Seleccione</option>
                            @foreach ($branch_office_type as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Descripción de sucursal:</label>
                        <textarea class="form-control form-control-solid" id="branch_office_description" rows="1" name="branch_office_description">{{ old('branch_office_description') }}</textarea>
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Zona de sucursal:</label>
                        <select class="form-control form-control-solid" id="branch_office_zone" name="branch_office_zone">
                            <option selected disabled>Seleccione</option>
                            @foreach ($documents as $document)
                            <option value="{{ $document->id }}" {{ $document->id == old('branch_office_zone') ? 'selected' : '' }}>
                                {{ $document->name }}
                            </option>
                            @endforeach
                        </select>
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Dirección de sucursal: </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Dirección" name="branch_office_address" value="{{ old('branch_office_address') }}" id="branch_office_address" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <input type="hidden" name="branch_office_lat" id="branch_office_lat">
                    <input type="hidden" name="branch_office_lng" id="branch_office_lng">
                    <div class="form-group col-md-4">
                        <label>Email de sucursal: </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Email" name="branch_office_email" id="branch_office_email" value="{{ old('branch_office_email') }}" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Contacto de sucursal: </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Contacto" name="branch_office_contact" value="{{ old('branch_office_email') }}" id="branch_office_contact" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Tipo de documento sucursal:</label>
                        <select class="form-control form-control-solid" id="branch_office_document_type" name="branch_office_document_type">
                            <option selected disabled>Seleccione</option>
                            @foreach ($documents as $document)
                            <option value="{{ $document->id }}" {{ $document->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                {{ $document->name }}
                            </option>
                            @endforeach
                        </select>
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Documento de sucursal: </label>
                        <input type="text" class="form-control form-control-solid" id="branch_office_document_number" placeholder="Numero de documento" name="branch_office_document_number" value="{{ old('branch_office_document_number') }}" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Metodo de pago:</label>
                        <select class="form-control form-control-solid" id="branch_office_payment_method" name="branch_office_payment_method">
                            <option selected disabled>Seleccione</option>
                            @foreach ($payment_method as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Telefono de sucursal: </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Telefono" name="branch_office_phone" value="{{ old('branch_office_phone') }}" id="branch_office_phone" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="d-none" id="slcPlan">
                        <label>Planes:</label>
                        <select class="form-control form-control-solid">
                            <option selected disabled>Seleccione</option>
                            @foreach ($documents as $document)
                            <option value="{{ $document->id }}" {{ $document->id == old('branch_office_usage_mode') ? 'selected' : '' }}>
                                {{ $document->name }}
                            </option>
                            @endforeach
                        </select>
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="d-none" id="useMode">
                        <label>Modo de uso:</label>
                        <select class="form-control form-control-solid" id="branch_office_usage_mode" name="branch_office_usage_mode">
                            <option selected disabled>Seleccione</option>
                            @foreach ($use_mode as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('branch_office_usage_mode') ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-2 mb-0 py-4">
                        <label>¿Sucursal predeterminada?</label>
                        <div class="radio-inline">
                            <label class="radio radio-rounded">
                                <input type="radio" checked="checked" name="branch_office_default" value="1" {{ old('branch_office_default') == 1 ? 'checked="checked"' : '' }} id="branch_office_default" />
                                <span></span>
                                SI
                            </label>
                            <label class="radio radio-rounded">
                                <input type="radio" name="branch_office_default" value="0" {{ old('branch_office_default') == 0 ? 'checked="checked"' : '' }} id="branch_office_default" />
                                <span></span>
                                NO
                            </label>
                        </div>
                        <span class="form-text text-muted"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveBranchOffice">Guardar</button>
            </div>
        </div>
    </div>
</div>
