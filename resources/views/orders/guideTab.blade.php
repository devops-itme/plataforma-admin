<!--begin: Datatable-->
<table class="table table-sm">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Contacto</th>
            <th scope="col">Telefono</th>
            <th scope="col">Correo</th>
            <th scope="col">Fecha programada</th>
            <th scope="col">Tarifa</th>
            <th scope="col">Estado</th>
            <th scope="col">
                <div class="d-flex justify-content-end">
                    <a href="#" class="btn btn-primary btn-sm font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                        <span class="svg-icon svg-icon-md">
                            <i class="fas fa-plus"></i>
                        </span>Crear
                    </a>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <th scope="row">---</th>
                <td>---</td>
                <td>---</td>
                <td>---</td>
                <td>---</td>
                <td>---</td>
                <td>
                        <span class="label label-inline label-light-success font-weight-bold">
                            Activo
                        </span>
                        {{-- <span class="label label-inline label-light-danger font-weight-bold">
                            Inactivo
                        </span> --}}
                </td>
                <td>
                    <div
                        class="d-flex justify-content-around aling-items-center flex-wrap flex-row">
                        <a href="#" class="btn btn-icon btn-light-primary btn-sm mr-2">
                            <i class="far fa-folder-open"></i>
                        </a>
                        <a href="#"
                            class="btn btn-icon btn-light-success btn-sm mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#"
                            role="button"
                            class="btn btn-icon btn-light-danger btn-sm mr-2">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </td>
            </tr>
    </tbody>
</table>
<!--end: Datatable-->

