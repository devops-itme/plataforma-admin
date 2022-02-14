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
                    <select class="form-control" v-model="selected">
                        <option
                            v-for="item of delivery_types"
                            v-bind:key="item.value"
                            v-bind:value="item.value"
                        >
                            {{ item.text }}
                        </option>
                        <!-- <option>Entrega</option> -->
                    </select>
                </div>
                <div
                    class="col-md-8 d-flex align-items-center flex-row flex-wrap"
                >
                    <div class="col-md-5 py-2 border rounded">
                        <p class="mb-0">
                            <span class="font-weight-bolder mb-3"
                                >Destinos en recogida por editar:
                            </span>
                            <span class="line-height-xl">2000</span>
                        </p>
                    </div>
                    <div class="form-group col-md-3 mb-0">
                        <select class="form-control" id="delivery_event_state">
                            <option>Seleccione estado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button
                            type="button"
                            class="btn btn-light-primary font-weight-bold"
                        >
                            Aplicar nuevo estado
                        </button>
                    </div>
                    <div class="col-md-1">
                        <span class="h5">1/100</span>
                    </div>
                </div>
            </div>
            <ul
                class="nav nav-tabs nav-tabs-line nav-tabs-line-3x nav-bolder"
                id="myTab"
                role="tablist"
            >
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link active"
                        id="porRecoger-tab"
                        data-toggle="tab"
                        href="#porRecoger"
                        role="tab"
                        aria-controls="porRecoger"
                        aria-selected="true"
                        >Por {{ selected == 1 ? "Entregar" : "Recoger" }}</a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link"
                        id="enproceso-tab"
                        data-toggle="tab"
                        href="#enproceso"
                        role="tab"
                        aria-controls="enproceso"
                        aria-selected="false"
                        >{{ selected == 1 ? "Entregas" : "Recogidas" }} en
                        proceso</a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                        class="nav-link"
                        id="consultas-tab"
                        data-toggle="tab"
                        href="#consultas"
                        role="tab"
                        aria-controls="consultas"
                        aria-selected="false"
                        >Consultas y edición</a
                    >
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div
                    class="tab-pane fade show active"
                    id="porRecoger"
                    role="tabpanel"
                    aria-labelledby="porRecoger-tab"
                >
                    <draggables :selected=selected></draggables>
                </div>
                <div
                    class="tab-pane fade"
                    id="enproceso"
                    role="tabpanel"
                    aria-labelledby="enproceso-tab"
                >
                    2
                </div>
                <div
                    class="tab-pane fade"
                    id="consultas"
                    role="tabpanel"
                    aria-labelledby="consultas-tab"
                >
                    3
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import draggables from "./draggable.vue";
export default {
    components: {
        draggables,
    },
    data() {
        return {
            selected: 1,
            delivery_types: [
                { value: 1, text: "Entregas" },
                { value: 2, text: "Recogidas" },
            ],
        };
    },
};
</script>
