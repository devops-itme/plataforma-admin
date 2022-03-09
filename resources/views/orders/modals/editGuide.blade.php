<!-- Modal edit-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Editar guia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times h5"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap flex-row">
                    <h5 class="my-4 font-weight-bold text-dark col-md-12">Datos de destino</h5>
                    <div class="form-group col-md-3">
                        <label for="branch_off">Sucursal despacho <span class="text-danger">*</span></label>
                        <select name="branch_office" class="form-control form-control-solid" id="branch_off_edit">
                            <option disabled> Seleccione </option>
                        </select>
                    </div>
                    {{-- <div class="form-group col-md-3">
                        <label>Despacho: <span class="text-danger">*</span></label>
                        <input name="office" type="number" class="form-control form-control-solid" placeholder="" id="dispatched_edit"/>
                        <span class="form-text text-muted"></span>
                    </div> --}}
                    <div class="form-group col-md-3">
                        <label for="address">Dirección <span class="text-danger">*</span></label>
                        <input name="address" id="address_edit" type="text" class="form-control form-control-solid" placeholder=""/>
                        {{-- <select name="address" class="form-control form-control-solid" id="address">
                            <option selected disabled>Seleccione dirección</option>
                            <option>Dirección 1</option>
                            <option>Dirección 2</option>
                        </select> --}}
                    </div>
                    <input name="lat" id="lat_edit" type="hidden" class="form-control form-control-solid" placeholder=""/>
                    <input name="lng" id="lng_edit" type="hidden" class="form-control form-control-solid" placeholder=""/>
                    <div class="form-group col-md-3">
                        <label for="district">Barrio <span class="text-danger">*</span></label>
                        <textarea name="address_description" id="address_description_edit" class="form-control form-control-solid"></textarea>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Concepto: <span class="text-danger">*</span></label>
                        <input name="concept" id="concept_edit" type="text" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="district">Tarifa <span class="text-danger">*</span></label>
                        <select name="rate" class="form-control form-control-solid" id="rate_edit">
                            <option selected disabled>Seleccione Tarifa</option>
                            <option>Adicional</option>
                            <option>Plena</option>
                            <option>Retorno</option>
                            <option>Adicional*0</option>
                            <option>Plena/2</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Valor: <span class="text-danger">*</span></label>
                        <input name="value" id="value_edit" type="number" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Valor Corp: <span class="text-danger">*</span></label>
                        <input name="corp_value" id="corp_value_edit" type="number" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="doc_type">Cliente tipo documento <span class="text-danger">*</span></label>
                        <select name="doc_type" class="form-control form-control-solid" id="customer_document_type_edit">
                            <option selected disabled>Seleccione tipo documento</option>
                            @foreach ($customer_document_type as $document)
                                <option value="{{$document->id}}"> {{$document->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Contacto: <span class="text-danger">*</span></label>
                        <input name="contact" id="contact_edit" type="text" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    {{-- <div class="form-group col-md-3">
                        <label>Contacto telefono: <span class="text-danger">*</span></label>
                        <select name="phone_contact" class="form-control form-control-solid mr-2" id="phone_contact">
                            <option selected disabled>Seleccione zip</option>
                            <option>507:panama</option>
                            <option>57:colombia</option>
                        </select>
                        <span class="form-text text-muted"></span>
                    </div> --}}
                    <div class="form-group col-md-3 pt-2">
                        <label>Teléfono contacto </label>
                        <input name="phone_contact" type="tel" id="phone_contact_edit" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Contacto Email: <span class="text-danger">*</span></label>
                        <input name="email_contact" id="email_contact_edit" type="email" class="form-control form-control-solid"
                            placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Contacto Factura: <span class="text-danger">*</span></label>
                        <input name="invoice_contact" id="invoice_contact_edit" type="text" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="customer_address">Dirección cliente <span class="text-danger">*</span></label>
                        <select name="customer_address" class="form-control form-control-solid" id="customer_address_edit" onchange="console.log('ho')">
                            <option disabled>Seleccione </option>
                        </select>
                    </div>
                    <div class="form-group col-md-1 mb-0 d-flex align-items-center justify-content-start">
                        <a class="btn" data-toggle="modal" data-target="#modalCreateAddress" data-dismiss="modal">
                            <i class="fad fa-plus-circle text-info"></i>
                        </a>
                    </div>
                    <div class="form-group col-md-6 d-flex align-items-center">
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="same_day_delivery" id="same_day_delivery_edit" />
                                <span></span>
                                Some Day Delivery
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="sign" id="sign_edit" />
                                <span></span>
                                Firmar
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="take_photo" id="take_photo_edit" />
                                <span></span>
                                Tomar Foto
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="nav nav-tabs nav-bolder nav-tabs-line nav-tabs-line-3x" id="tabmodal" role="tablist">
                            <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="cajas-tab" data-toggle="tab" href="#cajas" role="tab" aria-controls="cajas" aria-selected="true">Cajas/Embalaje</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="facil-tab" data-toggle="tab" href="#facil" role="tab"
                                    aria-controls="facil" aria-selected="false">Me Facilities</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="prod-tab" data-toggle="tab" href="#prod" role="tab"
                                    aria-controls="prod" aria-selected="false">Me Productos</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="prod-tab" data-toggle="tab" href="#diligencia" role="tab"
                                    aria-controls="diligencia" aria-selected="false">Gastos por diligencia</a>
                            </li>
                        </ul>
                        <div class="tab-content min-h-100px " id="myTabContent">
                            {{-- <div class="table-responsive tab-pane fade show active" id="cajas" role="tabpanel"
                                aria-labelledby="cajas-tab">
                                <div class="row font-weight-bold border bg-gray-200 mt-4 text-center">
                                    <div class="col-1 border-right">#</div>
                                    <div class="col-1 border-right">Peso</div>
                                    <div class="col-1 border-right">Largo</div>
                                    <div class="col-1 border-right">Ancho</div>
                                    <div class="col-1 border-right">Alto</div>
                                    <div class="col-2 border-right">Peso_Vol</div>
                                    <div class="col-3 border-right">Comentarios</div>
                                    <div class="col-2">
                                        <a href="#" class="btn btn-icon btn-light-primary btn-sm mr-2 add-box-btn"
                                            id="add-box-btn" data-tooltip title="Agregar">
                                            <i class="fad fa-plus-circle"></i>
                                        </a>
                                    </div>
                                </div>
                                <div id="box-container">
                                    <div class="row border mt-0 text-center box-register" id="0">
                                        <div class="col-1 py-4 border-right"><input type="number" name="id[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="weight[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="long[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="broad[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="high[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="vol_weight[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-4 py-4 border-right"><input type="text" name="description[]"
                                                class="form-control" placeholder="comertarios"></div>
                                        <div class="col-1 py-4">
                                            <div class="d-flex flex-row flex-wrap justify-content-center">
                                                <a href="#"
                                                    class="btn btn-icon btn-light-danger btn-sm mr-2 remove-box-btn"
                                                    id="0" data-tooltip title="Borrar">
                                                    <i class="fad fa-minus-circle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-sm align-items-center table-flush tab-pane fade show active" id="cajas"
                                    role="tabpanel">
                                    <thead class="row font-weight-bold border bg-gray-200 mt-4 text-center">
                                        <tr>
                                            <th scope="col" class="col-1 border-right">#</th>
                                            <th scope="col" class="col-1 border-right">Peso</th>
                                            <th scope="col" class="col-1 border-right">Largo</th>
                                            <th scope="col" class="col-1 border-right">Ancho</th>
                                            <th scope="col" class="col-1 border-right">Alto</th>
                                            <th scope="col" class="col-1 border-right">Peso_Vol</th>
                                            <th scope="col" class="col-2 border-right">Comentarios</th>
                                            <th scope="col" class="col-1">
                                                <div class="d-flex flex-row flex-wrap justify-content-center">
                                                    <a href="#" class="btn btn-icon btn-light-primary btn-sm mr-1 add-box-btn"
                                                        id="add-box-btn" data-tooltip title="Agregar">
                                                        <i class="fad fa-plus-circle"></i>
                                                    </a>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="box-container">
                                        <tr class="row border mt-0 text-center box-register">
                                            <td class="col-1 py-4 border-right"><input type="number" name="id[]"
                                                    class="form-control" min="0" value="0"></td>
                                            <td class="col-1 py-4 border-right"><input type="number" name="weight[]"
                                                    class="form-control" min="0" value="0"></td>
                                            <td class="col-1 py-4 border-right"><input type="number" name="long[]"
                                                    class="form-control" min="0" value="0"></td>
                                            <td class="col-1 py-4 border-right"><input type="number" name="broad[]"
                                                    class="form-control" min="0" value="0"></td>
                                            <td class="col-1 py-4 border-right"><input type="number" name="high[]"
                                                    class="form-control" min="0" value="0"></td>
                                            <td class="col-1 py-4 border-right"><input type="number"
                                                    name="vol_weight[]" class="form-control" min="0" value="0"></td>
                                            <td class="col-3 py-4 border-right"><input type="text" name="description[]"
                                                    class="form-control" placeholder="comertarios"></td>
                                            <td class="col-2 py-4">
                                                <div class="d-flex flex-row flex-wrap justify-content-center">
                                                    <a href="#"
                                                        class="btn btn-icon btn-light-danger btn-sm mr-2 remove-box-btn"
                                                        id="0" data-tooltip title="Borrar">
                                                        <i class="fad fa-minus-circle"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> --}}
                            <div class="table-responsive tab-pane fade show active col-md-12 " id="cajas" role="tabpanel"
                                aria-labelledby="cajas-tab">
                                  <div class="row font-weight-bold border  mt-4 text-center bg-gray-200">
                                    <div class="col-1 border-right">#</div>
                                    <div class="col-1 border-right">Peso</div>
                                    <div class="col-1 border-right">Largo</div>
                                    <div class="col-1 border-right">Ancho</div>
                                    <div class="col-1 border-right">Alto</div>
                                    <div class="col-1 border-right">Peso_Vol</div>
                                    <div class="col-2 border-right">Comentarios</div>
                                    <div class="col-1">
                                        <a href="#" class="btn btn-icon btn-light-primary btn-sm mr-1 add-box-btn"
                                            id="add-box-btn-edit" data-tooltip title="Agregar">
                                            <i class="fad fa-plus-circle"></i>
                                        </a>
                                    </div>
                                </div>
                                 <div id="box-container-edit" name="box-container">
                                    {{-- <div class="row border mt-0 text-center box-register" id="0">
                                        <div class="col-1 py-4 border-right"><input type="number" name="id[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="weight[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="long[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="broad[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="high[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-1 py-4 border-right"><input type="number" name="vol_weight[]"
                                                class="form-control" min="0" value="0"></div>
                                        <div class="col-4 py-4 border-right"><input type="text" name="description[]"
                                                class="form-control" placeholder="comertarios"></div>
                                        <div class="col-1 py-4">
                                            <div class="d-flex flex-row flex-wrap justify-content-center">
                                                <a href="#"
                                                    class="btn btn-icon btn-light-danger btn-sm mr-2 remove-box-btn"
                                                    id="0" data-tooltip title="Borrar">
                                                    <i class="fad fa-minus-circle"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                            </div>
                            <div class="tab-pane fade" id="facil" role="tabpanel" aria-labelledby="facil-tab">
                                <div class="d-flex pt-4 flex-row flex-wrap">
                                    <div class="form-group col-md-3">
                                        <label>Full-Fillment(FF): <span class="text-danger">*</span></label>
                                        <input name="full_fill" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Cobrar X Paquete COD: <span class="text-danger">*</span></label>
                                        <input name="cost_pack" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>CashOnDelivery (COD): <span class="text-danger">*</span></label>
                                        <input name="delivery" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Total:</label>
                                        <span class="form-text text-muted h5">$100</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="prod" role="tabpanel" aria-labelledby="prod-tab">
                                <div class="d-flex pt-4 flex-row flex-wrap">
                                    <div class="form-group col-md-3">
                                        <label>Producto: <span class="text-danger">*</span></label>
                                        <select name="prdc" class="form-control form-control-solid mr-2" id="prdc">
                                            <option selected disabled>Seleccione producto</option>
                                            <option>FOTOCOPIA COLOR</option>
                                            <option>FOTOCOPIA B/N</option>
                                        </select>
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Cantidad: <span class="text-danger">*</span></label>
                                        <input name="quantity" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Valor Unidad: <span class="text-danger">*</span></label>
                                        <input name="unity_value" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Valor Total: <span class="text-danger">*</span></label>
                                        <input name="total_value" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="diligencia" role="tabpanel"
                                aria-labelledby="diligencia-tab">
                                <div class="d-flex pt-4 flex-row flex-wrap">
                                    <div class="form-group col-md-2 d-flex align-items-center">
                                        <div class="checkbox-inline">
                                            <label class="checkbox">
                                                <input type="checkbox" name="checkCost" />
                                                <span></span>
                                                Si
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Gastos: <span class="text-danger">*</span></label>
                                        <input name="costs" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Comisión: <span class="text-danger">*</span></label>
                                        <input name="commission" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Tax: <span class="text-danger">*</span></label>
                                        <input name="tax_value" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Total: <span class="text-danger">*</span></label>
                                        <input name="total" type="number" class="form-control form-control-solid"
                                            placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold"
                    data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="btnUpdateGuide">Guardar</button>
            </div>
        </div>
    </div>
</div>
