<template>

    <b-card no-body>
        <b-card-header @click="selectModule(module)" header-tag="header" class="p-0" role="tab">
            <router-link
                v-if="module.childs.length == 0"
                class="btn btn-block"
                :class="{'btn-primary': isSelected(module)}"
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

        <b-collapse
            :visible="isChildSelected(module)"
            :id="'c'+module.id"
            v-if="module.childs.length > 0"
        >
            <b-card-body>
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
    methods: {
        selectModule(module) {
            if(module.childs.length == 0) {
                this.$root.$emit('selectModule', module)
            }
        },
        isSelected(module) {
            return this.selected.id == module.id
        },
        isChildSelected(module) {
            return false
        }
    },
    created() {

    }
}

</script>

<style type="text/css">
.active {
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    border-radius: 5px;
}
</style>