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
                                        data-target="#modalCreateDep"
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
                                    v-if="department.state == 2"
                                    class="label label-inline label-light-danger font-weight-bold"
                                >
                                    Inactivo
                                </span>
                            </td>
                            <td>
                                <div
                                    class="d-flex justify-content-around aling-items-center flex-wrap flex-row"
                                >
                                 <input type="checkbox" class="checkbox mt-3">
                                  <a
                                        href="#"
                                        class="btn btn-icon btn-light-success btn-sm mr-2"
                                        data-toggle="modal"
                                        data-target="#modalEditDep"
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
        <!-- Modal create Departament -->
        <div
            class="modal fade"
            id="modalCreateDep"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modalCreateLabel"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-xl modal-dialog-scrollable"
                role="document"
            >
                <form action="" v-on:submit.prevent="addDepartment()">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCreateLabel">
                                Crear Departamentos
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <i class="far fa-times h5"></i>
                            </button>
                        </div>
                        <div class="modal-body">

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
                                    <!-- <div class="form-group col-md-6">
                                        <label>Estado</label>
                                        <select
                                            class="form-control form-control-solid"
                                            id="document_type"
                                            name="state"
                                        >
                                            <option disabled>Seleccione</option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                        <span class="form-text text-muted"></span>
                                    </div> -->
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

                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal"
                            >
                                Cerrar
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary font-weight-bold"
                            >
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            data: [],
            department: {},

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

        async addDepartment(){
            let _this = this;
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let myHeaders = new Headers();
                myHeaders.append("Accept", "application/json");
                myHeaders.append('Content-Type', "application/json");
                myHeaders.append("X-CSRF-TOKEN", token);
            let requestOptions = {
                method: "POST",
                headers: myHeaders,
                body:JSON.stringify(this.department)
            };
            await  fetch(`/departamentos`, requestOptions)
                .then((response) => response.json())
                .then(function (data) {
                    let department = data.data;
                    _this.data.push({...department,state:1});

                })
                .catch((err) => console.warn(err));
        },
         async removeDepartment(id) {
            let remove = await  deleteResource(`/departamentos/${id}}`);
            if(remove){
                let index =this.data.findIndex(item=>item.id==id);
                this.data.splice(index,1);
            }

        }
    },
    mounted() {
        this.getDepartment();
    },
};
</script>
