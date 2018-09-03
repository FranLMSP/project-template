<template>
    <div v-if="!loading">
        <div slot="modal-footer" class="w-100">
            <b-button-group  class="float-right">
                <b-button @click="$router.push('/usuarios')">
                    Cerrar
                </b-button>

                <b-button @click="save" variant="primary">
                    <fa :icon="icons.save"/> Guardar
                </b-button>
            </b-button-group>
        </div>
    </div>
    <div v-else class="text-center">
        <p v-show="!error">Cargando</p>
        <p v-show="error">Ocurrió un error</p>
    </div>
</template>

<script type="text/javascript">


import { faSave } from '@fortawesome/free-solid-svg-icons'

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
                save: faSave
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
                    console.log(err)
                    this.error = true
                })
                .then( () => {
                    this.loading = false
                })            
        }
    }
}

</script>