<!-- Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear guia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap flex-row">
                    <h5 class="my-4 font-weight-bold text-dark col-md-12">Datos de destino</h5>
                    <div class="form-group col-md-3">
                        <label for="branch_off">Sucursal despacho <span class="text-danger">*</span></label>
                        <select name="branch_off" class="form-control form-control-solid" id="branch_off">
                            <option selected disabled>Seleccione sucursal</option>
                            <option>Sucursal 1</option>
                            <option>Sucursal 2</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Despacho: <span class="text-danger">*</span></label>
                        <input name="office" type="number" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">Dirección <span class="text-danger">*</span></label>
                        <select name="address" class="form-control form-control-solid" id="address">
                            <option selected disabled>Seleccione dirección</option>
                            <option>Dirección 1</option>
                            <option>Dirección 2</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="district">Barrio <span class="text-danger">*</span></label>
                        <select name="district" class="form-control form-control-solid" id="district">
                            <option selected disabled>Seleccione Barrio</option>
                            <option>Barrio 1</option>
                            <option>Barrio 2</option>
                        </select>
                    </div>
                   <div class="form-group col-md-5">
                        <label>Concepto: <span class="text-danger">*</span></label>
                        <input name="concept" type="text" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="district">Tarifa <span class="text-danger">*</span></label>
                        <select name="district" class="form-control form-control-solid" id="district">
                            <option selected disabled>Seleccione Tarifa</option>
                            <option>Adicional</option>
                            <option>Plena</option>
                            <option>Retorno</option>
                            <option>Adicional*0</option>
                            <option>Plena/2</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Valor: <span class="text-danger">*</span></label>
                        <input name="value" type="number" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Valor Corp: <span class="text-danger">*</span></label>
                        <input name="corp_value" type="number" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="doc_type">Cliente tipo documento <span class="text-danger">*</span></label>
                        <select name="doc_type" class="form-control form-control-solid" id="doc_type">
                            <option selected disabled>Seleccione tipo documento</option>
                            <option>CC</option>
                            <option>CE</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Contacto: <span class="text-danger">*</span></label>
                        <input name="contact" type="text" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Contacto telefono: <span class="text-danger">*</span></label>
                        <div class="d-flex flex-row">
                            <select name="zip_code" class="form-control form-control-solid mr-2" id="zip_code">
                                <option selected disabled>Seleccione zip</option>
                                <option>507:panama</option>
                                <option>57:colombia</option>
                            </select>
                            <input name="contact" type="tel" class="form-control form-control-solid" placeholder="" />
                        </div>
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Contacto Email: <span class="text-danger">*</span></label>
                        <input name="contact_email" type="email" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Contacto Factura: <span class="text-danger">*</span></label>
                        <input name="contact_fac" type="text" class="form-control form-control-solid" placeholder="" />
                        <span class="form-text text-muted"></span>
                    </div>
                    <div class="form-group col-md-6 d-flex align-items-center">
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="Checkboxes2"/>
                                <span></span>
                                Some Day Delivery
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="Checkboxes2"/>
                                <span></span>
                                Firmar
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="Checkboxes2"/>
                                <span></span>
                                Tomar Foto
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="nav nav-tabs nav-bolder" id="tabmodal" role="tablist">
                            <li class="nav-item" role="presentation">
                              <a class="nav-link active" id="cajas-tab" data-toggle="tab" href="#cajas" role="tab" aria-controls="cajas" aria-selected="true">Cajas/Envalaje</a>
                            </li>
                            <li class="nav-item" role="presentation">
                              <a class="nav-link" id="facil-tab" data-toggle="tab" href="#facil" role="tab" aria-controls="facil" aria-selected="false">Me Facilities</a>
                            </li>
                            <li class="nav-item" role="presentation">
                              <a class="nav-link" id="prod-tab" data-toggle="tab" href="#prod" role="tab" aria-controls="prod" aria-selected="false">Me Productos</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="prod-tab" data-toggle="tab" href="#diligencia" role="tab" aria-controls="diligencia" aria-selected="false">Gastos por diligencia</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="cajas" role="tabpanel" aria-labelledby="cajas-tab">
                            </div>
                            <div class="tab-pane fade" id="facil" role="tabpanel" aria-labelledby="facil-tab">
                                <div class="d-flex pt-4 flex-row flex-wrap">
                                    <div class="form-group col-md-3">
                                        <label>Full-Fillment(FF): <span class="text-danger">*</span></label>
                                        <input name="full_fill" type="number" class="form-control form-control-solid" placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Cobrar X Paquete COD: <span class="text-danger">*</span></label>
                                        <input name="cost_pack" type="number" class="form-control form-control-solid" placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>CashOnDelivery (COD): <span class="text-danger">*</span></label>
                                        <input name="delivery" type="number" class="form-control form-control-solid" placeholder="" />
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
                                        <input name="quantity" type="number" class="form-control form-control-solid" placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Valor Unidad: <span class="text-danger">*</span></label>
                                        <input name="unity_value" type="number" class="form-control form-control-solid" placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Valor Total: <span class="text-danger">*</span></label>
                                        <input name="total_value" type="number" class="form-control form-control-solid" placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="diligencia" role="tabpanel" aria-labelledby="diligencia-tab">
                                <div class="d-flex pt-4 flex-row flex-wrap">
                                    <div class="form-group col-md-2 d-flex align-items-center">
                                        <div class="checkbox-inline">
                                            <label class="checkbox">
                                                <input type="checkbox" name="checkCost"/>
                                                <span></span>
                                                Si
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Gastos: <span class="text-danger">*</span></label>
                                        <input name="costs" type="number" class="form-control form-control-solid" placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Comisión: <span class="text-danger">*</span></label>
                                        <input name="commission" type="number" class="form-control form-control-solid" placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Tax: <span class="text-danger">*</span></label>
                                        <input name="tax_value" type="number" class="form-control form-control-solid" placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Total: <span class="text-danger">*</span></label>
                                        <input name="total" type="number" class="form-control form-control-solid" placeholder="" />
                                        <span class="form-text text-muted"></span>
                                    </div>
                                </div>
                            </div>
                          </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary font-weight-bold">Guardar</button>
            </div>
        </div>
    </div>
</div>
