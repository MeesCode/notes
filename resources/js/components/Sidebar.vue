<template>
    <div class="sidebar-scrim" :class="{ open: store.sidebarOpen }" @click="store.sidebarOpen = false"></div>

    <aside class="sidebar" :class="{ open: store.sidebarOpen }" :inert="!store.sidebarOpen" aria-label="Navigation">
        <div class="sidebar-section">Notes</div>
        <router-link :to="{ name: 'notes', query: { archived: 'false' } }" :class="['nav-link', { active: isNotes && store.filter.archived === false && !store.filter.text }]">
            <StickyNote :size="20" />
            Active
        </router-link>
        <router-link :to="{ name: 'notes', query: { archived: 'true' } }" :class="['nav-link', { active: isNotes && store.filter.archived === true && !store.filter.text }]">
            <Archive :size="20" />
            Archive
        </router-link>

        <div class="sidebar-section">Filter by color</div>
        <color-picker :model-value="store.filter.color" default-label="All colors" @update:model-value="changeColor" />

        <div class="sidebar-section">More</div>
        <router-link :to="{ name: 'api details' }" class="nav-link" active-class="active">
            <KeyRound :size="20" />
            API details
        </router-link>
        <button class="nav-link" @click="refresh">
            <RefreshCw :size="20" />
            Refresh notes
        </button>
        <a class="nav-link" href="/logout">
            <LogOut :size="20" />
            Log out
        </a>
    </aside>
</template>

<script setup>
import { computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { Archive, KeyRound, LogOut, RefreshCw, StickyNote } from '@lucide/vue'
import { useNotesStore } from '../store'
import ColorPicker from './ColorPicker.vue'

const store = useNotesStore()
const route = useRoute()
const router = useRouter()

const isNotes = computed(() => route.name === 'notes')

// the drawer covers the page on small screens, so close it after navigating
watch(() => route.fullPath, () => {
    if (!store.isDesktop) {
        store.sidebarOpen = false
    }
})

function changeColor(color) {
    const { archived, text } = store.filter
    const query = {}
    if (archived !== null) {
        query.archived = String(archived)
    }
    if (text) {
        query.text = text
    }
    // white means "show every color"
    if (color !== 'white') {
        query.color = color
    }
    router.push({ name: 'notes', query })
}

function refresh() {
    store.refresh()
        .then(() => store.notify('Notes refreshed'))
        .catch(error => store.notify(error))
}
</script>
