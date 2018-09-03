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
                            <h2>Usuarios</h2>
                        </b-col>
                        <b-col>
                            <router-link v-b-modal.form-modal class="btn btn-primary float-right" :to="{name: 'user-create'}">
                                <fa :icon="icons.plus"/> Crear usuario
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
                    <label><strong style="color: red">Rojo: </strong> Usuario actual</label>
                    <table class="table table-striped table-bordered table-outlined table-hover text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de usuario</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="!loading && !error">
                                <tr v-for="user in users" :class="{redRow: isUser(user)}" >
                                    <td><span>{{ user.id }}</span></td>
                                    <td><span>{{ user.username }}</span></td>
                                    <td><span>{{ user.email }}</span></td>
                                    <td>
                                        <b-button size="sm" variant="success" v-b-tooltip.hover title="Ver permisos">
                                            <fa :icon="icons.key"/>
                                        </b-button>
                                        <router-link
                                            :to="{name: 'user-edit', params: {id: user.id}}"
                                            class="btn btn-sm btn-primary"
                                            v-b-tooltip.hover
                                            v-b-modal.form-modal
                                            title="Editar">
                                            <fa :icon="icons.edit"/>
                                        </router-link>
                                        <b-button size="sm" variant="danger" v-b-tooltip.hover title="Eliminar">
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
                                <th>Nombre de usuario</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script type="text/javascript">

import { faKey, faPlus, faEdit, faTrash } from '@fortawesome/free-solid-svg-icons'

import UsersForm from './Form.vue'

export default {
    name: 'UsersList',
    components: {
        UsersForm
    },
    data() {
        return {
            users: [],
            loading: false,
            error: false,
            modalShow: false,
        }
    },
    methods: {
        list() {
            this.loading = true
            this.error = false

            axios.get('/api/users')
                .then( res => {
                    this.users = res.data.users
                })
                .catch( err => {
                    this.error = true
                })
                .then( () => {
                    this.loading = false
                })
        },
        isUser(user) {
            return user.id == this.currentUser.id
        },
        showModal (id) {
            this.$root.$emit('bv::show::modal', id)
        },
        hideModal (id) {
            this.$root.$emit('bv::hide::modal', id)
        },
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        },
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
        this.list();
        this.$nextTick(function() {

            if(this.$route.meta.mode == 'create' || this.$route.meta.mode == 'edit') {
                this.showModal('form-modal')
            } else {
                this.hideModal('form-modal')
            }
        })

        this.$root.$on('form-done', () => {
            this.list()
            this.hideModal('form-modal')
        })
    }
}

</script>

<style type="text/css">

.redRow > td > span {
    color: red;
}

</style>