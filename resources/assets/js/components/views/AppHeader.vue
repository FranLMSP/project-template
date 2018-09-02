<template>
    <header>

         <!--Navbar-->
<b-navbar toggleable="md" type="dark" variant="info">

  <b-navbar-toggle target="sidebar"></b-navbar-toggle>

  <b-navbar-brand href="#">NavBar</b-navbar-brand>

  <b-collapse is-nav id="nav_collapse">

    <b-navbar-nav>
      <b-nav-item href="#">Link</b-nav-item>
      <b-nav-item href="#" disabled>Disabled</b-nav-item>
    </b-navbar-nav>

    <!-- Right aligned nav items -->
    <b-navbar-nav class="ml-auto">

      <b-nav-form>
        <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Search"/>
        <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
      </b-nav-form>

      <b-nav-item-dropdown text="Lang" right>
        <b-dropdown-item href="#">EN</b-dropdown-item>
        <b-dropdown-item href="#">ES</b-dropdown-item>
        <b-dropdown-item href="#">RU</b-dropdown-item>
        <b-dropdown-item href="#">FA</b-dropdown-item>
      </b-nav-item-dropdown>

      <b-nav-item-dropdown right>
        <!-- Using button-content slot -->
        <template slot="button-content">
          <em>User</em>
        </template>
        <b-dropdown-item href="#">Profile</b-dropdown-item>
        <b-dropdown-item href="#">Signout</b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>

  </b-collapse>
</b-navbar>
        <div id="sidebar" class="sidebar-fixed position-fixed">
          <a class="logo-wrapper"><img alt="" class="img-fluid" src=""/></a>
          <b-list-group class="list-group-flush">
            <router-link to="/dashboard" @click.native="activeItem = 1">
              <b-list-group-item :action="true" :class="activeItem === 1 && 'active'">Dashboard</b-list-group-item>
            </router-link>
            <router-link to="/profile" @click.native="activeItem = 2">
              <b-list-group-item :action="true" :class="activeItem === 2 && 'active'">Profile</b-list-group-item>
            </router-link>
            <router-link to="/tables"  @click.native="activeItem = 3">
              <b-list-group-item :action="true" :class="activeItem === 3 && 'active'">Tables</b-list-group-item>
            </router-link>
            <router-link to="/maps" @click.native="activeItem = 4">
              <b-list-group-item :action="true" :class="activeItem === 4 && 'active'">Maps</b-list-group-item>
            </router-link>
            <router-link to="/404" @click.native="activeItem = 5">
              <b-list-group-item :action="true" :class="activeItem === 5 && 'active'">404</b-list-group-item>
            </router-link>
          </b-list-group>
        </div>
    </header>
</template>

<script type="text/javascript">

    import { faPowerOff } from '@fortawesome/free-solid-svg-icons'

    export default {
        name: 'app-header',
        components: {
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

@media (max-width: 992px) {
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
