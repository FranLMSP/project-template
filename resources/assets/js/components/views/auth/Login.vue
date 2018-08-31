<template>
    <b-row>
    </b-row>
</template>

<script type="text/javascript">
    import {login} from '../../../helpers/auth.js'

    export default {
        data() {
            return {
                form: {
                    username: '',
                    password: ''
                },
                error: null,
                loading: false,
                success: false
            }
        },
        methods: {
            authenticate() {
                this.$store.dispatch('login')
                this.loading = true

                login(this.form)
                    .then( res => {
                        this.error = null
                        this.$store.commit('loginSuccess', res)
                        this.$router.push({path: '/'})
                    })
                    .catch( err => {
                        this.error = err
                        this.$store.commit('loginFailed', {err})
                    })
                    .then( () => {
                        this.loading = false
                    })
            }
        },
        computed: {
            authError() {
                return this.$store.getters.authError
            }
        },
        created() {
        }
    }

</script>
