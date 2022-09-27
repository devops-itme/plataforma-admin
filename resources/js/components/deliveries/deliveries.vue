<!-- This is source file -->
<template>
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Despachos Packing</h3>
            </div>
        </div>
        <div class="card-body">
            <div
                class="d-flex align-items-center justify-content-between flex-row flex-wrap mb-3"
            >
                <div class="form-group col-md-2 mb-0">
                    <select class="form-control" v-model="selected" @change="loadingEvt(),getGuides(selected)">
                        <option
                            v-for="item of delivery_types"
                            v-bind:key="item.value"
                            v-bind:value="item.value"
                        >
                            {{ item.text }}
                        </option>
                    </select>
                </div>
            </div>
            <ul
                class="nav nav-tabs nav-tabs-line nav-tabs-line-3x nav-bolder"
                id="myTab"
                role="tablist"
            >
                <li  class="nav-item"  v-for="(tab) in tabs" :key="tab.id" >
                    <a
                    class="nav-link tablink"
                    @click="getGuides(tab.id)"
                    :class="{'active': type_guide === tab.id}"
                    :id="tab.id"  data-toggle="tab"
                    :href="`#${tab.href}`"
                    v-text=tab.name></a>
                </li>
            </ul>
           <div class="d-flex flex-row flex-wrap">
                <div class="col-md-9">
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active"
                    id="porRecoger"
                    role="tabpanel"
                    aria-labelledby="porRecoger-tab">
                    <!-- Draggable component -->
                    <draggables :selected=selected @getGuide="getGuide" :guides=guides :guides2=guides2 :tabs=tabs :messengers=messengers ref="childcomponent"></draggables>

                </div>
                <div
                    class="tab-pane fade"
                    id="enproceso"
                    role="tabpanel"
                    aria-labelledby="enproceso-tab"
                >
                    <!-- In process table -->
                    <tabledy :rows=columns.inProcess.length @getGuide="getGuide" :guides=guides :tabs=tabs :columnsNames=columns.inProcess :widthTable=1100 :typeGuide="type_guide"></tabledy>
                </div>
                <div
                    class="tab-pane fade"
                    id="consultas"
                    role="tabpanel"
                    aria-labelledby="consultas-tab"
                >
                    <!-- Queries and Edit table -->
                    <tabledy :rows=columns.inEdit.length @getGuide="getGuide" :guides=guides :tabs=tabs :columnsNames=columns.inEdit :widthTable=1600 :typeGuide="type_guide"></tabledy>
                </div>
            </div>
            </div>
            <div class="col-md-3 py-4">
             <div class="d-flex ">
                <div class="mr-auto ">
                <button style="width:110%" v-if="type_guide === tabEdition" type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-light-primary btn-lg font-weight-bold "  @click.prevent="editGuide()">Editar Destino</button>
                </div>
                <div class="mr-auto " >
                <button style="width:150%" v-if="type_guide === tabEdition" type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-light-primary btn-lg font-weight-bold "  @click.prevent="editGuideHistory()">Historial</button>
                </div>
            </div>
                <div class="d-flex flex-row flex-wrap scroll scroll-pull mt-3 mb-3 border py-2 max-h-250px">
                    <h5 class="mb-5 font-weight-bold text-dark col-md-12">Información de Destino</h5>
                     <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Tipo de orden:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.type_order"></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.client_name"></div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.client_last_name"></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Destino:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.posting"></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Despacho:</div>
                        <div class="line-height-xl" v-if="showDataGuide"  v-text="showDataGuide.dispatched ? showDataGuide.dispatched: 'No registra'"></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Ref.Cliente:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.ref_client ? showDataGuide.ref_client: 'No registra'"></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Programado:</div>
                        <div class="line-height-xl"  v-if="showDataGuide"  v-text="showDataGuide.programming">2022/02/04</div>
                    </div>
                     <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Nombre de Contacto:</div>
                        <div class="line-height-xl"  v-if="showDataGuide"  v-text="showDataGuide.contact"></div>
                    </div>
                     <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Teléfono Contacto:</div>
                        <div class="line-height-xl"  v-if="showDataGuide"  v-text="showDataGuide.contact_phone"></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">Transporte:</div>
                        <div class="line-height-xl"  v-if="showDataGuide"  v-text="showDataGuide.transport ? showDataGuide.transport: 'No registra' " ></div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="font-weight-bolder mb-1">H.Entrega:</div>
                        <div class="line-height-xl"  v-if="showDataGuide"  v-text="showDataGuide.schedule_time_range" ></div>
                    </div>
                    <div class="col-md-12 mb-2" v-if="showDataGuide.movil">
                        <div class="font-weight-bolder mb-1">Movil:</div>
                        <div class="line-height-xl" v-if="showDataGuide"  v-text="showDataGuide.movil"></div>
                    </div>
                    <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente Depto:</div>
                        <div class="line-height-x1" v-if="showDataGuide" v-text="showDataGuide.client_depto ? showDataGuide.client_depto: 'No registra'" >84: PRINCIPAL</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente Sucursal:</div>
                        <div class="line-height-x1" v-if="showDataGuide" v-text="showDataGuide.client_branch_office ? showDataGuide.client_branch_office: 'No registra'">1179: PRINCIPAL</div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Cliente Documento:</div>
                        <div class="line-height-x1" v-if="showDataGuide" v-text="showDataGuide.client_document ? showDataGuide.client_document: 'No registra'" >1191: DELIVERY</div>
                    </div>
                    <div class="separator separator-dashed separator-border-2 col-md-12 my-3"></div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Concepto:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.concept ? showDataGuide.concept: 'No registra'"></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Dirección:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.direction"></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Teléfono adicional:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.additional_phone ? showDataGuide.additional_phone : 'No registra' "></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Correo adicional:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.additional_email ? showDataGuide.additional_email : 'No registra'"></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Dirección adicional:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.additional_address ? showDataGuide.additional_address : 'No registra'"></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Leído:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.app_status ? 'Sí' : 'No'"></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Estado:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.status ? showDataGuide.status : 'No registra' "></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Incidencias:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.issue ? showDataGuide.issue : 'No registra'"></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Novedades:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.novelty ? showDataGuide.novelty : 'No registra' "></div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="font-weight-bolder mb-1">Nombre quien Entrega/Recibe:</div>
                        <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.recipient_name ? showDataGuide.recipient_name : 'No registra' "></div>
                    </div>
                </div>
                <div class=" max-h-200px mb-3 pb-3 justify-content-center">
                    <h5 class="mb-5 font-weight-bold text-dark col-md-12">Adjuntos</h5>
                    <div class="col-md-12 row symbol-group symbol-hover">
                        <div class="col-12">
                            <div class="font-weight-bolder">Imágenes del paquete a entregar</div>
                            <div v-if="Array.isArray(showDataGuide.package_pictures) && showDataGuide.package_pictures.length  == 0">
                                No hay imágenes del paquete a entregar
                            </div>
                            <div class="d-flex flex-wrap max-h-200px justify-content-center">
                                <div class="symbol" v-for="item in showDataGuide.package_pictures" v-bind:key="item.id">
                                    <a :href="item.file_url" target="_blank" rel="noopener noreferrer">
                                    <img height="50px" width="50px" alt="Pic" :src="item.file_url"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="font-weight-bolder">Evidencias de entrega</div>
                            <div v-if="Array.isArray(showDataGuide.evidence) && showDataGuide.evidence.length  == 0">
                                No hay evidencias de entrega
                            </div>
                            <div class="d-flex flex-wrap max-h-200px justify-content-center">
                                <div class="symbol" v-for="item in showDataGuide.evidence" v-bind:key="item.id">
                                    <a :href="item.file_url" target="_blank" rel="noopener noreferrer">
                                    <img height="50px" width="50px" alt="Pic" :src="item.file_url"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           </div>
        </div>
        <!-- EDITAR -->
        <modalEdit
            v-if="showModal"
            @close="showModal = false">
        <div slot="header">
            <h5 class="modal-title" id="exampleModalLabel">Editar destinos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div slot="body">
            <div class="d-flex flex-row flex-wrap">
                <h5 class="my-4 font-weight-bold text-dark col-md-12">Información de destino</h5>
                <div class="form-group col-md-4">
                    <label>Cliente: </label>
                    <input name="customer" type="text" class="form-control form-control-solid" v-model="guide.client" disabled />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Saldo Cantidad: </label>
                    <input name="quantity_ballance" type="number" class="form-control form-control-solid" v-model="guide.balance" disabled />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Saldo Dinero: </label>
                    <input name="money_ballance" type="number" class="form-control form-control-solid" v-model="guide.balance_money" disabled />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="separator separator-solid separator-border-3 col-12 mb-3"></div>
                <h5 class="my-4 font-weight-bold text-dark col-md-12">Contenido a editar</h5>
                <div class="form-group col-md-6">
                    <label>Dirección: </label>
                    <input name="address" type="text" v-model="guide.address" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="type_doc">Tipo de documento </label>
                    <select name="document_type"  v-model="guide.document_type" class="form-control form-control-solid" id="type_doc">
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
                    <input name="concept" type="text" class="form-control form-control-solid" v-model="guide.concept" />
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
                    <select name="location" v-model="guide.payment_method"  class="form-control form-control-solid" id="location">
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
                    <select name="transport" v-model="guide.transport_type"  class="form-control form-control-solid" id="transport">
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
                    <input name="value" type="number" class="form-control form-control-solid text-right" v-model="guide.value"  />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Valor Corp: </label>
                    <input name="corp_value" type="number" class="form-control form-control-solid text-right" v-model="guide.value_corp"  />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Contacto: </label>
                    <input name="contact" type="text" class="form-control form-control-solid" v-model="guide.contact" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Contacto Teléfono: </label>
                    <input name="contact_phone" type="tel" class="form-control form-control-solid" v-model=" guide.contact_phone "  />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Contacto email: </label>
                    <input name="contact_mail" type="email" class="form-control form-control-solid" v-model="guide.contact_email" />
                    <span class="form-text text-muted"></span>
                </div>
                 <div class="form-group col-md-4">
                    <label>Programado (Fecha): </label>
                    <input name="schedule_date" type="date"  v-model="guide.schedule_date" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Telefono adicional: </label>
                    <input name="additional_phone" type="text"  v-model="guide.additional_phone" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Correo adicional: </label>
                    <input name="additional_email" type="text"  v-model="guide.additional_email" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Dirección adicional: </label>
                    <input name="additional_address" type="text"  v-model="guide.additional_address" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <label>Novedades: </label>
                    <!-- <input name="novelty" type="text"  v-model="guide.novelty" class="form-control form-control-solid" /> -->
                    <textarea name="novelty" id="novelty" v-model="guide.novelty" class="form-control form-control-solid"></textarea>
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-4">
                    <div class="font-weight-bolder mb-1">Leído:</div>
                    <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.app_status ? 'Sí' : 'No' "></div>
                </div>
                <div class="form-group col-md-4">
                    <div class="font-weight-bolder mb-1">Estado:</div>
                    <div class="line-height-xl" v-if="showDataGuide" v-text="showDataGuide.status ? showDataGuide.status : 'No registra' "></div>
                </div>
            </div>
        </div>
        <div slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="updateGuide()">Guardar</button>
        </div>
        </modalEdit>


