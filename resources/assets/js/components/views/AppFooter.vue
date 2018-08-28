<template>
    <ftr color="primary-color-dark" class="text-center font-small darken-2">
        <hr class="my4"/>
        <div class="pb-4">
            <a href="#"><fa icon="facebook" class="mr-3"/></a>
            <a href="#"><fa icon="github" class="mr-3"/></a>
        </div>
        <p class="footer-copyright mb-0 py-3 text-center">
            &copy; {{ new Date().getFullYear() }} Copyright: Plantilla </a>
        </p>
    </ftr>
</template>

<script type="text/javascript">
    
    import {
        Btn,
        Fa,
        Footer
    } from 'mdbvue'

    export default {
        name: 'AppFooter',
        components: {
            Btn,
            Fa,
            'ftr': Footer,
        }
    }
</script>