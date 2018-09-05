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

                                <input 
                                    :class="
                                        validated ?
                                        {
                                            'is-valid': isValid('name'),
                                            'is-invalid': !isValid('name')
                                        } : {}"
                                    class="form-control"
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Nombre del rol"
                                />

                                <div class="invalid-feedback" v-if="formErrors.name">
                                    {{ formErrors.name[0] }}
                                </div>

                            </b-input-group>
                        </b-col>
                        <b-col class="mt-sm-1 mt-md-0">
                            <b-input-group>

                                <textarea 
                                    :class="
                                        validated ?
                                        {
                                            'is-valid': isValid('description'),
                                            'is-invalid': !isValid('description')
                                        } : {}"
                                    class="form-control"
                                    v-model="form.description"
                                    type="description"
                                    placeholder="Descripción del rol"
                                >
                                </textarea>

                                <div class="invalid-feedback" v-if="formErrors.description">
                                    {{ formErrors.description[0] }}
                                </div>

                            </b-input-group>
                        </b-col>
                    </b-form-row>

                </b-form>
                <br>
            </div>
        </div>

        <div slot="modal-footer" class="w-100">
            <b-button-group  class="float-right">
                <b-button @click="$router.push('/roles')">
                    Cerrar
                </b-button>

                <b-button :disabled="error || loading || sending" @click="save" variant="primary">
                    <fa :icon="icons.save"/> Guardar
                </b-button>
            </b-button-group>
        </div>
    </div>
</template>

<script type="text/javascript">


import { faSave, faUser } from '@fortawesome/free-solid-svg-icons'

export default {
    name: 'roles-form',
    data() {
        return {
            form: {
                id: 0,
                name: '',
                description: '',
            },
            formErrors: {},
            loading: false,
            error: false,
            sending: false,
        }
    },
    methods: {
        save() {
            this.formErrors = {}
            this.sending = true

            if(this.$route.meta.mode == 'edit') {
                axios.put(`/api/roles/${this.form.id}`, this.form)
                    .then( res => {
                        toastr.success(res.data.message)
                        this.$router.push('/roles')
                        this.$root.$emit('form-done')
                    })
                    .catch( err => {
                        this.formErrors = err.response.data.errors
                    })
                    .then( () => {
                        this.sending = false
                    })
            } else {
                axios.post(`/api/roles/`, this.form)
                    .then( res => {
                        toastr.success(res.data.message)
                        this.$router.push('/roles')
                        this.$root.$emit('form-done')
                    })
                    .catch( err => {
                        this.formErrors = err.response.data.errors
                    })
                    .then( () => {
                        this.sending = false
                    })
            }
        },
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
        }

    },
    computed: {
        icons() {
            return {
                save: faSave,
                user: faUser,
            }
        },
        validated() {
            return Object.keys(this.formErrors).length >= 1
        }
    },
    created() {

        if(this.$route.meta.mode == 'edit') {

            this.loading = true
            this.error = false

            let id = this.$route.params.id

            axios.get(`/api/roles/${id}/edit`)
                .then( res => {
                    this.form = res.data.role
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