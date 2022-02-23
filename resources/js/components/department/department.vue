<template>
    <div class="col-md-12">
        <div class="tab-content" id="myTabContent">
            <div
                class="tab-pane fade active show"
                id="profile"
                role="tabpanel"
                aria-labelledby="profile-tab"
            >
                <!--tabla de datos-->
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Description</th>
                            <th scope="col">State</th>
                            <th scope="col">
                                <div class="d-flex justify-content-end">
                                    <a
                                        href="#"
                                        class="btn btn-primary btn-sm font-weight-bolder"
                                        data-toggle="modal"
                                        @click="crateDepartment()"
                                    >
                                        <span class="svg-icon svg-icon-md">
                                            <i class="fas fa-plus"></i> </span
                                        >Crear
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="department in data"
                            v-bind:key="department.id"
                        >
                            <td>{{ department.name }}</td>
                            <td>{{ department.description }}</td>
                            <td>
                                <span
                                    v-if="department.state == 1"
                                    class="label label-inline label-light-success font-weight-bold"
                                >
                                    Activo
                                </span>
                                <span
                                    v-if="department.state == 0"
                                    class="label label-inline label-light-danger font-weight-bold"
                                >
                                    Inactivo
                                </span>
                            </td>
                            <td>
                                <div
                                    class="d-flex justify-content-around aling-items-center flex-wrap flex-row"
                                >
                                    <input
                                        type="checkbox"
                                        class="checkbox mt-3"
                                        name="departments[]"
                                        :value="department.id"
                                    />
                                    <a
                                        href="#"
                                        class="btn btn-icon btn-light-success btn-sm mr-2"
                                        data-toggle="modal"
                                        @click.prevent="editDepartment(department)"

                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a
                                        href="#"
                                        role="button"
                                        class="btn btn-icon btn-light-danger btn-sm mr-2"
                                        @click.prevent="removeDepartment(department.id)"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal departament -->
        <modal v-if="showModal" @close="showModal = false">
            <div slot="header" class="d-flex justify-content-between w-100">

                <h4 v-if="methodValue=='POST'" class="card-title">Crear departamento</h4>
                <h4 v-if="methodValue=='PUT'" class="card-title">Editar departamento</h4>
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
            <div class="row" slot="body">
                <form action="" id="formDepartment">
                    <div class="card d-flex flex-row flex-wrap">
                        <div class="form-group col-md-12">
                            <label
                                >Nombres:
                                <span class="text-danger">*</span></label
                            >
                            <input
                                name="name"
                                type="text"
                                class="form-control form-control-solid"
                                placeholder="Nombre"
                                v-model="department.name"
                            />
                            <span class="form-text text-muted"></span>
                        </div>
                        <div v-if="methodValue=='PUT'" class="form-group col-md-12">
                            <label>Estado</label>
                            <select
                                class="form-control form-control-solid"
                                id="document_type"
                                name="state"
                                v-model="department.state"
                            >
                                <option disabled selected>Seleccione</option>
                                <option value="1" >Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Descripción</label>
                            <textarea
                                name="description"
                                class="form-control form-control-solid"
                                cols="30"
                                rows="10"
                                v-model="department.description"
                            >
                            </textarea>
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
                <button type="submit" v-if="methodValue=='POST'"  @click.prevent="addDepartment()"  form="formDepartment" class="btn btn-primary font-weight-bold">
                    Guardar
                </button>
                <button type="submit" v-if="methodValue=='PUT'"  @click.prevent="updateDepartment()"  form="formDepartment" class="btn btn-primary font-weight-bold">
                    Editar
                </button>
            </div>
        </modal>
    </div>
</template>
<script>
import modal from "../modal.vue";
export default {
    components: { modal },
    data() {
        return {
            data: [],
            department: {},
            showModal: false,
            methodValue: 'POST'
        };
    },
    computed: {},
    watch: {},

    methods: {
        async getDepartment() {
            let _this = this;
            let myHeaders = new Headers();
            myHeaders.append("accept", "application/json");
            let requestOptions = {
                method: "GET",
                headers: myHeaders,
            };
            await fetch(`/departamentos`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    _this.data = data.data;
                })
                .catch((err) => console.warn(err));
        },

        async addDepartment() {
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
                body: JSON.stringify(this.department),
            };
            await fetch(`/departamentos`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    let department = data.data;
                    if(data.state == 200){
                        _this.data.push({ ...department, state: 1 });
                        correct(data.message);
                        _this.clearValue();
                        _this.showModal = false;
                    }else{
                        error(data.error);
                    }
                })
                .catch((err) => console.warn(err));
        },
        async editDepartment(departament) {
            this.methodValue='PUT';
            this.department.name = departament.name
            this.department.description =departament.description
            this.department.state =departament.state
            this.department.id =departament.id
            this.showModal = true;
        },

        async  updateDepartment(){
            let _this = this;
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
            myHeaders.append("Accept", "application/json");
            myHeaders.append("Content-Type", "application/json");
            myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "PUT",
                headers: myHeaders,
                body: JSON.stringify(this.department),

            };
            await fetch(`/departamentos/${this.department.id}`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    let department = data.data;
                    if(data.state == 200){
                        // _this.data.push({ ...department, state: 1 });
                          let id = _this.data.findIndex((item) => item.id == _this.department.id);
                            _this.data[id].name=department.name
                            _this.data[id].description=department.description
                            _this.data[id].state=department.state

                        correct(data.message);
                        _this.clearValue();
                    }else{
                        error(data.error);
                    }
                })
                .catch((err) => console.warn(err));
        },

        async removeDepartment(id) {
            let remove = await deleteResource(`/departamentos/${id}}`);
            if (remove) {
                let index = this.data.findIndex((item) => item.id == id);
                this.data.splice(index, 1);
            }
        },
        clearValue() {
            this.department = {};
            this.showModal = false;
        },
        crateDepartment(){
            this.methodValue = 'POST';
            this.showModal = true;
        }
    },
    mounted() {
        this.getDepartment();
    },
};
</script>
