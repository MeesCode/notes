
require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from "./store/index"

const store = new Vuex.Store(
   storeData
)

import {VueMasonryPlugin} from 'vue-masonry';
Vue.use(VueMasonryPlugin)

import VueRouter from 'vue-router'
Vue.use(VueRouter)

Vue.component('sidebar', require('./components/Sidebar.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('note', require('./components/Note.vue').default);
Vue.component('create-note', require('./components/CreateNote.vue').default);
Vue.component('color-picker', require('./components/ColorPicker.vue').default);
Vue.component('create-from-poppup', require('./components/CreateFromPoppup.vue').default);
Vue.component('search', require('./components/Search.vue').default);

import App from './views/App'
import Notes from './views/Notes'
import ApiDetails from './views/ApiDetails'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/notes',
            name: 'notes',
            component: Notes,
        },
        {
            path: '/api-details',
            name: 'api details',
            component: ApiDetails,
        },
        {
            path: '*',
            redirect: '/active'
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
});