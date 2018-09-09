<template>

    <b-card no-body>
        <b-card-header @click="selectModule(module)" header-tag="header" class="p-0" role="tab">
            <router-link
                v-b-toggle="'nav_collapse'"
                v-if="module.childs.length == 0"
                class="btn btn-block text-left"
                :class="{'btn-primary': isSelected}"
                :to="module.url"
            >
                <fa :icon="icons[module.icon]" /> {{ module.name }}
            </router-link>
            <b-btn
                class="text-left"
                :class="{
                    'btn-dark': isChildSelected,
                    'btn-secondary': !isChildSelected
                }"
                v-else
                block
                v-b-toggle="'c'+module.id"
            >
                <fa :icon="icons[module.icon]" /> {{ module.name }}
            </b-btn>
        </b-card-header>

        <b-collapse
            :visible="module.open"
            :id="'c'+module.id"
            v-if="module.childs.length > 0"
        >
            <b-card-body class="p-0 pl-4">
                <template v-for="child in module.childs" v-if="!child.api">
                    <header-menu :selected="selected" :module="child">
                    </header-menu>
                </template>
            </b-card-body>
        </b-collapse>

    </b-card>


</template>

<script type="text/javascript">
    
import {faCog} from '@fortawesome/free-solid-svg-icons'

export default {
    props: [ 'selected', 'module' ],
    name: 'header-menu',
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