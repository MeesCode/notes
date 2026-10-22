<template>
    <form class="search" role="search" @submit.prevent="search">
        <SearchIcon class="search-icon" :size="20" />
        <input ref="input" v-model="text" class="input" type="search" placeholder="Search notes"
            aria-label="Search notes" enterkeyhint="search" @search="onSearch">
    </form>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import { Search as SearchIcon } from '@lucide/vue'
import { useNotesStore } from '../store'

const store = useNotesStore()
const router = useRouter()
const input = ref(null)
const text = ref('')

watch(() => store.filter.text, t => { text.value = t ?? '' }, { immediate: true })

function search() {
    router.push({ name: 'notes', query: text.value ? { text: text.value } : {} })
    // hide the on-screen keyboard after searching
    input.value.blur()
}

// fired when the native clear button is used
function onSearch() {
    if (!text.value) {
        search()
    }
}
</script>
