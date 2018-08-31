<template>
    <b-nav pills>
      <b-nav-item active>Active</b-nav-item>
      <b-nav-item>Link</b-nav-item>
      <b-nav-item-dropdown id="nav7_ddown" text="Dropdown" extra-toggle-classes="nav-link-custom" right>
        <b-dropdown-item>Mi perfil</b-dropdown-item>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-item><fa :icon="icon.powerOff"></fa> Cerrar sesión</b-dropdown-item>
      </b-nav-item-dropdown>
    </b-nav>
</template>

<script type="text/javascript">

    import { faPowerOff } from '@fortawesome/free-solid-svg-icons'

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
            icon() {
                return {
                    powerOff: faPowerOff
                }
            }
        },
        created() {

        }
    }
</script>
