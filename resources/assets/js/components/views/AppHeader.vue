<template>
    <header>

         <!--Navbar-->
        <b-navbar toggleable="md" type="dark" variant="info">

            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

            <b-navbar-brand href="#">{{ title }}</b-navbar-brand>

            <b-collapse is-nav id="nav_collapse">

                <b-navbar-nav class="navMenu">
                    <b-nav-item-dropdown right>
                        <template slot="button-content">
                            <em>
                                Menú
                            </em>
                        </template>
                        <template v-for="module in modules" v-if="!module.api">
                            <header-menu :selected="selected" :module="module"></header-menu>
                        </template>
                        
                    </b-nav-item-dropdown>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">

                    <b-nav-item-dropdown right>
                        <!-- Using button-content slot -->
                        <template slot="button-content">
                            <em>{{ currentUser.username }}</em>
                        </template>
                        <router-link class="dropdown-item" to="/perfil">
                            Perfil
                        </router-link>
                        <b-dropdown-item @click="logout">
                            <fa :icon="icons.powerOff"/> Cerrar sesión
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>

            </b-collapse>
        </b-navbar>

        <div id="sidebar" class="sidebar-fixed position-fixed p-0">
            <a class="logo-wrapper"><img alt="" class="img-fluid" src=""/></a>
            <template v-for="module in modules" v-if="!module.api">
                <header-menu :selected="selected" :module="module" ></header-menu>
            </template>
        </div>
    </header>
</template>

<script type="text/javascript">

import { faPowerOff } from '@fortawesome/free-solid-svg-icons'
import HeaderMenu from './HeaderMenu.vue'

export default {
    name: 'app-header',
    components: {
        HeaderMenu,
    },
    data() {
        return {
            activeItem: 1,
            modules: [],
            selected: {
                id: 0,
            }
        }
    },
    methods: {
        getModules() {
            axios.get(`/api/modules/menu`)
                .then( res => {
                    this.modules = res.data.modules

                    this.findSelected(res.data.modules)
                })
                .catch( err => {
                    console.log(err)
                    alert('Ocurrió un error al listar los módulos')
                })
        },
        logout() {
            this.$store.commit('logout')
            this.$router.push('/login')
        },
        findSelected(modules) {
            for(let i=0; i<modules.length; i++) {
                if(modules[i].childs.length == 0) {
                    if(this.$route.fullPath.indexOf(modules[i].url) !== -1 && !modules[i].api) {
                        this.selected.id = modules[i].id
                        return true
                    }
                } else {
                    this.findSelected(modules[i].childs)
                }
            }
        }
    },
    computed: {
        icons() {
            return {
                powerOff: faPowerOff
            }
        },
        currentUser() {
            return this.$store.getters.currentUser
        },
        title() {
            return this.$route.meta.title
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

@media(min-width: 768px) {
     .navMenu {
        display: none;
     }
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
