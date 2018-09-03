<template>
    <div v-if="loading || error">
        <p v-show="!error">Cargando</p>
        <p v-show="error">Ocurrió un error</p>
    </div>
    <div v-else>
        <pre>
            {{user}}
        </pre>
    </div>
</template>

<script type="text/javascript">

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
            loading: false,
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
                    this.lading = false
                })
        }
    },
    created() {
        this.get()
    }
}

</script>