<template>
    <b-card>
        <b-row>
            <b-col sm="12" md="3" class="text-center">
                <fa class="align-middle" :icon="icons.user" size="10x" />
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

                <b-form @submit.prevent="save">
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
                })
                .catch( err => {
                    alert('Ocurrió un error')
                })
                .then( () => {

                })
        }
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
        
    }
}

</script>