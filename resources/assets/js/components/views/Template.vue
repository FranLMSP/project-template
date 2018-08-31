<template>
    <div class="flexible-content">
        <app-header/>
        <main>
            <div class="mt-5 p-5">
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
