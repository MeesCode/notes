<template>
    <dialog ref="el" tabindex="-1" @close="emit('close')" @click="closeOnBackdrop">
        <slot />
    </dialog>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({ open: Boolean })
const emit = defineEmits(['close'])
const el = ref(null)

watch(() => props.open, open => {
    if (open && !el.value.open) {
        el.value.showModal()
        // focus the marked field, or the dialog itself rather than its first button
        const target = el.value.querySelector('[data-autofocus]') ?? el.value
        target.focus()
    } else if (!open && el.value.open) {
        el.value.close()
    }
}, { flush: 'post' })

function closeOnBackdrop(e) {
    if (e.target === el.value) {
        el.value.close()
    }
}
</script>
