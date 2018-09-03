<template>
    <div slot="modal-footer" class="w-100">
        <b-btn class="float-right" @click="$router.push('/usuarios')">
           Cerrar
        </b-btn>
        <b-btn class="float-right" variant="primary">
           Guardar
        </b-btn>
   </div>
</template>

<script type="text/javascript">
    export default {
        name: 'users-form'
    }
</script>