<template>
    <b-card>
        <b-row>
            <b-col sm="12" md="3" class="text-center">
                <fa class="align-middle" :icon="icons.user" size="10x" />
                <br>
                <h4>¡Bienvenido <strong>{{ currentUser.username }}</strong>!</h4>
                <p><strong>{{ user.role.name }}: </strong>{{ user.role.description }}</p>
            </b-col>
            <b-col>
                <b-row>
                    <b-col>
                        <b-form-group
                            label="Haga click aquí para habilitar los campos"
                            class="float-right">
                            <b-form-checkbox-group
                                class="float-right"
                                buttons
                                v-model="selected"
                                name="butons1"
                                :options="options">
                            </b-form-checkbox-group>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-form @submit.prevent="savePrompt">
                    <b-form-row class="mb-1">
                        <b-col md="6" sm="12">
                            <b-form-group label="Nombre de usuario">
                                <b-input-group>
                                    <b-input-group-prepend is-text>
                                      <fa :icon="icons.user"/>
                                    </b-input-group-prepend>

                                    <input 
                                        id="username"
                                        :disabled="selected.length == 0"
                                        :class="
                                            validated ?
                                            {
                                                'is-valid': isValid('username'),
                                                'is-invalid': !isValid('username')
                                            } : {}"
                                        class="form-control"
                                        v-model="form.username"
                                        type="text"
                                        placeholder="Nombre de usuario"
                                    />

                                    <div class="invalid-feedback" v-if="formErrors.username">
                                        {{ formErrors.username[0] }}
                                    </div>

                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" sm="12" class="mt-sm-1 mt-md-0">
                            <b-form-group label="Email">
                                <b-input-group>
                                    <b-input-group-prepend is-text>
                                      <fa :icon="icons.at"/>
                                    </b-input-group-prepend>

                                    <input 
                                        :disabled="selected.length == 0"
                                        :class="
                                            validated ?
                                            {
                                                'is-valid': isValid('email'),
                                                'is-invalid': !isValid('email')
                                            } : {}"
                                        class="form-control"
                                        v-model="form.email"
                                        type="email"
                                        placeholder="Email"
                                    />

                                    <div class="invalid-feedback" v-if="formErrors.email">
                                        {{ formErrors.email[0] }}
                                    </div>

                                </b-input-group>
                            </b-form-group>
                        </b-col>
                    </b-form-row>

                    <b-form-row class="mb-1">
                        <b-col>
                            <b-form-group label="Contraseña">
                                <b-input-group>
                                    <b-input-group-prepend is-text>
                                      <fa :icon="icons.lock"/>
                                    </b-input-group-prepend>


                                    <input 
                                        :disabled="selected.length == 0"
                                        :class="
                                            validated ?
                                            {
                                                'is-valid': isValid('password'),
                                                'is-invalid': !isValid('password')
                                            } : {}"
                                        class="form-control"
                                        v-model="form.password"
                                        type="password"
                                        placeholder="Contraseña (dejar en blanco si NO se desea cambiar)"
                                    />

                                    <div class="invalid-feedback" v-if="formErrors.password">
                                        {{ formErrors.password[0] }}
                                    </div>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                    </b-form-row>

                    <b-form-row class="mb-1">
                        <b-col>
                            <b-form-group label="Repetir contraseña">
                                <b-input-group>
                                    <b-input-group-prepend is-text>
                                      <fa :icon="icons.lock"/>
                                    </b-input-group-prepend>

                                    <input 
                                        :disabled="selected.length == 0"
                                        :class="
                                            validated ?
                                            {
                                                'is-valid': isValid('repeatPassword'),
                                                'is-invalid': !isValid('repeatPassword')
                                            } : {}"
                                        class="form-control"
                                        v-model="form.repeatPassword"
                                        type="password"
                                        placeholder="Repetir contraseña (dejar en blanco si NO se desea cambiar)"
                                    />

                                    <div class="invalid-feedback" v-if="formErrors.repeatPassword">
                                        {{ formErrors.repeatPassword[0] }}
                                    </div>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                    </b-form-row>

                    <b-form-row>
                        <b-col>
                            <b-button
                                type="submit"
                                class="float-right"
                                v-show="!selected.length == 0"
                                :disabled="sending"
                                variant="primary">
                                <fa :icon="icons.save"/> Guardar
                            </b-button>
                        </b-col>
                    </b-form-row>
                </b-form>
            </b-col>
        </b-row>
    </b-card>
</template>

<script type="text/javascript">

import { faSave, faUserCircle, faAt, faLock } from '@fortawesome/free-solid-svg-icons'
    
export default {
    name: 'user-profile',
    data() {
        return {
            user: {
                id: 0,
                username: '',
                email: '',
                role: {
                    id: 0,
                    name: '',
                    description: '',
                }
            },
            form: {
                username: '',
                email: '',
                password: '',
                repeatPassword: ''
            },
            error: false,
            sending: false,
            formErrors: {},
            selected: [], // Must be an array reference!
            options: [{text: 'Editar', value: true}]
        }
    },
    methods: {
        isValid(field) {
            if(!this.validated)
                return null
            return typeof this.formErrors[field] == "undefined" ? true : false
        },
        isInvalid(field) {
            !this.isValid(field)
        },
        getFeedback(field) {
            return this.formErrors[field].length >= 1 ? this.formErrors[field][0] : ''
        },
        save() {

        },
        get() {
            axios.get(`/api/profile`)
                .then( res => {
                    this.user = res.data.me

                    this.form.username = res.data.me.username
                    this.form.email = res.data.me.email
                })
                .catch( err => {
                    alert('Ocurrió un error')
                })
                .then( () => {

                })
        },
        save() {
            this.sending = true
            this.error = false

            axios.put(`/api/profile`, this.form)
                .then( res => {

                    Swal({
                        type: 'success',
                        title: res.data.message,
                        text: 'Su sesión será cerrada',
                        preConfirm:() => {
                            this.$store.commit('logout')
                            this.$router.push('/login')
                        }
                    })
                })
                .catch( err => {
                    this.error = true
                    this.formErrors = err.response.data.errors
                })
                .then( () => {
                    this.sending = false
                })
        },
        savePrompt() {
            Swal.queue([{
                title: '¿Actualizar usuario?',
                showCancelButton: true,
                type: 'warning',
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                text: 'Su sesión será cerrada al aplicar los cambios',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return this.save()
                }
            }])
        },
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        },
        icons() {
            return {
                save: faSave,
                user: faUserCircle,
                at: faAt,
                lock: faLock
            }
        },
        validated() {
            return Object.keys(this.formErrors).length >= 1
        }
    },
    created() {
        this.form.username = this.currentUser.username
        this.form.email = this.currentUser.email
        this.get()
    }
}

</script>