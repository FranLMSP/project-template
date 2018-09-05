<template>

    <b-card no-body>
        <b-card-header header-tag="header" class="p-0" role="tab">
            <router-link
                v-if="module.childs.length == 0"
                class="btn btn-block btn-secondary"
                :to="module.url"
            >
                {{ module.name }}
            </router-link>
            <b-btn
                v-else
                block
                v-b-toggle="'c'+module.id"
            >
                {{ module.name }}
            </b-btn>
        </b-card-header>

        <b-collapse :id="'c'+module.id" v-if="module.childs.length > 0">
            <b-card-body>
                <template v-for="child in module.childs" v-if="!child.api">
                    <header-menu :module="child">
                    </header-menu>
                </template>
            </b-card-body>
        </b-collapse>

    </b-card>


</template>

<script type="text/javascript">
    
export default {
    props: [ 'active', 'module' ],
    name: 'header-menu',
    created() {
    }
}

</script>