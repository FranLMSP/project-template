import Pace from 'pace-js'

export function initialize(store, router) {

    const user = store.getters.currentUser

    axios.defaults.headers.common['Content-Type'] = 'application/json'

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

        if(requiresAdmin && !currentUser.admin) {
            next('/')
            toastr.error('No tiene permisos para realizar esta acción.')
        }
    })

    let numberOfAjaxCAllPending = 0
    // Add a request interceptor
    axios.interceptors.request.use(function (config) {
        numberOfAjaxCAllPending++
        Pace.start()

        return config
    }, function (error) {
        return Promise.reject(error)
    })


    axios.interceptors.response.use(response => {
        numberOfAjaxCAllPending--
        // Do something with response data
        if (numberOfAjaxCAllPending == 0) {
              Pace.stop() 
        }
        return response
    }, error => {
        numberOfAjaxCAllPending--
        if (numberOfAjaxCAllPending == 0) {
             Pace.stop() 
        }

        if(error.response.status == 401) {
            store.commit('logout')

            router.push('/login')
        }

        if(error.response.status == 403) {
            toastr.error('No tiene permisos para realizar esta acción.')
            router.push('/')
        }

        return Promise.reject(error)
    })

}