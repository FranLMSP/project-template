export function initialize(store, router) {

    const user = store.getters.currentUser

    axios.defaults.headers.common['Content-Type'] = 'application/json';

    if(user) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${store.getters.currentUser.token}`
    }
    
    router.beforeEach( (to, from, next) => {
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
        const requiresAdmin = to.matched.some(record => record.meta.requiresAdmin)
        const currentUser = store.state.currentUser
        
        if(requiresAuth && !currentUser) {
            next('/login')
        } else if(to.path == '/login' && currentUser) {
            next('/')
        } else {
            next()
        }

        console.log(currentUser)

        if(requiresAdmin && !currentUser.admin) {
            next('/');
            M.toast({
                html: 'Usted no tiene privilegios para ver este módulo',
                classes: 'red'
            })
        }
    })


    axios.interceptors.response.use(null, error => {
        if(error.response.status == 401) {
            store.commit('logout')

            router.push('/login')
        }

        if(error.response.status == 403) {
            router.push('/');
            M.toast({
                html: 'Usted no tiene privilegios para ver este módulo',
                classes: 'red'
            })
        }

        return Promise.reject(error)
    })

}