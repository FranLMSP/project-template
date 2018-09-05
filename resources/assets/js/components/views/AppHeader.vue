<template>
    <header>

         <!--Navbar-->
        <b-navbar toggleable="md" type="dark" variant="info">

            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

            <b-navbar-brand href="#">NavBar</b-navbar-brand>

            <b-collapse is-nav id="nav_collapse">

                <b-navbar-nav class="navMenu">
                    <template v-for="module in modules" v-if="!module.api">

                        <nav-menu :module="module"></nav-menu>

                    </template>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">

                    <b-nav-item-dropdown right>
                        <!-- Using button-content slot -->
                        <template slot="button-content">
                            <em>{{ currentUser.username }}</em>
                        </template>
                        <b-dropdown-item>Perfil</b-dropdown-item>
                        <b-dropdown-item @click="logout">
                            <fa :icon="icons.powerOff"/> Cerrar sesión
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>

            </b-collapse>
        </b-navbar>

        <div id="sidebar" class="sidebar-fixed position-fixed">
            <a class="logo-wrapper"><img alt="" class="img-fluid" src=""/></a>
            <template v-for="module in modules" v-if="!module.api">
                <header-menu :module="module" ></header-menu>
            </template>
        </div>
    </header>
</template>

<script type="text/javascript">

import { faPowerOff } from '@fortawesome/free-solid-svg-icons'
import HeaderMenu from './HeaderMenu.vue'
import NavMenu from './NavMenu.vue'

export default {
    name: 'app-header',
    components: {
        HeaderMenu,
        NavMenu
    },
    data() {
        return {
            activeItem: 1,
            modules: [],
        }
    },
    methods: {
        getModules() {
            axios.get(`/api/modules/menu`)
                .then( res => {
                    this.modules = res.data.modules

                    console.log(this.modules)
                })
                .catch( err => {
                    alert('Ocurrió un error al listar los módulos')
                })
        },
        logout() {
            this.$store.commit('logout')
            this.$router.push('/login')
        },
    },
    computed: {
        icons() {
            return {
                powerOff: faPowerOff
            }
        },
        currentUser() {
            return this.$store.getters.currentUser
        }
    },
    created() {
        this.getModules()
    }
}

</script>

<style scoped>

main {
    background-color: #EDEDEE;
}

.flexible-content {
    transition: padding-left 0.3s;
    padding-left: 270px;
}

.flexible-navbar {
    transition: padding-left 0.5s;
    padding-left: 270px;
}

.sidebar-fixed {
    left: 0;
    top: 0;
    height: 100vh;
    width: 270px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    z-index: 1050;
    background-color: #fff;
    padding: 1.5rem;
    padding-top: 0;
}

.sidebar-fixed .logo-wrapper img{
    width: 100%;
    padding: 2.5rem;
}

.sidebar-fixed .list-group-item {
    display: block !important;
    transition: background-color 0.3s;
}

.sidebar-fixed .list-group .active {
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    border-radius: 5px;
}

@media (max-width: 768px) {
    .sidebar-fixed {
        display: none;
    }
    .flexible-content {
        padding-left: 0;
    }
    .flexible-navbar {
        padding-left: 10px;
    }
}

</style>

<style>
.navbar-light .navbar-brand {
    margin-left: 15px;
    color: #2196f3 !important;
    font-weight: bolder;
}
</style>
