<template>
    <div class="toast" :class="{ visible: store.toast }" role="status" aria-live="polite">
        {{ message }}
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useNotesStore } from '../store'

const store = useNotesStore()

// keep showing the last message while the toast slides out
const message = ref('')
watch(() => store.toast, t => { if (t) message.value = t })
</script>
