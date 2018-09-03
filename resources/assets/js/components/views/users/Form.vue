<template>
    <div>

        <div slot="modal-body">
            <div v-show="loading">
                <p v-show="!error">Cargando</p>
                <p v-show="error">Ocurrió un error</p>
            </div>
            <div v-show="!loading">
                <b-form @submit.prevent="save">
                    <b-form-row class="mb-1">
                        <b-col md="6" sm="12">
                            <b-input-group>
                                <b-input-group-prepend is-text>
                                  <fa :icon="icons.user"/>
                                </b-input-group-prepend>

                                <b-form-input v-model="form.username" type="text" placeholder="Nombre de usuario"></b-form-input>

                            </b-input-group>
                        </b-col>
                        <b-col md="6" sm="12" class="mt-sm-1 mt-md-0">
                            <b-input-group>
                                <b-input-group-prepend is-text>
                                  <fa :icon="icons.at"/>
                                </b-input-group-prepend>

                                <b-form-input v-model="form.email" type="email" placeholder="Email"></b-form-input>

                            </b-input-group>
                        </b-col>
                    </b-form-row>

                    <b-form-row class="mb-1">
                        <b-col>
                            <b-input-group>
                                <b-input-group-prepend is-text>
                                  <fa :icon="icons.lock"/>
                                </b-input-group-prepend>

                                <b-form-input v-model="form.password" type="password" placeholder="Contraseña"></b-form-input>

                            </b-input-group>
                        </b-col>
                    </b-form-row>

                    <b-form-row class="mb-1">
                        <b-col>
                            <b-input-group>
                                <b-input-group-prepend is-text>
                                  <fa :icon="icons.lock"/>
                                </b-input-group-prepend>

                                <b-form-input v-model="form.repeatPassword" type="password" placeholder="Repetir contraseña"></b-form-input>

                            </b-input-group>
                        </b-col>
                    </b-form-row>
                </b-form>
                <br>
            </div>
        </div>

        <div slot="modal-footer" class="w-100">
            <b-button-group  class="float-right">
                <b-button @click="$router.push('/usuarios')">
                    Cerrar
                </b-button>

                <b-button :disabled="error || loading" @click="save" variant="primary">
                    <fa :icon="icons.save"/> Guardar
                </b-button>
            </b-button-group>
        </div>
    </div>
</template>

<script type="text/javascript">


import { faSave, faUser, faAt, faLock } from '@fortawesome/free-solid-svg-icons'

export default {
    name: 'users-form',
    data() {
        return {
            form: {
                id: 0,
                username: '',
                email: '',
                password: '',
                role_id: '',
                repeatPassword: '',
            },
            roles: [],
            loading: false,
            error: false,
        }
    },
    methods: {
        save() {

        },

    },
    computed: {
        icons() {
            return {
                save: faSave,
                user: faUser,
                at: faAt,
                lock: faLock
            }
        }
    },
    created() {
        this.loading = true
        this.error = false

        let id = this.$route.params.id

        if(this.$route.meta.mode == 'edit') {
            axios.get(`/api/users/${id}/edit`)
                .then( res => {
                    this.roles = res.data.roles
                    this.form = res.data.user

                    this.form.password = ''
                    this.form.repeatPassword = ''
                })
                .catch( err => {
                    console.log(err)
                    this.error = true
                })
                .then( () => {
                    this.loading = false
                })
        } else {
            axios.get(`/api/users/create`)
                .then( res => {
                    this.roles = res.data.roles
                })
                .catch( err => {
                    this.error = true
                })
                .then( () => {
                    this.loading = false
                })            
        }
    }
}

</script>