<template>
    <div class="flexible-content">
        <app-header/>
        <main>
            <div class="p-3">
                <router-view></router-view>
            </div>
            <app-footer/>
        </main>
    </div>
</template>

<script>
    import AppHeader from './AppHeader.vue'
    import AppFooter from './AppFooter.vue'

    export default {
        name: 'Template',
        components: {
            AppHeader,
            AppFooter, 
        }
    }
</script>

<style scoped>

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
