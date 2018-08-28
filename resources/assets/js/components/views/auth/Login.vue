<template>
    <container fluid>
        <br>
        <row>
            <column col="12" md="6" class="offset-md-3">
                <card>
                  <card-body>
                    <form @submit.prevent="authenticate">
                      <p class="h4 text-center py-4">Iniciar sesión</p>
                      <div class="grey-text">
                        <md-input label="Usuario" icon="user" group type="text"/>
                        <md-input label="Contraseña" icon="lock" group type="password" validate/>
                      </div>
                      <div class="text-center py-4 mt-3">
                        <btn color="cyan" type="submit">Iniciar Sesión</btn>
                      </div>
                    </form>
                  </card-body>
                </card>
            </column>
        </row>
    </container>

</template>

<script type="text/javascript">
    import {login} from '../../../helpers/auth.js'

    import {
        Row,
        Column,
        Container,
        Card,
        CardImg,
        CardBody,
        CardTitle,
        CardText,
        MdInput,
        Btn
    } from 'mdbvue'

    export default {
        components: {
            Row,
            Column,
            Container,
            Card,
            CardImg,
            CardBody,
            CardTitle,
            CardText,
            MdInput,
            Btn
        },
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
        }
    }

</script>
