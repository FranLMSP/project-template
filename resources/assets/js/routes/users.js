import Main from '../components/views/users/Main.vue'
import List from '../components/views/users/List.vue'
import Form from '../components/views/users/Form.vue'
import Show from '../components/views/users/Show.vue'

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
            component: List
        },
        {
            path: 'crear',
            component: Form,
            meta: {
                mode: 'create'
            }
        },
        {
            path: ':id/editar',
            component: Form,
            meta: {
                mode: 'edit'
            }
        },
        {
            path: ':id',
            component: Show
        }
    ]
}