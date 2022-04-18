<!-- Modal -->
<div class="modal fade" id="editHour" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formUpdateHour">
                    @csrf @method('put')
                    <div class="row">
                        <div class="col-md-4">
                            <label for=""> Día <span class="text-danger">*</span></label>
                            <select name="day" class="form-control form-control-solid" id="day_edit">
                                <option value="" selected disabled> Seleccione </option>
                                @foreach ($days as $item)
                                    <option value="{{$item->id}}"> {{$item->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for=""> Desde <span class="text-danger">*</span></label>
                            <input type="time" name="from" class="form-control form-control-solid" id="from_edit">
                        </div>
                        <div class="col-md-4">
                            <label for=""> Hasta <span class="text-danger">*</span></label>
                            <input type="time" name="to" class="form-control form-control-solid" id="to_edit">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-end align-items-center">
                            <button class="btn btn-success"> Actualizar </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
