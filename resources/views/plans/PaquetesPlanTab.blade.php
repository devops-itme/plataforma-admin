<div class="card card-custom col-md-12 ">
    <div class="card-header d-flex flex-row flex-wrap justify-content-end aling-items-center">
        <div class="card-title">
            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseConsumo"
                    aria-expanded="false" aria-controls="collapseExample">
                    Modo de Consumos
                </button>
            </p>
        </div>
    </div>


    <div class="collapse" id="collapseConsumo">
        <div class="card-body pt-2">
            <form action="form">
                <div class="row d-flex flex-row flex-wrap">
                    <div class="col-md-6 border-right">
                        <div class="d-flex flex-row flex-wrap">
                            <h5 class="my-4 font-weight-bold text-dark col-md-12">Modo de Consumo</h5>
                            <div class="form-group col-md-12">
                                <select name="lista" class="form-control" id="listaConsumo"
                                    style="width: 100%; height: 60%"></select>
                            </div>

                            <div class="form-group col-md-6 d-flex">
                                <div class="form-group">
                                    <label>Saldo Mínimo:</label>
                                    <input type="text" class="form-control form-control-solid" name="name" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 d-flex">
                                <div class="form-group">
                                    <label>Des/to X:</label>
                                    <input type="text" class="form-control form-control-solid" name="name" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 d-flex">
                                <div class="form-group">
                                    <label>Cantidad:</label>
                                    <input type="text" class="form-control form-control-solid" name="name" value="" />
                                    <span class="form-text text-muted"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 d-flex">
                                <div class="form-group">
                                    <label>Valor Unidad:</label>
                                    <input type="text" class="form-control form-control-solid" name="name"
                                        value="{{ old('name') }}" />
                                    <span class="form-text text-muted"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                        <div class="d-flex flex-row flex-wrap">
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <label class="checkbox">
                                        <input type="checkbox" class="form-control" id="check">
                                        <span class="mr-2"></span>
                                        Activo
                                    </label>

                                    <label class="checkbox my-4">
                                        <input type="checkbox" class="form-control" id="check">
                                        <span class="mr-2"></span>
                                        Impuesto incluido
                                    </label>

                                    <label class="checkbox mb-4">
                                        <input type="checkbox" class="form-control" id="check">
                                        <span class="mr-2"></span>
                                        Días Vence
                                    </label>

                                    <input type="number" class="form-control" value="1" min="1" style="width: 100px">
                                </div>
                            </div>
                            <div class="form-group col-md-6 d-flex flex-row">
                                <div class="col-6">
                                    <label for="label">Impuesto %</label>
                                    <label for="label" class="my-5">Valor Impuesto</label>
                                    <label for="label">Valor Total</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="text" id=""
                                        style="width: 120px; height: 20%">
                                    <input type="text" class="form-control my-2" name="text" id=""
                                        style="width: 120px; height: 20%">
                                    <input type="text" class="form-control" name="text" id=""
                                        style="width: 120px; height: 20%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col-2">Empresa</th>
                <th scope="col-5">GrupoId</th>
                <th scope="col-2">GrupoNombre</th>
                <th scope="col-2">ID</th>
                <th scope="col-2">Nombre</th>
                <th scope="col-2">FullName</th>
                <th scope="col-2">SaldoMinimo</th>
                <th scope="col-2">X100Descuento</th>
                <th scope="col-2">ImpstoInc</th>
                <th scope="col-2">Valor</th>
                <th scope="col-2">Cantidad</th>
            </tr>
        </thead>
        <tbody class="bg-gray-200">
            <tr>
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
