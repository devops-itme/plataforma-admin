<table class="table table-sm table-hover">
    <thead class="thead-light">
        <tr class="text-center">
            <th scope="col">Orden</th>
            <th scope="col">Cliente</th>
            <th scope="col">Fecha</th>
            <th scope="col">Valor</th>
            <th scope="col">Barrios</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <tr>
            <td>104-00332345</td>
            <td>Juanito Perez</td>
            <td>01/23 | 07:00</td>
            <td>40.00</td>
            <td>Boston City</td>
        </tr>
        <tr>
            <td>107-00332355</td>
            <td>Juanito Perez</td>
            <td>01/22 | 07:00</td>
            <td>50.00</td>
            <td>Panama City</td>
        </tr>
        <tr>
            <td>104-00332344</td>
            <td>Bob Scott</td>
            <td>02/10 | 07:00</td>
            <td>30.00</td>
            <td>Boston City</td>
        </tr>
    </tbody>
</table>
<div class="separator separator-solid separator-border-4 my-3"></div>
<div class="d-flex flex-row flex-wrap align-items-stretch">
    <a href="#" class="btn btn-light-primary d-flex align-items-center btn-lg col-md-2">
        <span class="svg-icon">
            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Design/Flatten.svg-->
            <i class="fad fa-globe-americas"></i>
            <!--end::Svg Icon-->
        </span>Ver mapa</a>
    <div class="col-md-10">
        <div class="d-flex flex-row flex-wrap">
            <div class="col-md-5">
                <p class="mb-0">
                    <span class="font-weight-bolder mb-3">Orden seleccionada: </span>
                    <span class="line-height-xl">104-00333333</span>
                </p>
                <p class="mb-0">
                    <span class="font-weight-bolder mb-3">Mensajero Nro: </span>
                    <span class="line-height-xl">9013</span>
                </p>
                <p class="mb-0">
                    <span class="font-weight-bolder mb-3">Frank De Jesus Navarro Reyes</span>
                </p>
            </div>
            <div class="col-md-7">
                <p class="mb-0 text-right">
                    <span class="font-weight-bolder mb-3">Cantidad: </span>
                    <span class="line-height-xl">7</span>,
                    <span class="font-weight-bolder mb-3">Valor: </span>
                    <span class="line-height-xl">$120.00</span>
                </p>
                <div class="d-flex flex-row flex-wrap align-items-center justify-content-between">
                    <div class="form-group col-md-8 mb-0 py-0">
                        <label>Pago por:</label>
                        <div class="radio-inline">
                            <label class="radio radio-rounded">
                                <input type="radio" checked="checked" name="pay_comision" value="1"
                                     />
                                <span></span>
                                Comisón
                            </label>
                            <label class="radio radio-rounded">
                                <input type="radio" name="pay_comision" value="0" />
                                <span></span>
                                Exclusividad
                            </label>
                        </div>
                        <span class="form-text text-muted"></span>
                    </div>
                   <div class="col-md-3">
                    <a href="#" class="btn btn-light-success font-weight-bold mr-2">Despachar</a>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
