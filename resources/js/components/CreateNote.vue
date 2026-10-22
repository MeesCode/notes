<template>
    <form class="editor" :class="`note-${color}`" @submit.prevent="save" @keydown.ctrl.enter="save" @keydown.meta.enter="save">
        <div class="editor-header">
            <h2>{{ isEdit ? 'Edit note' : 'New note' }}</h2>
            <button type="button" class="icon-btn" aria-label="Close" @click="emit('done')">
                <X :size="22" />
            </button>
        </div>

        <div class="editor-body">
            <textarea v-model="text" :data-autofocus="isEdit ? null : ''" class="textarea" rows="8" placeholder="Take a note..." aria-label="Note text"></textarea>
            <p class="editor-hint">Markdown supported · Ctrl+Enter to save</p>

            <div v-if="imagePreview" class="editor-image">
                <img :src="imagePreview" alt="">
                <button type="button" class="icon-btn" aria-label="Remove image" @click="clearImage">
                    <Trash2 :size="20" />
                </button>
            </div>

            <color-picker v-model="color" />
        </div>

        <div class="editor-footer">
            <label class="btn btn-ghost file-btn">
                <ImagePlus :size="20" />
                {{ imagePreview ? 'Replace image' : 'Add image' }}
                <input ref="fileInput" type="file" accept="image/*" @change="pickFile">
            </label>
            <span class="spacer"></span>
            <button type="submit" class="btn btn-primary" :disabled="saving">
                {{ isEdit ? 'Save' : 'Create' }}
            </button>
        </div>
    </form>
</template>

<script setup>
import { computed, onBeforeUnmount, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { ImagePlus, Trash2, X } from '@lucide/vue'
import { useNotesStore } from '../store'
import ColorPicker from './ColorPicker.vue'

const props = defineProps(['note'])
const emit = defineEmits(['done'])

const store = useNotesStore()
const route = useRoute()
const router = useRouter()

const isEdit = props.note.id !== undefined
const text = ref(props.note.text ?? '')
const color = ref(props.note.color ?? 'white')
const file = ref(null)
const fileUrl = ref(null)
const removeImage = ref(false)
const saving = ref(false)
const fileInput = ref(null)

const imagePreview = computed(() => {
    if (fileUrl.value) {
        return fileUrl.value
    }
    if (isEdit && props.note.has_image && !removeImage.value) {
        return `/api/get_image?api_token=${store.user.api_token}&id=${props.note.id}&t=${props.note.image_name}`
    }
    return null
})

onBeforeUnmount(() => fileUrl.value && URL.revokeObjectURL(fileUrl.value))

function pickFile(e) {
    if (fileUrl.value) {
        URL.revokeObjectURL(fileUrl.value)
    }
    file.value = e.target.files[0] ?? null
    fileUrl.value = file.value ? URL.createObjectURL(file.value) : null
}

function clearImage() {
    pickFile({ target: { files: [] } })
    fileInput.value.value = ''
    removeImage.value = true
}

function getBase64(f) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader()
        reader.onload = () => resolve(reader.result)
        reader.onerror = reject
        reader.readAsDataURL(f)
    })
}

async function save() {
    if (saving.value) {
        return
    }

    const note = {}
    if (isEdit) {
        note.id = props.note.id
        if (color.value !== props.note.color) {
            note.color = color.value
        }
        if (text.value !== props.note.text) {
            note.text = text.value
        }
    } else {
        if (!text.value.trim() && !file.value) {
            emit('done')
            return
        }
        note.text = text.value
        note.color = color.value
        note.has_image = false
    }

    saving.value = true
    try {
        if (file.value) {
            note.has_image = true
            note.image_data = await getBase64(file.value)
        } else if (isEdit && removeImage.value && props.note.has_image) {
            note.has_image = false
        }

        if (isEdit) {
            await store.editNote(note)
        } else {
            await store.addNote(note)
            // make sure the new note is visible
            const f = store.filter
            if (route.name !== 'notes' || f.archived === true || f.text || (f.color && f.color !== color.value)) {
                router.push({ name: 'notes' })
            }
        }
        emit('done')
    } catch (error) {
        store.notify(typeof error === 'string' ? error : 'could not read the image')
    } finally {
        saving.value = false
    }
}
</script>
