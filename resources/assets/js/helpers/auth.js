export function login(credentials) {
    return new Promise( (res, rej) => {
        axios.post('/api/auth/login', credentials)
            .then( response => {
                res(response.data)
            })
            .catch( err => {
                console.log(err)
                rej('Usuario o contraseña inválidos')
            })
    })
}

export function getLocalUser() {
    const userStr = localStorage.getItem('user')

    if(!userStr) {
        return null
    }

    return JSON.parse(userStr)
}