<template>
    <div ref="grid" class="note-grid">
        <div v-if="store.visibleNotes.length === 0" class="empty">
            <StickyNote :size="56" />
            <p>{{ emptyText }}</p>
        </div>
        <div v-for="(column, i) of columns" v-else :key="i" class="note-col">
            <note v-for="note of column" :key="note.id" :note="note" />
        </div>
    </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'
import { StickyNote } from '@lucide/vue'
import { useNotesStore } from '../store'
import Note from '../components/Note.vue'

const store = useNotesStore()
const grid = ref(null)
const columnCount = ref(2)

// spread notes left-to-right over the columns so the newest notes stay on top
const columns = computed(() => {
    const cols = Array.from({ length: columnCount.value }, () => [])
    store.visibleNotes.forEach((note, i) => cols[i % columnCount.value].push(note))
    return cols
})

const emptyText = computed(() => {
    if (store.filter.text) {
        return `No notes match "${store.filter.text}"`
    }
    if (store.filter.archived) {
        return 'Your archive is empty'
    }
    return 'No notes yet. Create your first one!'
})

let observer
onMounted(() => {
    observer = new ResizeObserver(([entry]) => {
        const width = entry.contentRect.width
        const minWidth = width < 600 ? 150 : 240
        const gap = width < 600 ? 10 : 16
        columnCount.value = Math.max(1, Math.floor((width + gap) / (minWidth + gap)))
    })
    observer.observe(grid.value)
})
onBeforeUnmount(() => observer.disconnect())
</script>
