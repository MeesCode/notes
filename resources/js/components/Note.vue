<template>
    <article class="note" :class="[`note-${note.color}`, { archived: note.archived }]">
        <button v-if="note.has_image" class="note-image" aria-label="View image" @click="store.viewingImage = imgSrc">
            <img :src="imgSrc" alt="" loading="lazy">
        </button>

        <div class="note-body" @click="editFromBody">
            <div ref="text" class="note-text" :class="{ collapsed: !expanded, faded: !expanded && overflowing }" v-html="html"></div>
        </div>

        <div class="note-actions">
            <span v-if="note.archived && store.filter.archived !== true" class="note-badge">archived</span>

            <button v-if="overflowing || expanded" class="icon-btn" :title="expanded ? 'Collapse' : 'Expand'" :aria-label="expanded ? 'Collapse note' : 'Expand note'" @click="expanded = !expanded">
                <Minimize2 v-if="expanded" :size="20" />
                <Maximize2 v-else :size="20" />
            </button>
            <button class="icon-btn note-edit" title="Edit" aria-label="Edit note" @click="store.editing = note">
                <Pencil :size="20" />
            </button>
            <button class="icon-btn" :title="note.archived ? 'Unarchive' : 'Archive'" :aria-label="note.archived ? 'Unarchive note' : 'Archive note'" @click="toggleArchive">
                <ArchiveRestore v-if="note.archived" :size="20" />
                <Archive v-else :size="20" />
            </button>
            <button class="icon-btn" title="Delete" aria-label="Delete note" @click="deleteNote">
                <Trash2 :size="20" />
            </button>
        </div>
    </article>
</template>

<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import { Archive, ArchiveRestore, Maximize2, Minimize2, Pencil, Trash2 } from '@lucide/vue'
import MarkdownIt from 'markdown-it'
import { full as emoji } from 'markdown-it-emoji'
import DOMPurify from 'dompurify'
import { useNotesStore } from '../store'

const md = new MarkdownIt({
    html: true,
    linkify: true,
    breaks: true,
}).use(emoji)

const props = defineProps(['note'])
const store = useNotesStore()

const text = ref(null)
const expanded = ref(false)
const overflowing = ref(false)

const html = computed(() => DOMPurify.sanitize(md.render(props.note.text || '')))
const imgSrc = computed(() =>
    `/api/get_image?api_token=${store.user.api_token}&id=${props.note.id}&t=${props.note.image_name}`
)

// only offer the expand button when the collapsed text is actually cut off
function measure() {
    if (!expanded.value && text.value) {
        overflowing.value = text.value.scrollHeight > text.value.clientHeight + 1
    }
}

let observer
onMounted(() => {
    observer = new ResizeObserver(measure)
    observer.observe(text.value)
})
onBeforeUnmount(() => observer.disconnect())
watch(html, () => nextTick(measure))

// tapping the note opens the editor, unless a link was clicked or text was selected
function editFromBody(e) {
    if (e.target.closest('a') || window.getSelection().toString()) {
        return
    }
    store.editing = props.note
}

function toggleArchive() {
    const archived = !props.note.archived
    store.editNote({ id: props.note.id, archived })
        .then(() => store.notify(archived ? 'Note archived' : 'Note restored'))
        .catch(error => store.notify(error))
}

function deleteNote() {
    if (confirm('This will permanently delete this note')) {
        store.deleteNote(props.note.id)
            .then(() => store.notify('Note deleted'))
            .catch(error => store.notify(error))
    }
}
</script>