<!-- HISTORIAL -->
        <modalHistory
            v-if="showModalHistory"
            @close="showModalHistory = false">
        <div slot="header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Historial</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div slot="body">
    <div class="d-flex flex-row flex-wrap">

        <div class="form-group  ">
            <div class="d-flex ">
                <div  style="width:200%;margin-left:1.5%;margin-top:1.5%">
                    <label><strong> No Guia: </strong> </label>
                </div>
                <div>
                <input name="customer" type="text" class=" form-control form-control-solid" style="margin-left:-650%;width:200%" v-model="guide.id" disabled />
                    <span class="form-text text-muted"></span>
                </div>


                <div  style="width:250%;margin-top:1.5%;margin-right:-105%">
                    <label><strong>Seleccionar incidencia <span class="text-danger">*</span> </strong></label>
                </div>
                <div>
                <select name="issue_id" v-model="guide.issue"   class="form-control form-control-solid" style="margin-left:180%;width:290%" id="issue">
                        <option
                            v-for="issue in issues"
                            v-bind:key="issue.id"
                            v-bind:value="issue.id"
                            >
                            {{ issue.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
                <div class="form-group col-md-12">
                    <label><strong>Novedades <span class="text-danger">*</span> </strong></label>
                    <input name="novelty" type="text" v-model="guide.novelty" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-12">
                    <label><strong>Nombre quién Entrega/Recibe <span class="text-danger">*</span></strong></label>
                    <input name="recipient_name" type="text" class="form-control form-control-solid" v-model="guide.recipient_name" />
                    <span class="form-text text-muted"></span>
                </div>
                <div class="form-group col-md-12">
                    <label><strong>Dirección adicional <span class="text-danger">*</span></strong></label>
                    <input name="additional_address" type="text" v-model="guide.additional_address" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div>
               <!-- <div class="form-group col-md-12">
                    <label><strong>Incidencia<span class="text-danger">*</span></strong></label>
                    <input name="address" type="text" v-model="guide.issue" class="form-control form-control-solid" />
                    <span class="form-text text-muted"></span>
                </div> -->
            <div class="d-flex ">
                <div  style="width:200%;margin-left:185%;margin-top:1.5%">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="updateGuideLog()">Guardar</button>
                </div>
                <div  style="width:300%;margin-top:1.5%;margin-left:375%">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" v-on:click="clear()" >Limpiar</button>
                </div>
            </div>

                 <div style="margin-top:2%" class=" separator separator-solid separator-border-3 col-12 mb-3"></div>
                  <div class="form-group col-md-12">
                    <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Despacho</th>
                            <th>Recogida/Entrega</th>
                            <th>Estado</th>
                            <th>Estado Web</th>
                            <th>Usuario creación</th>
                            <th>Fecha creación</th>
                            <th>Fecha modificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center" v-for="guide_log, index in  guide_logs ? guide_logs.slice().reverse() : []"  >
                            <td>{{ guide_log.id }}</td>
                            <td>{{ guide_log.get_guide.dispatched }}</td>
                            <td>{{ guide_log.get_state.scope_id == 56 ? 'RECOGIDA' : 'ENTREGA'}}</td>
                            <td>{{ guide_log.get_state.name  }}</td>
                            <td>{{ guide_log.get_guide.app_status ? 'Leido' : 'Pendiente' }}</td>
                            <td v-if="guide_log.get_guide.get_order.get_user.name != null">{{ guide_log.get_guide.get_order.get_user.name + ' ' + guide_log.get_guide.get_order.get_user.last_name }}</td>
                            <td v-if="guide_log.get_guide.get_order.get_user.name == null">{{ guide_log.get_guide.get_order.get_user.get_customer.tradename }}</td>
                            <td>{{ guide_log.created_at.slice(0, 10) }}</td>
                            <td>{{ guide_log.updated_at.slice(0, 10) }}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div slot="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="">Aceptar</button>
        </div>
        </modalHistory>

    </div>
</template>
<script>
import moment from 'moment';
import draggables from "./draggable.vue";
import tabledy from "./tableDynamic.vue";
import modalEdit from "./modalEditComponent.vue";
import modalHistory from "./modalEditHistory.vue";
export default {
    components: {
        draggables,
        tabledy,
        modalEdit,
        modalHistory
    },
    data() {
        return {
            selected_filter_status: "",
            selected: 56,
            delivery_types: [
                { value: 57, text: "Entregas" },
                { value: 56, text: "Recogidas" },
            ],
            showModal: false,
            showModalHistory: false,
            columns:{
                inProcess:["Tipo", "Estado", "Fecha evento", "Despacho", "Destino", "F.Prog", 'H.Entrega', "Mensajero", "Estado App", "Cliente", "Contacto", "Barrio/Zona", "Dirección"],
                inEdit:["Tipo", "Estado", "Fecha evento", "Despacho", "Destino", "F.Prog", 'H.Entrega', "Mensajero", "Estado App", "Cliente", "Contacto", "Barrio/Zona", "Dirección",],
            },
            guides: [],
            guides2: [],
            messengers: [],
            type_guide: 3,
            showGuide: null,
            showDataGuide: {},
            activeIndex: 2,
            tabs: [],
            if_route: false,
            if_department: false,
            guide:{},
            document_types:null,
            transport_types:null,
            payment_methods:null,
            showModal:false,
            showModalHistory:false,
            guide_logs: null
        };
    },
    computed:{
        tabEdition(){
            return this.tabs[2]?.id;
        },
        guides_bydate() {

            return this.guides.sort((a, b) => b.updated_at.localeCompare(a.updated_at));
        },
    },
    watch:{

    },
    methods: {
        loadingEvt (){
            this.selected_filter_status = "";
           $(`#myTab li:nth-child(1) a`).tab("show");
       },
        async statusMatrix(scope) {
            //STATUS MATRIX
            let req = await fetch(`despacho/matriz_estados?scope_id=${scope}`);
            let res = await req.json();
            // take the first 3 data from the consulate
            this.tabs = await res.data.slice(0, 3);
            //#HREF TAB
            this.tabs[0].href = "porRecoger";
            this.tabs[1].href = "enproceso";
            this.tabs[2].href = "consultas";

            //NAME TABS
            this.tabs[2].name = "CONSULTA Y EDICIÓN";
            this.selected == 56?  this.tabs[1].name = "RECOGIDA EN PROCESO" : this.tabs[1].name = "ENTREGA EN PROCESO";
            this.selected == 56?  this.tabs[0].name = "POR RECOGER" : this.tabs[0].name = "POR ENTREGAR";
        },


        getGuide(data){
            this.showGuide = data;
            this.showDataGuide.type_order = data.get_order?.get_order_type.name;
            this.showDataGuide.client_name = data.get_order?.get_user.name;
            this.showDataGuide.client_last_name = data.get_order?.get_user.last_name;
            this.showDataGuide.posting = data?.id;
            this.showDataGuide.id = this.showDataGuide.posting;
            this.showDataGuide.dispatched = data.dispatched;
            this.showDataGuide.ref_client = data.get_order?.get_user.document_number;
            this.showDataGuide.programming = data.get_order.schedule_date;
            this.showDataGuide.transport =  data.get_transport_type?.name;
            this.showDataGuide.movil = data.get_route&&(data.get_route?.get_messenger?.name+' '+data.get_route?.get_messenger?.last_name);
            this.showDataGuide.client_depto = data.get_branch_office?.get_department?.get_department?.id+':'+data.get_branch_office?.get_department?.get_department?.name ? this.showDataGuide.client_depto: 'No registra';
            this.showDataGuide.client_branch_office = data.get_branch_office?.id+': '+data.get_branch_office?.name ? this.showDataGuide.client_branch_office: 'No registra';
            this.showDataGuide.client_document = data.get_order?.get_user.document_number;
            this.showDataGuide.concept = data.concept;
            this.showDataGuide.direction = data.address_name;
            this.showDataGuide.contact = this.showGuide.contact;
            this.showDataGuide.recipient_name = data?.recipient_name;
            this.showDataGuide.contact_phone = this.showGuide.phone_contact;
            this.showDataGuide.additional_phone = data.additional_phone;
            this.showDataGuide.additional_email = data.additional_email;
            this.showDataGuide.additional_address = data.additional_address;
            this.showDataGuide.app_status = data.app_status;
            this.showDataGuide.status = data.get_status_matrix.name;
            this.showDataGuide.novelty = data?.novelty;
            this.showDataGuide.novelty_history = this.showDataGuide.novelty;
            this.showDataGuide.files = data.get_documents;
            this.showDataGuide.evidence = data.get_documents?.filter(element => element.type != 74);
            this.showDataGuide.package_pictures = data.get_documents?.filter(element => element.type == 74);
            this.showDataGuide.issue = data?.get_issue?.get_issue?.name ?? 'No registra';
            this.showDataGuide.issue_id = data?.get_issue?.get_issue?.id ?? 'No registra';
            this.showDataGuide.schedule_time_range = data.get_order.schedule_time_range;
            this.showDataGuide.logs = this.guide_logs;
        },
        async getGuides(type, changeType = true) {
            this.guides2 = [];
            this.showGuide = null;
            this.showDataGuide = {
                type_order: null,
                client: null,
                posting: null,
                dispatched: null,
                ref_client: null,
                programming: null,
                transport: null,
                movil: null,
                client_depto: null,
                client_branch_office: null,
                client_document: null,
                concept: null,
                direction: null,
            },
            this.guide = {};
            this.statusMatrix(this.selected);
            type == 56 && (type = 3);
            type == 57 && (type = 7);
            let response = await this.requestGuides(type);
            if(changeType){
                this.type_guide = type;
            }
            this.guides = response.data;

        },
        async requestGuides(type) {

            let response = { state: 500 };
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };

            await fetch(`/orders_packing/${type}`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    response = data;
                })
                .catch((err) => console.warn(err));

            return response;

        },
        async getMessengers() {
            let _this = this;
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            await fetch(`/messengers_delivery`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    _this.messengers = data.data;
                })
                .catch((err) => console.warn(err));
        },
         async editGuide() {
            if (!this.showGuide) {
                return await error("Debe seleccionar una guía");
            }
             this.guide.id = this.showDataGuide.posting;
            let programming_date = this.showGuide.get_order.schedule_date+' '+this.showGuide.get_order.schedule_time;
            this.showModal = true;
            this.guide.client =  this.showGuide.get_order?.get_user.name;
            this.guide.balance  = 0;
            this.guide.balance_money  = 0;
            this.guide.address = this.showGuide.address_name;
            this.guide.document_type = this.showGuide.customer_document_type;
            this.guide.concept = this.showGuide.concept;
            this.guide.payment_method = this.showGuide.get_order.payment_method;
            this.guide.transport_type = this.showGuide.transport_type;
            this.guide.value = this.showGuide.value;
            this.guide.value_corp = this.showGuide.corp_value;
            this.guide.contact = this.showGuide.contact;
            this.guide.contact_phone = this.showGuide.phone_contact;
            this.guide.contact_email = this.showGuide.email_contact;
            this.guide.programming = moment(programming_date).format("YYYY-MM-DDTHH:mm");
            this.guide.schedule_date = this.showGuide.get_order.schedule_date
            this.guide.additional_phone = this.showGuide.additional_phone;
            this.guide.additional_email = this.showGuide.additional_email;
            this.guide.additional_address = this.showGuide.additional_address;
            this.guide.app_status = this.showGuide.app_status;
            this.guide.status = this.showGuide.get_status_matrix.name;
            this.guide.novelty = this.showGuide.novelty;
            this.guide.issue = this.showGuide.issue;
        },


            async editGuideHistory(data) {

            if (!this.showGuide) {
                return await error("Debe seleccionar una guía");
            }else{
                this.showModalHistory = true;
                this.guide.id = this.showDataGuide.posting ?? 'No registra';
                let id = this.showDataGuide.id;
                this.guide.issue = this.showDataGuide.issue_id ;
                this.guide.novelty = this.showDataGuide.novelty ;
                // console.log(this.guide.novelty);
                this.guide.recipient_name = this.showDataGuide.recipient_name ;
                this.guide.additional_address =  this.showDataGuide.additional_address ;
                let  response = await this.guideLogs(id);

            if (response != '') {
                this.showModalHistory = false;
                this.open();
                this.guide_logs = response.data;
            }
            }
        },

        open (){
            this.showModalHistory = true;
        },

        async documentTypes() {
            let name = "customer_document_type";
            let req = await fetch(`/api/parameter_values?parameter_name=${name}`);
            let res = await req.json()
            this.document_types = res.data;
        },

         async transportTypes() {
            let name = "transport_type";
            let req = await fetch(`/api/parameter_values?parameter_name=${name}`);
            let res = await req.json()
            this.transport_types = res.data;
        },

           async issues() {
            let name = "issues";
            let req = await fetch(`/api/parameter_values?parameter_name=${name}`);
            let res = await req.json()
            this.issues = res.data;
        },

      async  guideLogs(guide_id) {
          let response = { state: 500 };
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
           await  fetch(`/api/get_guides?guide_log=${guide_id}`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    response = data;
                    // console.log(response)
                })
                .catch((err) => console.warn(err));
            return response;
        },


        async paymentMethods() {
            let name = "payment_method";
            let req = await fetch(`/api/parameter_values?parameter_name=${name}`);
            let res = await req.json()
            this.payment_methods = res.data;
        },
        async updateGuide(){
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
                myHeaders.append("Accept", "application/json");
                myHeaders.append("Access-Control-Allow-Origin", "*");
                myHeaders.append('Content-Type', "application/x-www-form-urlencoded");
                myHeaders.append('Content-Type', "application/json");
                myHeaders.append('Content-Type', "multipart/form-data");
                myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify(this.guide)
            };
            let response = await this.requestUpdateGuide(requestOptions);
            if(response.state != 200){
                alert(response.message);
            }
            alert(response.message);
            this.showModal = false;
        },
        async requestUpdateGuide(requestOptions){
            let response = {
                'state': 500
            };
            await fetch("/guide/update", requestOptions)
                .then((response) => response.json())
                .then(data => {
                    response = data
                })
                .catch(e => console.log('requestUpdateGuide',e));
            return response;
        },


        async updateGuideLog(){
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
                myHeaders.append("Accept", "application/json");
                myHeaders.append("Access-Control-Allow-Origin", "*");
                myHeaders.append('Content-Type', "application/x-www-form-urlencoded");
                myHeaders.append('Content-Type', "application/json");
                myHeaders.append('Content-Type', "multipart/form-data");
                myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify(this.guide)
            };
            let response = await this.requestUpdateGuideLog(requestOptions);
            if(response.state != 200){
                alert(response.message);
            }
            alert(response.message);
            this.showModal = false;
        },
        async requestUpdateGuideLog(requestOptions){
            let response = {
                'state': 500
            };
            await fetch("/guide/update/issue", requestOptions)
                .then((response) => response.json())
                .then(data => {
                    response = data
                })
                .catch(e => console.log('requestUpdateGuideLog',e));
            return response;
        }
    },

    async mounted() {
        this.getGuides(3);
        this.getMessengers();
        this.documentTypes();
        this.transportTypes();
        this.paymentMethods();
        this.issues();
    },
};
</script>
