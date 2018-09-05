import Main from '../components/views/users/Main.vue'
import List from '../components/views/users/List.vue'
import Form from '../components/views/users/Form.vue'
import Show from '../components/views/users/Show.vue'
import Permissions from '../components/views/users/Permissions.vue'

export default {
    path: '/usuarios',
    meta: {
        title: 'Usuarios'
    },
    component: Main,
    props: true,
    children: [
        {
            path: '/',
            component: List,
            meta: {
                title: 'Usuarios'
            },
            children: [
                {
                    path: 'crear',
                    name: 'user-create',
                    component: Form,
                    meta: {
                        mode: 'create',
                        title: 'Usuarios'
                    }
                },
                {
                    path: ':id/editar',
                    name: 'user-edit',
                    component: Form,
                    meta: {
                        mode: 'edit',
                        title: 'Usuarios'
                    }
                },
                {
                    path: 'permisos/:id/editar',
                    name: 'user-permissions-edit',
                    component: Permissions,
                    meta: {
                        mode: 'edit',
                        title: 'Usuarios'
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