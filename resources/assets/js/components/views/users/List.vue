<template>

    <b-card>
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
                    <tr v-for="user in users">
                        <td>{{ user.id }}</td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.email }}</td>
                        <td><b-button size="sm" variant="success">o</b-button></td>
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
</template>

<script type="text/javascript">

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
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        },
        tableMessage() {
            return this.error ? 'Ocurrió un error al obtener los datos' : 'Cargando...'
        }
    },
    created() {
        this.list();
    }
}

</script>