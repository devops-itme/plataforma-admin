<!-- Modal edit-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Editar Sucursal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times h5"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formUpdate">
                    @csrf @method('PUT')
                    <div class="d-flex flex-row flex-wrap">
                        <div class="form-group col-md-3">
                            <label>Nombre de sucursal: </label>
                            <input type="text" class="form-control form-control-solid" placeholder="Nombre sucursal" id="branch_office_name_edit" name="branch_office_name" value="{{ old('branch_office_name') }}" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tipo de sucursal</label>
                            <select class="form-control form-control-solid" id="branch_office_type_edit" name="branch_office_type">
                                <option disabled>Seleccione</option>
                                @foreach ($branch_office_type as $item)
                                <option value="{{ $item->id }}" {{ $item->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Descripción de sucursal:</label>
                            <textarea class="form-control form-control-solid" id="branch_office_description_edit" rows="1" name="branch_office_description">{{ old('branch_office_description') }}</textarea>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Zona de sucursal:</label>
                            <select class="form-control form-control-solid" id="branch_office_zone_edit" name="branch_office_zone">
                                <option disabled>Seleccione</option>
                                @foreach ($documents as $document)
                                <option value="{{ $document->id }}" {{ $document->id == old('branch_office_zone') ? 'selected' : '' }}>
                                    {{ $document->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Dirección de sucursal: </label>
                            <input type="text" class="form-control form-control-solid" placeholder="Dirección" name="branch_office_address" value="{{ old('branch_office_address') }}" id="branch_office_address_edit" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <input type="hidden" name="branch_office_lat" id="branch_office_lat_edit">
                        <input type="hidden" name="branch_office_lng" id="branch_office_lng_edit">
                        <div class="form-group col-md-3">
                            <label>Email de sucursal: </label>
                            <input type="text" class="form-control form-control-solid" id="branch_office_email_edit" placeholder="Email" name="branch_office_email" value="{{ old('branch_office_email') }}" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Contacto de sucursal: </label>
                            <input type="text" class="form-control form-control-solid" placeholder="Contacto" id="branch_office_contact_edit" name="branch_office_contact" value="{{ old('branch_office_email') }}" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tipo de documento sucursal:</label>
                            <select class="form-control form-control-solid" id="branch_office_document_type_edit" name="branch_office_document_type">
                                <option disabled>Seleccione</option>
                                @foreach ($documents as $document)
                                <option value="{{ $document->id }}" {{ $document->id == old('branch_office_document_type') ? 'selected' : '' }}>
                                    {{ $document->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Documento de sucursal: </label>
                            <input type="text" class="form-control form-control-solid" id="branch_office_document_number_edit" placeholder="Numero de documento" name="branch_office_document_number" value="{{ old('branch_office_document_number') }}" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Departamento de sucursal:</label>
                            <select class="form-control form-control-solid" id="branch_office_department_edit" name="branch_office_department">
                                <option selected disabled>Seleccione</option>
                            </select>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Metodo de pago:</label>
                            <select class="form-control form-control-solid" id="branch_office_payment_method_edit" name="branch_office_payment_method">
                                <option disabled>Seleccione</option>
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
                            <input type="text" class="form-control form-control-solid" placeholder="Telefono" name="branch_office_phone" id="branch_office_phone_edit" value="{{ old('branch_office_phone') }}" />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="d-none" id="slcPlanEdit">
                            <label>Planes:</label>
                            <select class="form-control form-control-solid" id="branch_office_plan_edit" name="branch_office_plan">
                                <option disabled>Seleccione</option>
                                @foreach ($documents as $document)
                                <option value="{{ $document->id }}" {{ $document->id == old('branch_office_plan') ? 'selected' : '' }}>
                                    {{ $document->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="d-none" id="useModeEdit">
                            <label>Modo de uso:</label>
                            <select class="form-control form-control-solid" id="branch_office_usage_mode_edit" name="branch_office_usage_mode">
                                <option disabled>Seleccione</option>
                                @foreach ($use_mode as $item)
                                <option value="{{ $item->id }}" {{ $item->id == old('branch_office_usage_mode') ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-3 mb-0 py-4">
                            <label>¿Sucursal predeterminada?</label>
                            <div class="radio-inline">
                                <label class="radio radio-rounded">
                                    <input type="radio" name="branch_office_default_edit" value="1" />
                                    <span></span>
                                    SI
                                </label>
                                <label class="radio radio-rounded">
                                    <input type="radio" name="branch_office_default_edit" value="0" />
                                    <span></span>
                                    NO
                                </label>
                            </div>
                            <span class="form-text text-muted"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary font-weight-bold" id="updateBranchOffice">Guardar</button>
            </div>
        </div>
    </div>
</div>
