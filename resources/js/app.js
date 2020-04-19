
require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from "./store/index"

const store = new Vuex.Store(
   storeData
)

Vue.component('note-list', require('./components/NoteList.vue').default);
Vue.component('note', require('./components/Note.vue').default);
Vue.component('create-note', require('./components/CreateNote.vue').default);
Vue.component('color-picker', require('./components/ColorPicker.vue').default);

const app = new Vue({
    el: '#app',
    store,
});
