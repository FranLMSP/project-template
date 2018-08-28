<template>
    <header>
        Soy un header
    </header>
</template>

<script type="text/javascript">

    export default {
        name: 'app-header',
        data() {
            return {
                modules: []
            }
        },
        methods: {
            logout() {
                this.$store.commit('logout')
                this.$router.push('/login')
            },
        },
        computed: {

        },
        created() {

        }
    }
</script>
