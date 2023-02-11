
require('./bootstrap');

import Vue from 'vue/dist/vue'

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
Vue.component('search', require('./components/Search.vue').default);
Vue.component('notification', require('./components/Notification.vue').default);

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

function toBool(s){
    if(s == null || s == undefined){
        return null
    }
    if(s == 'true' || s == '1' || s == 1 || s == true){
        return true
    }
    return false
}

new Vue({
    el: '#app',
    components: { App },
    router,
    store,
    mounted: function(){
        //set initial filter

        let filter = {
            archived: null,
            color: null,
            text: null
        }

        // default filter
        if(Object.keys(this.$route.query).length === 0){
            console.log('no query')
            filter.archived = false
        } 
        
        // get from query string
        else {
            if(this.$route.query.archived != undefined){
                filter.archived = toBool(this.$route.query.archived)
            }
            if(this.$route.query.color != undefined){
                filter.color = this.$route.query.color
            }
            if(this.$route.query.text != undefined){
                filter.text = this.$route.query.text
            }
        }

        this.$store.dispatch('setFilter', filter)
    }
});