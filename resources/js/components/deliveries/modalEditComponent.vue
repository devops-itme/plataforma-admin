<template>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar destinos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="false">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="d-flex flex-row flex-wrap">
                <h5 class="my-4 font-weight-bold text-dark col-md-12">Información de destino</h5>
                <div class="form-group col-md-4">
                    <label>Cliente: </label>
                    <input name="customer" type="text" class="form-control form-control-solid" disabled />
                    <span class="form-text text-muted"></span>
                    <!-- <p v-text="showGuide"></p> -->
                </div>
                <div class="form-group col-md-4">
                    <label>Saldo Cantidad: </label>
                    <input name="quantity_ballance" type="number" class="form-control form-control-solid" value="0" disabled />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Saldo Dinero: </label>
                    <input name="money_ballance" type="number" class="form-control form-control-solid" value="20.00" disabled />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="separator separator-solid separator-border-3 col-12 mb-3"></div>
                <h5 class="my-4 font-weight-bold text-dark col-md-12">Contenido a editar</h5>
                <div class="form-group col-md-6">
                    <label>Dirección: </label>
                    <input name="address" type="text" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="type_doc">Tipo de documento </label>
                    <select name="document_type" class="form-control form-control-solid" id="type_doc">
                        <option
                            v-for="document_type in document_types"
                            v-bind:key="document_type.id"
                            v-bind:value="document_type.id"
                            >
                            {{ document_type.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Concepto: </label>
                    <input name="concept" type="text" class="form-control form-control-solid" value="Tarjetas de crédito" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="type_doc">Barrio </label>
                    <select name="location" class="form-control form-control-solid" id="location">
                        <option selected>Seleccione Barrio</option>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="type_doc">Medio de pago </label>
                    <select name="location" class="form-control form-control-solid" id="location">
                        <option
                            v-for="payment_method in payment_methods"
                            v-bind:key="payment_method.id"
                            v-bind:value="payment_method.id"
                            >
                            {{ payment_method.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="type_doc">Transporte </label>
                    <select name="transport" class="form-control form-control-solid" id="transport">
                        <option
                            v-for="transport_type in transport_types"
                            v-bind:key="transport_type.id"
                            v-bind:value="transport_type.id"
                            >
                            {{ transport_type.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="type_doc">Tarifa </label>
                    <select name="rate" class="form-control form-control-solid" id="rate">
                        <option selected>Adicional</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Valor: </label>
                    <input name="value" type="number" class="form-control form-control-solid text-right" value="20.00" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Valor Corp: </label>
                    <input name="corp_value" type="number" class="form-control form-control-solid text-right" value="20.00" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Contacto: </label>
                    <input name="contact" type="text" class="form-control form-control-solid" value="Evelin Castro" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Contacto Teléfono: </label>
                    <input name="contact_phone" type="tel" class="form-control form-control-solid" value="30123123" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Contacto email: </label>
                    <input name="contact_mail" type="email" class="form-control form-control-solid" value="maiol@correo.co" />
                    <span class="form-text text-muted"></span>
                </div>
                 <div class="form-group col-md-4">
                    <label>Programado (Fecha-Hora): </label>
                    <input name="corp_value" type="datetime-local" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary">Guardar</button>
        </div>
        </div>
    </div>
    </div>
</template>
<script>
export default {
    props: {
       document_types:Array,
       transport_types:Array,
       payment_methods:Array,
       showGuide:Object
    },

    data() {
        return {
            selected: 1,
        }
    },

}
</script>
