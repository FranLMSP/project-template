<template>

    <router-link
        @click="selectModule(module)"
        class="dropdown-item text-left"
        :class="{'btn-primary': isSelected}"
        :to="module.url"
        v-if="!module.api && module.childs.length == 0">
        {{ module.name }}
    </router-link>

    <b-nav-item-dropdown v-else-if="module.module_id === null" right>
        <template slot="button-content" v-if="!module.api">
            <em class="text-left">
                {{ module.name }}
            </em>
        </template>
        <template v-for="child in module.childs" v-if="!child.api">
            <nav-menu :selected="selected" :module="child"></nav-menu>
        </template>
        
    </b-nav-item-dropdown>
    <b-card v-else no-body>
        <b-card-header
            @click="selectModule(module)"
            header-tag="header"
            class="p-0"
            role="tab">
            <b-btn
                block
                class="text-left"
                :class="{
                    'btn-dark': isChildSelected,
                    'btn-secondary': !isChildSelected
                }"
            >
                {{ module.name }}
            </b-btn>
        </b-card-header>

        <b-collapse
            :id="'c'+module.id"
            v-if="module.childs.length > 0"
            :visible="module.open">
            <b-card-body class="p-0 pl-4">
                <template v-for="child in module.childs" v-if="!child.api">
                    <nav-menu :module="child" :selected="selected"></nav-menu>
                </template>
            </b-card-body>
        </b-collapse>

    </b-card>
</template>

<script type="text/javascript">

export default {
    props:  [ 'selected', 'module' ],
    name: 'nav-menu',
    methods: {
        selectModule() {
            if(this.module.childs.length == 0) {
                this.selected.id = this.module.id
            }
        },
        selectCollapse() {
            this.module.open = !this.module.open
        },
        findChildSelected(module) {
            if(module.childs.length == 0) {
                return module.id == this.selected.id
            } else {
                let selected = false
                for(let i=0; i<module.childs.length; i++) {
                    if(this.findChildSelected(module.childs[i])) {
                        selected = true
                    }
                }
                return selected
            }
            return false
        }
    },
    computed: {
        isChildSelected() {
            return this.findChildSelected(this.module)
        },
        isSelected() {
            //alert(this.selected.id)
            return this.selected.id == this.module.id
        },
        icons() {
            return {
                cog: faCog
            }
        }
    },
    created() {
        this.module.open = this.findChildSelected(this.module)
    }
}

</script>

<style type="text/css" scoped>
.active {
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    border-radius: 5px;
}
</style>