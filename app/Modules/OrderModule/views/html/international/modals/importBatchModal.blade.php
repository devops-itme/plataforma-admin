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
                    <div>
                        <select name="provider" id="provider" class="form-control" onchange="showHideProviderForm(this)">
                            <option value="0" selected disabled>Seleccione el proveedor</option>
                            <option value="1">Tealca</option>
                            <option value="2">Coordinadora</option>
                        </select>
                        <br>
                        <label id="countryLabel" style="display: none" for="">Pais: <span class="text-danger">*</span></label>
                            <select style="display: none" id="country" name="country" class="form-control">
                                <option value="0" selected disabled>Seleccione el pais</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Venezuela">Venezuela</option>
                            </select>
                    </div>
                    <div style="display: none" id="tealcaContent">
                        <div class="form-group col-md-3">
                            <br>
                            <label for="customer">Cliente <span class="text-danger">*</span></label>
                            <select style="width:440px;" name="customer_id" class="select2-customers form-control-solid" id="customer">
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
                        <br>
                    </div>                    
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="loadingAlert()">Importar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Cerrar</button>
                </div>
            </form>

            <div class="templateContent" id="coordinadoraGuidesTemplate" style="display: none; position:absolute; margin-top: 83%; margin-left: 35px">
                <a href="{{ route('coordinadora.import.template') }}" type="button" class="btn btn-info">Descargar plantilla</a>
                <i class="fas fa-info-circle fa-2x" 
                title="Todos los campos son requeridos. Para guías con varios productos, debe haber tantas filas como productos y la información de la guía es la misma."></i>
            </div>
        </div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        function loadingAlert() {

            Swal.fire({
            title: '<h2>Cargando guías</h2>',
            html: '<h3>Porfavor espere...</h3>',
            allowOutsideClick: false,
            buttons: false,
            didOpen: () => {
                Swal.showLoading()
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
            }).then((result) => {
                Swal.fire({
                    icon: 'success',
                    title: 'ÉXITO',
                    text: 'Guías cargadas correctamente',
                    })
            })
        }

    function showHideProviderForm(sel) {
        if (sel.value=="1"){
            document.getElementById("tealcaContent").style.display = "block";
            document.getElementById("country").style.display = "none";
            document.getElementById("coordinadoraGuidesTemplate").style.display = "none";
            document.getElementById("countryLabel").style.display = "none";
        }else{
            document.getElementById("tealcaContent").style.display = "block";
            document.getElementById("country").style.display = "block";
            document.getElementById("countryLabel").style.display = "block";
            document.getElementById("coordinadoraGuidesTemplate").style.display = "block";
        }
    }

    function closeModal(){
        document.getElementById("tealcaContent").style.display = "none";
        select_box = document.getElementById("provider");
        document.getElementById("country").style.display = "none";
        document.getElementById("countryLabel").style.display = "none";
        document.getElementById("coordinadoraGuidesTemplate").style.display = "none";
        select_box.selectedIndex = 0;
    }
    
</script>