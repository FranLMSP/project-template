<template>

    <b-card no-body>
        <b-card-header @click="selectModule(module)" header-tag="header" class="p-0" role="tab">
            <router-link
                v-if="module.childs.length == 0"
                class="btn btn-block text-left"
                :class="{'btn-primary': isSelected}"
                :to="module.url"
            >
                {{ module.name }}
            </router-link>
            <b-btn
                class="text-left"
                v-else
                block
                v-b-toggle="'c'+module.id"
            >
                {{ module.name }}
            </b-btn>
        </b-card-header>

        <b-collapse
            :visible="isChildSelected"
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
    
export default {
    props: [ 'selected', 'module' ],
    name: 'header-menu',
    data() {
        return {
            created: false
        }
    },
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
            return this.module.open
        },
        isSelected() {
            //alert(this.selected.id)
            return this.selected.id == this.module.id
        }
    },
    created() {
        this.module.open = this.findChildSelected(this.module)
    }
}

</script>

<style type="text/css">
.active {
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    border-radius: 5px;
}
</style>