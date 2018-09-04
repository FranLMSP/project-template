<template>
    <div>
        <div slot="modal-body">
            <template v-if="loading || error">
                <p v-show="!error">Cargando</p>
                <p v-show="error">Ocurrió un error</p>
            </template>
            <template v-else>

                <div class="card p-3 mb-2" v-for="module in modules">

                    <div class="card-text">
                        <table class="text-centered" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>
                                        <span>{{ module.name }}</span> 
                                        <b-badge v-show="module.api" variant="secondary">
                                            API
                                        </b-badge>
                                    </th>
                                    <th  class="methodName" v-for="method in methods" v-if="showMethod(method, module)">
                                        <b-badge variant="light">{{ method.description }}</b-badge>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ module.url }}</td>
                                    <td class="methodInput" v-for="method in methods" v-if="showMethod(method, module)">
                                        <b-form-checkbox
                                            v-model="form.permissions" 
                                            :value="{method_id: method.id, module_id: module.id}"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card p-3" v-for="child in module.childs">

                        <div class="card-text">
                            <table class="text-centered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <span>{{ child.name }}</span> 
                                            <b-badge v-show="child.api" variant="secondary">
                                                API
                                            </b-badge>
                                        </th>
                                        <th  class="methodName" v-for="method in methods" v-if="showMethod(method, child)">
                                            <b-badge variant="light">{{ method.description }}</b-badge>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ child.url }}</td>
                                        <td class="methodInput" v-for="method in methods" v-if="showMethod(method, child)">
                                            <b-form-checkbox
                                                v-model="form.permissions" 
                                                :value="{method_id: method.id, module_id: child.id}"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card p-3" v-for="grandchild in child.childs">
                            <div class="card-text">
                                <table class="text-centered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span>{{ grandchild.name }}</span> 
                                                <b-badge v-show="grandchild.api" variant="secondary">
                                                    API
                                                </b-badge>
                                            </th>
                                            <th  class="methodName" v-for="method in methods" v-if="showMethod(method, grandchild)">
                                                <b-badge variant="light">{{ method.description }}</b-badge>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ grandchild.url }}</td>
                                            <td class="methodInput" v-for="method in methods" v-if="showMethod(method, grandchild)">
                                                <b-form-checkbox
                                                    v-model="form.permissions" 
                                                    :value="{method_id: method.id, module_id: grandchild.id}"
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <b-alert :show="formErrors" variant="danger">
                    <ul v-if="formErrors">
                        <li v-for="error in formErrors">
                            {{ error }}
                        </li>
                    </ul>
                </b-alert>
            </template>
        </div>

        <div slot="modal-footer" class="w-100">
            <b-button-group  class="float-right">
                <b-button @click="$router.push('/usuarios')">
                    Cerrar
                </b-button>

                <b-button :disabled="error || loading || sending" @click="save" variant="primary">
                    <fa :icon="icons.save"/> Guardar
                </b-button>
            </b-button-group>
        </div>
    </div>
</template>

<script type="text/javascript">

import { faSave } from '@fortawesome/free-solid-svg-icons'

export default {
    name: 'user-permissions',
    data() {
        return {
            methods: [],
            modules: [],
            user: {
                id: 0,
                username: '',
                email: '',
                permissions: []
            },
            form: {
                permissions: [],
            },
            formErrors: null,
            loading: false,
            sending: false,
            error: false,
        }
    },
    methods: {
        get() {
            this.loading = true
            this.error = false
            let id = this.$route.params.id

            axios.get(`/api/permissions/users/${id}/edit`)
                .then( res => {
                    this.methods = res.data.methods
                    this.modules = res.data.modules
                    this.user = res.data.user

                    this.form.permissions = this.parsePermissions(this.user)
                })
                .catch( err => {
                    this.error = true
                })
                .then( () => {
                    this.loading = false
                })
        },
        parsePermissions(user) {
            let permissions = []

            for(let i=0; i<user.permissions.length; i++) {
                permissions.push({
                    method_id: user.permissions[i].method.id,
                    module_id: user.permissions[i].module.id,
                });
            }

            return permissions
        },
        save() {
            this.sending = true
            axios.put(`/api/permissions/users/${this.user.id}`, this.form)
                .then( res => {
                    toastr.success(res.data.message)
                    this.$router.push('/usuarios')
                    this.$root.$emit('form-done')
                })
                .catch( err => {
                    this.formErrors = err.response.data.errors
                })
                .then( () => {
                    this.sending = false
                })
        },
        showMethod(method, module) {
            if(module.api) {
                if( module.url.indexOf('edit') !== -1 || module.url.indexOf('create') !== -1 ) {
                    if(method.name == 'GET') {
                        return true
                    }
                } else {
                    return true
                }
            } else {
                if(method.name == 'GET') {
                    return true
                }
            }
            return false
        }
    },
    computed: {
        icons() {
            return {
                save: faSave,
            }
        },
    },
    created() {
        this.get()
    }
}

</script>

<style type="text/css">

th, td {
    font-size: small;
}

.methodInput, .methodName {
    text-align: right; /* center checkbox horizontally */
    vertical-align: middle; /* center checkbox vertically */
}

.custom-control-label {
    cursor: pointer !important;
}

</style>