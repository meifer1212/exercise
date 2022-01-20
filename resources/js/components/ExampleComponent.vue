<template>
    <div class="container">
        <div class="row justify-content-center">
            <div v-bind:class="[search ? 'col-md-12' : 'col-md-8']">
                <div class="card">
                    <div class="card-header text-center">Formulario</div>
                    <div class="card-body">
                        <form class="row" v-on:submit.prevent="loading_f(); getData()">
                            <div class="form-group col-6">
                                <label for="name">Nombre</label>
                                <input
                                    v-model="name"
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    placeholder="ej. Alexander"
                                    required
                                />
                            </div>
                            <div class="form-group col-6">
                                <label for="porcentaje">Porcentaje de Coincidencia</label>
                                <input
                                    v-model="percent"
                                    type="number"
                                    class="form-control"
                                    id="porcentaje"
                                    placeholder="ej. 80"
                                    min="0"
                                    max="100"
                                    required
                                />
                            </div>
                            <div class="col-12 text-center">
                                <button
                                    type="submit"
                                    class="btn btn-primary mt-3"
                                >Buscar Coincidencia</button>
                                <button
                                    v-if="search"
                                    v-on:click="clearData()"
                                    type="submit"
                                    class="btn btn-primary mt-3"
                                >Limpiar datos</button>
                            </div>
                            <div class="col-12 mt-3 text-center" v-if="loading">
                                <div class="spinner-border" style="width: 3rem; height: 3rem;"></div>
                            </div>
                        </form>
                        <div v-if="search" v-show="!loading">
                            <hr />
                            <div class="text-center">
                                <!-- <h3>Resultados Encontrados ({{ results.length ? results.length : '0' }})</h3> -->
                                <div
                                    v-if="error === false"
                                    class="alert alert-success"
                                    role="alert"
                                >Búsqueda Exítosa. {{ results.length ? `Se Hallaron ${results.length} Resultados.` : 'Sin Resultados Para Mostrar.' }}</div>
                                <div
                                    v-else
                                    class="alert alert-danger"
                                    role="alert"
                                >Error Inesperado (Revisar la Consola)</div>
                            </div>
                            <div class="table-responsive">
                                <table
                                    class="table table-striped mt-3"
                                    v-if="search === true & !error === true & results.length > 0"
                                >
                                    <thead>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>% Coincidencia</th>
                                        <th>Tipo de Persona</th>
                                        <th>Tipo de Cargo</th>
                                        <th>Departamento</th>
                                        <th>Municipio</th>
                                        <th>Localidad</th>
                                    </thead>
                                    <paginate name="results" :list="results" :per="15" tag="tbody">
                                        <tr v-for="result in paginated('results')" :key="result.id">
                                            <td>{{ result.id }}</td>
                                            <td>{{ result.nombre }}</td>
                                            <td>{{ result.percent }}</td>
                                            <td>{{ result.tipo_persona }}</td>
                                            <td>{{ result.tipo_cargo }}</td>
                                            <td>{{ result.departamento }}</td>
                                            <td>{{ result.municipio }}</td>
                                            <td>{{ result.localidad }}</td>
                                        </tr>
                                    </paginate>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col align-self-end">
                                <paginate-links
                                    class="justify-content-center"
                                    v-if="results.length > 0"
                                    name="results"
                                    for="results"
                                    :classes="{ 'ul': 'pagination', 'li': 'page-item', 'a': 'page-link' }"
                                    :show-step-links="true"
                                    :limit="10"
                                ></paginate-links>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    // mounted() {
    //     console.log('Component mounted.')
    // },
    data() {
        return {
            name: null,
            percent: null,
            results: [],
            search: false,
            error: false,
            paginate: ['results'],
            loading: false,
        }
    },
    methods: {
        getData: function () {
            this.error = false;
            this.loading = true;
            axios
                .get('/api/exercise', {
                    params: {
                        name: this.name,
                        percent: this.percent,
                    }
                })
                .then(response => {
                    this.results = response.data
                }).catch(e => {
                    console.log('↓Error↓')
                    console.log(e);
                    console.log('↑Error↑')
                    this.error = true;
                }).finally(() => this.loading = false)
            this.search = true;
        },
        clearData: function () {
            this.name = null;
            this.percent = null;
            this.results = [];
            this.search = false;
            this.error = false;
            this.loading = false;
        },
        loading_f: function () {
            this.loading = true;
        }
    },
}
</script>
