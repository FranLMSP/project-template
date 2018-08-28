<template>
    <div class="flexible-content">
        <navbar class="flexible-navbar white" position="top" name="MDB" href="#" scrolling>
          <navbar-collapse>
            <navbar-nav left>
              <router-link to="/" @click.native="activeItem = 1"><navbar-item href="" waves-fixed active>Inicio</navbar-item></router-link>
            </navbar-nav>
            <navbar-nav right>
                <div @click="logout">
                    <navbar-item waves-fixed class="border border-light rounded" target="_blank"><fa icon="power-off" class="mr-2"/>Cerrar sesión</navbar-item>
                </div>
            </navbar-nav>
          </navbar-collapse>
        </navbar>
        <!--/.Navbar-->
        <!-- Sidebar -->
        <div class="sidebar-fixed position-fixed">
          <a class="logo-wrapper"><img alt="" class="img-fluid"/></a>
          <list-group class="list-group-flush">
            <router-link to="/dashboard" @click.native="activeItem = 1">
              <list-group-item :action="true" :class="activeItem === 1 && 'active'"><fa icon="pie-chart" class="mr-3"/>Dashboard</list-group-item>
            </router-link>
            <router-link to="/profile" @click.native="activeItem = 2">
              <list-group-item :action="true" :class="activeItem === 2 && 'active'"><fa icon="user" class="mr-3"/>Profile</list-group-item>
            </router-link>
            <router-link to="/tables"  @click.native="activeItem = 3">
              <list-group-item :action="true" :class="activeItem === 3 && 'active'"><fa icon="table" class="mr-3"/>Tables</list-group-item>
            </router-link>
            <router-link to="/maps" @click.native="activeItem = 4">
              <list-group-item :action="true" :class="activeItem === 4 && 'active'"><fa icon="map" class="mr-3"/>Maps</list-group-item>
            </router-link>
            <router-link to="/404" @click.native="activeItem = 5">
              <list-group-item :action="true" :class="activeItem === 5 && 'active'"><fa icon="exclamation" class="mr-3"/>404</list-group-item>
            </router-link>
          </list-group>
        </div>
    </div>
</template>

<script type="text/javascript">

    import {
        Navbar,
        NavbarItem,
        NavbarNav,
        NavbarCollapse,
        Fa,
        ListGroup,
        ListGroupItem,
        waves,
    } from 'mdbvue'

    export default {
        name: 'app-header',
        components: {
            Navbar,
            NavbarItem,
            NavbarNav,
            NavbarCollapse,
            Fa,
            ListGroup,
            ListGroupItem,
            waves,
        },
        data() {
            return {
                activeItem: 1
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

        },
        mixins: [waves]
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

@media (max-width: 1199.98px) {
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