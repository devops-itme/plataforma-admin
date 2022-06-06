<div class="modal fade" id="modalCreateAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CREAR DIRECCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div hidden id="modal_data_user_id"></div> <!-- Capture user_id from view Orders(Create) -->
                <form action="{{ route('addresses.store') }}" method="POST" id="formCreateAddress" name="myform">
                    @csrf
                    {{-- <input type="text"  id="user_code" hidden name="user_id" value="{{$customer->user_id}}"> --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" hidden id="user_code" name="user_code" class="form-control">
                            <label> Descripción </label>
                            <input type="text" name="description" class="form-control" value="{{old('description')}}" placeholder="Descripción" id="add_description">
                        </div>
                        <div class="col-md-6">
                            <label> Dirección *</label>
                            <input type="text" name="address" class="form-control" value="{{old('address')}}" id="add_name" placeholder="Introduce una ubicación">
                            <input type="hidden" name="lat" id="add_lat" value="{{old('lat')}}">
                            <input type="hidden" name="lng" id="add_lng" value="{{old('lng')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                        <button type="button" class="btn btn-primary" onclick="save()" id="saveAddress"><i class="fas fa-save"></i>GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>