<template>

</template>

<script type="text/javascript">

    export default {
        name: 'app-header',
        components: {
        },
        data() {
            return {
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
