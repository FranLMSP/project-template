<template>
    <ftr color="primary-color-dark" class="text-center font-small darken-2">
        <div class="pt-4">
            <btn outline="white" tag="a" href="https://mdbootstrap.com/getting-started/" target="_blank">Download MDB <fa icon="download" class="ml-2"/></btn>
            <btn outline="white" tag="a" href="https://mdbootstrap.com/bootstrap-tutorial/" target="_blank">Start free tutorial <fa icon="graduation-cap" class="ml-2"/></btn>
        </div>
        <hr class="my4"/>
        <div class="pb-4">
            <a href="#"><fa icon="facebook" class="mr-3"/></a>
            <a href="#"><fa icon="twitter" class="mr-3"/></a>
            <a href="#"><fa icon="youtube" class="mr-3"/></a>
            <a href="#"><fa icon="google-plus" class="mr-3"/></a>
            <a href="#"><fa icon="dribbble" class="mr-3"/></a>
            <a href="#"><fa icon="pinterest" class="mr-3"/></a>
            <a href="#"><fa icon="github" class="mr-3"/></a>
            <a href="#"><fa icon="codepen" class="mr-3"/></a>
        </div>
        <p class="footer-copyright mb-0 py-3 text-center">
            &copy; {{new Date().getFullYear()}} Copyright: <a href="https://www.MDBootstrap.com"> MDBootstrap.com </a>
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