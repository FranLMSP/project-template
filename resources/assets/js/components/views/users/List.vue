<template>

    <b-card>
        testaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
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
                    console.log(res)
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
    },
    created() {
        this.list();
    }
}

</script>