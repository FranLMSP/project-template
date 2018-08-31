require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'

import {routes} from './routes'
import StoreData from './store'
import MainApp from './components/MainApp.vue'

import {initialize} from './helpers/general'

import BootstrapVue from 'bootstrap-vue'

Vue.use(VueRouter)
vue.use(Vuex)

Vue.use(BootstrapVue)

const store = new Vuex.Store(StoreData)

const router = new VueRouter({
    routes,
    mode: 'history'
})

initialize(store, router)

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
})
