<template>
    <div>
        <div slot="modal-body">
            <template v-if="loading || error">
                <p v-show="!error">Cargando</p>
                <p v-show="error">Ocurrió un error</p>
            </template>
            <template v-else>
                <b-row>
                </b-row>
                <pre>
                    {{user}}
                </pre>
            </template>
        </div>

        <div slot="modal-footer" class="w-100">
            <b-button-group  class="float-right">
                <b-button @click="$router.push('/usuarios')">
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

import { faSave } from '@fortawesome/free-solid-svg-icons'

export default {
    name: 'user-permissions',
    data() {
        return {
            methods: [],
            modules: [],
            user: {
                id: 0,
                username: '',
                email: '',
                permissions: []
            },
            formErrors: {},
            loading: false,
            sending: false,
            error: false,
        }
    },
    methods: {
        get() {
            this.loading = true
            this.error = false
            let id = this.$route.params.id

            axios.get(`/api/permissions/users/${id}/edit`)
                .then( res => {
                    this.methods = res.data.methods
                    this.modules = res.data.modules
                    this.user = res.data.user
                })
                .catch( err => {
                    this.error = true
                })
                .then( () => {
                    this.loading = false
                })
        },
        save() {
            this.sending = true
            axios.put(`/api/permissions/users/${this.user.id}`)
                .then( res => {
                    toastr.success(res.data.message)
                    this.$router.push('/usuarios')
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
    computed: {
        icons() {
            return {
                save: faSave,
            }
        },
    },
    created() {
        this.get()
    }
}

</script>