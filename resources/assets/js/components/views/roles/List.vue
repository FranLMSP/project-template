<template>
    <div>
        <b-modal
            id="form-modal"
            :title="modalTitle" hide-footer>
            <router-view></router-view>
        </b-modal>

        <b-row>
            <b-col>
                <b-card>
                    <b-row>
                        <b-col>
                            <h2>Roles</h2>
                        </b-col>
                        <b-col>
                            <router-link v-b-modal.form-modal class="btn btn-primary float-right" :to="{name: 'role-create'}">
                                <fa :icon="icons.plus"/> Crear rol
                            </router-link>
                        </b-col>
                    </b-row>
                </b-card>
            </b-col>
        </b-row>

        <br>

        <b-row>
            <b-col>
                <b-card>
                    <table class="table table-striped table-bordered table-outlined table-hover text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del rol</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="!loading && !error">
                                <tr v-for="role in roles" >
                                    <td><span>{{ role.id }}</span></td>
                                    <td><span>{{ role.name }}</span></td>
                                    <td><span>{{ role.description }}</span></td>
                                    <td>
                                        <router-link
                                            :to="{name: 'role-permissions-edit', params: {id: role.id}}"
                                            class="btn btn-sm btn-success"
                                            v-b-tooltip.hover
                                            v-b-modal.form-modal
                                            title="Editar permisos">
                                            <fa :icon="icons.key"/>
                                        </router-link>
                                        <router-link
                                            :to="{name: 'role-edit', params: {id: role.id}}"
                                            class="btn btn-sm btn-primary"
                                            v-b-tooltip.hover
                                            v-b-modal.form-modal
                                            title="Editar">
                                            <fa :icon="icons.edit"/>
                                        </router-link>
                                        <b-button @click="deletePrompt(role.id)" size="sm" variant="danger" v-b-tooltip.hover title="Eliminar">
                                            <fa :icon="icons.trash"/>
                                        </b-button>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="4">
                                        {{ tableMessage }}
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del rol</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                    <b-pagination
                        @change="get"
                        align="right"
                        size="md"
                        :total-rows="pagination.total"
                        v-model="pagination.current_page"
                        :per-page="pagination.per_page">
                    </b-pagination>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script type="text/javascript">

import { faKey, faPlus, faEdit, faTrash } from '@fortawesome/free-solid-svg-icons'

import RolesForm from './Form.vue'

export default {
    name: 'roles-list',
    components: {
        RolesForm
    },
    data() {
        return {
            roles: [],
            loading: false,
            error: false,
            modalShow: false,
            pagination: {
                total: 0,
                current_page: 3,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0
            }
        }
    },
    methods: {
        deletePrompt(id) {
            Swal.queue([{
                title: '¿Borrar rol?',
                showCancelButton: true,
                type: 'warning',
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar',
                text: 'Esta acción no se puede deshacer',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return this.remove(id)
                }
            }])
        },
        remove(id) {
            return axios.delete(`/api/roles/${id}`)
                .then( res => {
                    this.get()
                    Swal.insertQueueStep({
                        type: 'success',
                        title: 'Borrado correctamente',
                    })
                })
                .catch( err => {
                    Swal.insertQueueStep({
                        type: 'error',
                        title: err.response.data.message,
                    })
                })
        },
        get(page = 1) {
            this.loading = true
            this.error = false

            this.pagination.current_page = page

            axios.get('/api/roles?page='+this.pagination.current_page)
                .then( res => {
                    this.roles = res.data.roles
                    this.pagination = res.data.pagination
                })
                .catch( err => {
                    this.error = true
                })
                .then( () => {
                    this.loading = false
                })
        },
        showModal (id) {
            this.$root.$emit('bv::show::modal', id)
        },
        hideModal (id) {
            this.$root.$emit('bv::hide::modal', id)
        },
    },
    computed: {
        tableMessage() {
            return this.error ? 'Ocurrió un error al obtener los datos' : 'Cargando...'
        },
        icons() {
            return {
                key: faKey,
                plus: faPlus,
                edit: faEdit,
                trash: faTrash,
            }
        },
        modalTitle() {
            if(this.$route.meta.mode == 'create') {
                return 'Crear'
            }

            if(this.$route.meta.mode == 'edit') {
                return 'Modificar'
            }

            return 'Formulario'
        }
    },
    watch:{
        $route (to, from){
            if(to.meta.mode == 'create' || to.meta.mode == 'edit') {
                this.showModal('form-modal')
            } else {
                this.hideModal('form-modal')
            }

        }
    },
    created() {
        this.get();
        this.$nextTick(function() {

            if(this.$route.meta.mode == 'create' || this.$route.meta.mode == 'edit') {
                this.showModal('form-modal')
            } else {
                this.hideModal('form-modal')
            }
        })

        this.$root.$on('form-done', () => {
            this.get()
        })

    }
}

</script>

<style type="text/css">

.redRow > td > span {
    color: red;
}

</style>