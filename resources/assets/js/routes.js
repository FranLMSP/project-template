import Template from './components/views/Template.vue'

import Login from './components/views/auth/Login.vue'
import Profile from './components/views/users/Profile.vue'

import UsersRoutes from './routes/users'
import RolesRoutes from './routes/roles'

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
        children: [
            {
                path: 'perfil',
                component: Profile
            },
            UsersRoutes,
            RolesRoutes,
        ]
    }
]