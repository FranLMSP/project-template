<template>
    <div>

        <div slot="modal-body">
            <div v-show="loading">
                <p v-show="!error">Cargando</p>
                <p v-show="error">Ocurrió un error</p>
            </div>
            <div v-show="!loading && !error">
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
                    <b-form-row class="mb-1">
                        <b-col>
                            <b-form-select v-model="form.role_id" :options="rolesList" />
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
                role_id: null,
                repeatPassword: '',
            },
            formErrors: [],
            roles: [],
            loading: false,
            error: false,
        }
    },
    methods: {
        save() {
            this.formErrors = []

            if(this.$route.meta.mode == 'edit') {
                axios.put(`/api/users/${this.form.id}`)
                    .then( res => {
                        toastr.success(res.message)
                    })
                    .catch( err => {
                        console.log(err)
                    })
                    .then( () => {

                    })
            } else {
                axios.post(`/api/users/`)
                    .then( res => {
                        toastr.success(res.message)
                    })
                    .catch( err => {
                        console.log(err)
                    })
                    .then( () => {

                    })
            }
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
        },
        rolesList() {
            let roles = []
            for(let i=0; i<this.roles.length; i++) {
                roles.push({
                    value: this.roles[i].id,
                    text: this.roles[i].name
                })
            }

            return roles
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

                    if(this.roles.length >= 1) {
                        this.form.role_id = this.roles[0].id

                    }
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