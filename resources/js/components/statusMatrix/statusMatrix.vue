<template>
   <div class="content" id="app">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title">Matriz de estados </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Ámbito
                                    </th>
                                    <th>
                                        Opciones
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col">
                                <h4 class="card-title">Descripción - Matriz</h4>
                            </div>
                            <div class="d-none" id="divCreateParameter">
                                <button class="btn btn-success btn-rd" data-toggle="modal" data-target="#modalCreateParameter"> <i class="fad fa-plus p-0"></i> </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="parameterValueTable">
                                <thead class=" text-primary">
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
