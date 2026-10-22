import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createRouter, createWebHistory } from 'vue-router'

import App from './views/App.vue'
import Notes from './views/Notes.vue'
import ApiDetails from './views/ApiDetails.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/notes', name: 'notes', component: Notes },
        { path: '/api-details', name: 'api details', component: ApiDetails },
        { path: '/:pathMatch(.*)*', redirect: '/notes' },
    ],
})

// initial data is rendered by the server into a JSON script tag
const data = JSON.parse(document.getElementById('app-data').textContent)

createApp(App, data)
    .use(createPinia())
    .use(router)
    .mount('#app')
