<template>
    <navbar :appname="appname" />

    <div class="layout">
        <sidebar />
        <main class="content">
            <router-view />
        </main>
    </div>

    <button class="fab" aria-label="New note" @click="store.editing = {}">
        <Plus :size="28" />
    </button>

    <app-dialog class="dialog" :open="store.editing !== null" @close="store.editing = null">
        <create-note v-if="store.editing !== null" :note="store.editing" @done="store.editing = null" />
    </app-dialog>

    <app-dialog class="dialog-image" :open="store.viewingImage !== null" @close="store.viewingImage = null">
        <img v-if="store.viewingImage" :src="store.viewingImage" alt="">
        <button class="icon-btn" aria-label="Close image" @click="store.viewingImage = null">
            <X :size="22" />
        </button>
    </app-dialog>

    <notification />
</template>

<script setup>
import { watch } from 'vue'
import { useRoute } from 'vue-router'
import { Plus, X } from '@lucide/vue'
import { useNotesStore } from '../store'
import Navbar from '../components/Navbar.vue'
import Sidebar from '../components/Sidebar.vue'
import CreateNote from '../components/CreateNote.vue'
import AppDialog from '../components/AppDialog.vue'
import Notification from '../components/Notification.vue'

const props = defineProps(['notes', 'user', 'appname'])

const store = useNotesStore()
store.notes = props.notes
store.user = props.user

// the url query is the source of truth for the active filter
const route = useRoute()
watch(() => route.query, query => store.setFilterFromQuery(query), { immediate: true })
</script>
