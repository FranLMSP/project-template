import Template from './components/views/Template.vue'

import Login from './components/views/auth/Login.vue'

export const routes = [
    {
        path: '/login',
        component: Login
    },
    {
        path: '/',
        component: Template,
        meta: {
            requiresAuth: true,
            title: 'Inicio'
        },
    }
]