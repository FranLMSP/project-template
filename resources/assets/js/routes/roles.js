import Main from '../components/views/roles/Main.vue'
import List from '../components/views/roles/List.vue'
import Form from '../components/views/roles/Form.vue'
import Show from '../components/views/roles/Show.vue'
import Permissions from '../components/views/roles/Permissions.vue'

export default {
    path: '/roles',
    meta: {
        title: 'Roles'
    },
    component: Main,
    props: true,
    children: [
        {
            path: '/',
            component: List,
            children: [
                {
                    path: 'crear',
                    name: 'role-create',
                    component: Form,
                    meta: {
                        mode: 'create'
                    }
                },
                {
                    path: ':id/editar',
                    name: 'role-edit',
                    component: Form,
                    meta: {
                        mode: 'edit'
                    }
                },
                {
                    path: 'permisos/:id/editar',
                    name: 'role-permissions-edit',
                    component: Permissions,
                    meta: {
                        mode: 'edit'
                    }
                },

            ]
        },
        {
            path: ':id',
            component: Show
        }
    ]
}