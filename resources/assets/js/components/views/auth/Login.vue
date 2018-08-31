<template>
    <b-container>
        <br>
        <b-row>
            <b-col sm="12" md="6" offset-md="3">
                <b-card title="¡Bienvenido!" class="mb-2 text-center">
                    <b-form @submit.prevent="authenticate">
                        <p class="card-text">
                            Ingrese su usuario y su contraseña
                        </p>
                        <b-form-row>
                            <b-col>
                                <b-input-group>
                                    <b-input-group-prepend is-text>
                                      <fa :icon="icon.user"/>
                                    </b-input-group-prepend>

                                    <b-form-input v-model="form.username" type="text" placeholder="Nombre de usuario"></b-form-input>

                                </b-input-group>
                            </b-col>
                        </b-form-row>

                        <br>

                        <b-form-row>
                            <b-col>
                                <b-input-group>
                                    <b-input-group-prepend is-text>
                                      <fa :icon="icon.lock"/>
                                    </b-input-group-prepend>

                                    <b-form-input v-model="form.password" type="password" placeholder="Contraseña"></b-form-input>

                                </b-input-group>
                            </b-col>
                        </b-form-row>

                        <br>

                        <b-form-row>
                            <b-col>
                                <b-button block size="lg" :disabled="loading" variant="primary">Iniciar sesión</b-button>
                            </b-col>
                        </b-form-row>
                    </b-form>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script type="text/javascript">
    import {login} from '../../../helpers/auth.js'

    import { faUser, faLock } from '@fortawesome/free-solid-svg-icons'

    export default {
        data() {
            return {
                form: {
                    username: '',
                    password: ''
                },
                error: null,
                loading: false,
                success: false
            }
        },
        methods: {
            authenticate() {
                this.$store.dispatch('login')
                this.loading = true

                login(this.form)
                    .then( res => {
                        this.error = null
                        this.$store.commit('loginSuccess', res)
                        this.$router.push({path: '/'})
                    })
                    .catch( err => {
                        this.error = err
                        this.$store.commit('loginFailed', {err})
                    })
                    .then( () => {
                        this.loading = false
                    })
            }
        },
        computed: {
            authError() {
                return this.$store.getters.authError
            },
            icon() {
                return {
                    user: faUser,
                    lock: faLock
                }
            }
        },
        created() {
        }
    }

</script>
