<!-- Este modal muestra la información del cliente seleccionado en el select-->
<div class="modal fade" id="detailCustomer" tabindex="-1" role="dialog" aria-labelledby="detailCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailCustomerLabel">Busqueda de cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-2 pb-5">
                    <div class="row">
                        <div class="col md-4 mb-2">
                            <h5 class="font-weight-bold text-dark">Buscar cliente (nombre comercial - documento)</h5>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Ingrese documento del cliente o nombre comercial" id="search_customer">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-light-success" type="button" id="btnSearch"><i class="fad fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-4 mb-2">
                            Cambiar a nombre de empresa si lo es
                            <div class="font-weight-bold mb-3">Nombres:</div>
                            <div class="line-height-xl" id="customer_modal_name">---</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="font-weight-bold mb-3">Nombre de empresa:</div>
                            <div class="line-height-xl">---</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            Cambiar a nombre comercial si lo es
                            <div class="font-weight-bold mb-3">Apellidos:</div>
                            <div class="line-height-xl" id="customer_modal_last_name">---</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="font-weight-bold mb-3">Nombre de comercial:</div>
                            <div class="line-height-xl">---</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="font-weight-bold mb-3">Contacto:</div>
                            <div class="line-height-xl" id="customer_modal_contact">---</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="font-weight-bold mb-3">Sucursal:</div>
                            <div class="line-height-xl"><b id="customer_modal_branch_office">---</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="font-weight-bold mb-3">Departamento:</div>
                            <div class="line-height-xl"><b id="customer_modal_deparment">---</div>
                        </div>

                    </div> --}}
                </div>
                <div class="table-responsive">
                    <table class="table table-sm" id="table_customers">
                        <thead>
                            <tr>
                                <th scope="col text-center">#</th>
                                <th scope="col text-center">Telefono</th>
                                <th scope="col text-center">Nombre comercial</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
