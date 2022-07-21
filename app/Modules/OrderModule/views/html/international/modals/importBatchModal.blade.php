<div class="modal" role="dialog" id="importBatchModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar Lote</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('internationalOrders.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if (Auth::user()->getRole->name == 'Admin')
                    <div class="form-group col-md-3">
                        <label for="customer">Cliente <span class="text-danger">*</span></label>
                        <select name="customer_id" class="select2-customers form-control-solid" id="customer">
                            <option value="" id="user_id" selected disabled>Seleccione un cliente</option>
                            @foreach ($customers as $customer)
                            <option {{ old('customer') == $customer->getUser->id ? 'selected ' : '' }} value="{{ $customer->getUser->id }}">
                                @if (!isset($customer->getUser->name))
                                {{ $customer->business_name }}
                              @else
                              {{ $customer->getUser->name . ' ' . $customer->getUser->last_name }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="user_id" id="customer_id" value="{{ Auth::user()->id }}">
                    @endif
                    <div class="form-group col-md-12">
                        <label for="customer">Cargar Excel. <span class="text-danger">*</span></label>
                        <div class="row mx-2">
                            <input class="form-input" type="checkbox" value="true" name="unique_phone" id="">
                            <p class="ml-2">Permitir datos repetidos</p>
                        </div>
                        <input class="form-control-file" type="file" name="excel" id="file">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Importar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
