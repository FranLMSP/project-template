<template>
    <div>
        <b-row>
            <b-col>
                <b-card>
                    <b-row>
                        <b-col>
                            <h2>Usuarios</h2>
                        </b-col>
                        <b-col>
                            <b-button class="float-right" variant="primary">
                                <fa :icon="icons.plus"/> Crear usuario
                            </b-button>
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

import { faKey, faPlus } from '@fortawesome/free-solid-svg-icons'

export default {
    name: 'UsersList',
    data() {
        return {
            users: [],
            loading: false,
            error: false
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
        }
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
                plus: faPlus
            }
        }
    },
    created() {
        this.list();
    }
}

</script>

<style type="text/css">

.redRow > td > span {
    color: red;
}

</style>