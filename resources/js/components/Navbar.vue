<template>
    <header class="appbar">
        <button class="icon-btn" aria-label="Toggle menu" :aria-expanded="store.sidebarOpen" @click="store.sidebarOpen = !store.sidebarOpen">
            <Menu :size="24" />
        </button>

        <router-link class="appbar-brand" :to="{ name: 'notes' }">
            <img src="/note.svg" alt="">
            <span>{{ appname }}</span>
        </router-link>

        <div class="appbar-search">
            <search />
        </div>

        <button class="btn btn-primary appbar-new" @click="store.editing = {}">
            <Plus :size="20" />
            New note
        </button>
    </header>
</template>

<script setup>
import { Menu, Plus } from '@lucide/vue'
import { useNotesStore } from '../store'
import Search from './Search.vue'

defineProps(['appname'])
const store = useNotesStore()
</script>
