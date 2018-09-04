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
            children: [
                {
                    path: 'crear',
                    name: 'user-create',
                    component: Form,
                    meta: {
                        mode: 'create'
                    }
                },
                {
                    path: ':id/editar',
                    name: 'user-edit',
                    component: Form,
                    meta: {
                        mode: 'edit'
                    }
                },
                {
                    path: 'permisos/:id/editar',
                    name: 'user-permissions-edit',
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