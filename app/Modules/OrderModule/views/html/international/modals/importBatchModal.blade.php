<div class="modal" tabindex="-1" role="dialog" id="importBatchModal">
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
                    <p>Cargar Excel.</p>
                    <div class="row mx-2">
                        <input class="form-input" type="checkbox" value="true" name="unique_phone" id="">
                        <p class="ml-2">Permitir datos repetidos</p>
                    </div>
                        <input class="form-control-file" type="file" name="excel" id="file">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Importar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
