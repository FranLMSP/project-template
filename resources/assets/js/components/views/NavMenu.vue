<template>

    <router-link
        class="dropdown-item" 
        :to="module.url"
        v-if="!module.api && module.childs.length == 0">
        {{ module.name }}
    </router-link>

    <b-nav-item-dropdown v-else-if="module.module_id === null" right>
        <template slot="button-content" v-if="!module.api">
            <em>
                {{ module.name }}
            </em>
        </template>
        <template v-for="child in module.childs" v-if="!child.api">
            <nav-menu :module="child"></nav-menu>
        </template>
        
    </b-nav-item-dropdown>
    <b-card v-else no-body>
        <b-card-header header-tag="header" class="p-0" role="tab">
            <b-btn block>
                {{ module.name }}
            </b-btn>
        </b-card-header>

        <b-collapse :id="'c'+module.id" v-if="module.childs.length > 0" visible>
            <b-card-body>
                <template v-for="child in module.childs" v-if="!child.api">
                    <nav-menu :module="child"></nav-menu>
                </template>
            </b-card-body>
        </b-collapse>

    </b-card>
</template>

<script type="text/javascript">

export default {
    props: ['module'],
    name: 'nav-menu'
}

</script>