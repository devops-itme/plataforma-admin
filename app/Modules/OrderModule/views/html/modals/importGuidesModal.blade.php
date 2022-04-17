<!-- Modal -->
<div class="modal fade" data-order-id="{{$order->id}}" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Importar Guías</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label><b>Plantilla </b><span class="text-danger">*</span></label>
                    <a href="{{asset('files/GuidesTemplate.xlsx')}}" download="PlantillaGuias.xlsx"> <img src="{{asset('img/laravel-excel-img.png')}}" alt="" height="50px" width="200px"> </a>
                    <span class="form-text text-muted"></span>
                </div>
                <input type="text" hidden name="order_id" id="order_id" value="{{$order->id}}">
                <div class="col-md-6">
                    <label><b>Anexar excel </b><span class="text-danger">*</span></label>
                    <input name="file" type="file" id="file_import_guide" class="form-control form-control-solid" placeholder=""/>
                    <span class="form-text text-muted"></span>
                </div>
                <div class="col-md-12 mt-3">
                    <button type="button" class="btn btn-success btn-block" id="btnImportGuide">
                        <span class="svg-icon svg-icon-md">
                            <i class="fad fa-upload"></i>
                        </span>Importar
                    </button>
                </div>
            </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
