<template>
    <section class="card">
        <h1>API access</h1>
        <p class="muted">Use this token to read and write your notes from other apps. Keep it secret.</p>

        <div class="token">
            <code>{{ store.user.api_token }}</code>
            <button class="icon-btn" aria-label="Copy token" title="Copy" @click="copy">
                <Copy :size="20" />
            </button>
        </div>

        <pre class="code-block"><code>curl -H "Authorization: Bearer {{ store.user.api_token }}" \
     {{ origin }}/api/notes</code></pre>
    </section>
</template>

<script setup>
import { Copy } from '@lucide/vue'
import { useNotesStore } from '../store'

const store = useNotesStore()
const origin = window.location.origin

function copy() {
    navigator.clipboard.writeText(store.user.api_token)
        .then(() => store.notify('Token copied'))
        .catch(() => store.notify('Could not copy the token'))
}
</script>
