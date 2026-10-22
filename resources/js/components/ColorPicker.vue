<template>
    <div class="color-picker" role="group" aria-label="Color">
        <button v-for="c of colors" :key="c" type="button"
            :class="['swatch', { active: isActive(c) }]"
            :style="{ background: `var(--note-${c})` }"
            :title="label(c)" :aria-label="label(c)" :aria-pressed="isActive(c)"
            @click="emit('update:modelValue', c)">
            <Check v-if="isActive(c)" :size="18" />
        </button>
    </div>
</template>

<script setup>
import { Check } from '@lucide/vue'

const props = defineProps({
    modelValue: String,
    // what the "white" swatch means in this context
    defaultLabel: { type: String, default: 'Default' },
})
const emit = defineEmits(['update:modelValue'])

const colors = ['white', 'pink', 'red', 'orange', 'yellow', 'green', 'turqoise', 'blue', 'purple']

function isActive(c) {
    return c === props.modelValue || (c === 'white' && !props.modelValue)
}

function label(c) {
    if (c === 'white') {
        return props.defaultLabel
    }
    return c === 'turqoise' ? 'Teal' : c[0].toUpperCase() + c.slice(1)
}
</script>
