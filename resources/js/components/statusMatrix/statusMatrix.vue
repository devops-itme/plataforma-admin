<template>
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title">Matriz de estados</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <th>Nombre</th>
                                    <th>Ámbito</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody>
                                      <tr
                                        v-for="status in matrix"
                                        v-bind:key="status.id"
                                    >
                                        <td>{{ status.name }}</td>
                                        <td>{{ status.get_scope.name }}</td>
                                        <td>
                                            <a
                                                href="#"
                                                class="btn btn-icon btn-light-success btn-xl mr-2"
                                                @click.prevent="getStatusDescriptors(status.id)"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Descripción - Matriz</h4>
                            </div>
                            <div class="col-md-6" v-if="selectedStatusMatrixId != null">
                                <a
                                    href="#"
                                    class="btn btn-primary btn-sm font-weight-bolder"
                                    data-toggle="modal"
                                    @click="createDescriptor()"
                                >
                                    <span class="svg-icon svg-icon-md">
                                        <i class="fas fa-plus"></i> </span
                                    >Crear o Actualizar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="parameterValueTable">
                                <thead class="text-primary">
                                    <th>Descripción</th>
                                    <th>Rol</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody>
                                     <tr
                                        v-for="descriptor in statusDescriptors"
                                        v-bind:key="descriptor.id"
                                    >
                                        <td>{{ descriptor.description }}</td>
                                        <td>{{ descriptor.get_role.name }}</td>
                                        <td>
                                            <a
                                                href="#"
                                                role="button"
                                                class="btn btn-icon btn-light-danger btn-sm mr-2"
                                                @click="removeDescriptor(descriptor.id)"
                                            >
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Status Descriptor -->
        <modal v-if="showModal" @close="showModal = false">
            <div slot="header" class="d-flex justify-content-between w-100">
                <h4 v-if="methodValue=='POST'" class="card-title">Crear descriptor </h4>
                <h4 v-if="methodValue=='PUT'" class="card-title">Editar descriptor</h4>
                <button
                    type="button"
                    @click="clearValue()"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div slot="body">
                <form action="" id="formDescriptor">
                    <div class="card d-flex flex-row flex-wrap">
                        <div class="form-group col-md-12">
                            <label
                                >Descripción:
                                <span class="text-danger">*</span></label
                            >
                            <input
                                name="description"
                                type="text"
                                class="form-control form-control-solid"
                                placeholder="Descripción"
                                v-model="descriptor.description"
                            />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Role</label>
                            <select name="role_id"  v-model="descriptor.role_id" class="form-control form-control-solid" id="type_doc">
                                <option disabled value="">Seleccione un role</option>
                                <option
                                    v-for="role in roles"
                                    v-bind:key="role.id"
                                    v-bind:value="role.id"
                                    >
                                    {{ role.name }}
                                </option>
                            </select>
                            <span class="form-text text-muted"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div slot="footer">
                <button
                    type="button"
                    class="btn btn-light-primary font-weight-bold"
                    @click="clearValue()"
                >
                    Cerrar
                </button>
                <button type="submit" v-if="methodValue=='POST'"  @click.prevent="addDescriptor()"  form="formDescriptor" class="btn btn-primary font-weight-bold">
                    Guardar
                </button>
                <button type="submit" v-if="methodValue=='PUT'"  @click.prevent="updateDescriptor()"  form="formDescriptor" class="btn btn-primary font-weight-bold">
                    Editar
                </button>
            </div>
        </modal>
    </div>

</template>

<script>
import modal from '../modal.vue';
export default {
    components: { modal },
    props: ['matrix', 'roles'],
    data() {
        return {
            statusDescriptors: [],
            selectedStatusMatrixId: null,
            showModal:false,
            methodValue: 'POST',
            descriptor:{},
        };
    },
    methods: {
        async getStatusDescriptors(id) {
            let req = await fetch(`/descriptor-estado/${id}`);
            let res = await req.json();
            this.statusDescriptors = res.data;
            this.selectedStatusMatrixId = id;

        },

        createDescriptor(){
            this.methodValue = 'POST';
            this.showModal = true;
        },

        async addDescriptor(){
            let response = await this.requestStoreDescriptor();
            let descriptor = response.data;
            if(response.state == 200){
                let id = this.statusDescriptors.findIndex((item) =>  item.id == descriptor.id);
                 console.log(descriptor);
                if(id == -1){
                    this.statusDescriptors.push(descriptor);
                    // location.reload();
                }else{
                    this.statusDescriptors[id].description=descriptor.description
                    this.statusDescriptors[id].role_id=descriptor.role_id
                }
                correct(response.message);
                this.clearValue();
                this.showModal = false;
            }else{
                error(response.message);
            }
        },
        async requestStoreDescriptor() {
            let response = {state: 500}
            let status_matrix_id = this.selectedStatusMatrixId;
            let _this = this;
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
            myHeaders.append("Accept", "application/json");
            myHeaders.append("Content-Type", "application/json");
            myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "POST",
                headers: myHeaders,
                body: JSON.stringify(this.descriptor),
            };
            await fetch(`/descriptor-estado/${status_matrix_id}`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    response = data;
                })
                .catch((err) => console.warn(err));

             return response;
        },
        async updateDescriptor(){},

        async removeDescriptor(id) {
            let remove = await deleteResource(`/descriptor-estado/${id}`);
            if (remove) {
                let index = this.statusDescriptors.findIndex((item) => item.id == id);
                this.statusDescriptors.splice(index, 1);
            }
        },
        clearValue() {
            this.descriptor = {};
            this.showModal = false;
        }


    },
    mounted() {

    },
};
</script>
