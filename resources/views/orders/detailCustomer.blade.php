<!-- Este modal muestra la información del cliente seleccionado en el select-->
<div class="modal fade" id="detailCustomer" tabindex="-1" role="dialog" aria-labelledby="detailCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailCustomerLabel">Información de cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="mb-10 font-weight-bold text-dark">Información basica de cliente</h5>
                <div class="mb-5 pb-5">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            {{-- Cambiar a nombre de empresa si lo es --}}
                            <div class="font-weight-bold mb-3">Nombres:</div>
                            <div class="line-height-xl" id="customer_modal_name">---</div>
                        </div>
                        {{-- <div class="col-md-4 mb-2">
                            <div class="font-weight-bold mb-3">Nombre de empresa:</div>
                            <div class="line-height-xl">---</div>
                        </div> --}}
                        <div class="col-md-4 mb-2">
                            {{-- Cambiar a nombre comercial si lo es --}}
                            <div class="font-weight-bold mb-3">Apellidos:</div>
                            <div class="line-height-xl" id="customer_modal_last_name">---</div>
                        </div>
                        {{-- <div class="col-md-4 mb-2">
                            <div class="font-weight-bold mb-3">Nombre de comercial:</div>
                            <div class="line-height-xl">---</div>
                        </div> --}}
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

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
