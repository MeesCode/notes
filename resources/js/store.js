import { defineStore } from 'pinia'

const desktop = window.matchMedia('(min-width: 1024px)')
let toastTimer = null

function toBool(s) {
    if (s == null) {
        return null
    }
    return s === true || s === 'true' || s === '1' || s === 1
}

export const useNotesStore = defineStore('notes', {
    state: () => ({
        notes: [],
        filter: {
            archived: false,
            color: null,
            text: null,
        },
        user: {},
        sidebarOpen: desktop.matches,
        // note being edited; `{}` means a new note, null means the editor is closed
        editing: null,
        viewingImage: null,
        toast: null,
    }),

    getters: {
        visibleNotes(state) {
            const { archived, color, text } = state.filter
            return state.notes.filter(note =>
                (archived == null || Boolean(note.archived) === archived) &&
                (color == null || note.color === color) &&
                (!text || note.text.toLowerCase().includes(text.toLowerCase()))
            )
        },
        isDesktop: () => desktop.matches,
    },

    actions: {
        setFilterFromQuery(query) {
            // no query means the default "active notes" view
            if (Object.keys(query).length === 0) {
                this.filter = { archived: false, color: null, text: null }
                return
            }
            this.filter = {
                archived: toBool(query.archived),
                color: query.color || null,
                text: query.text || null,
            }
        },

        notify(message) {
            clearTimeout(toastTimer)
            this.toast = message
            toastTimer = setTimeout(() => { this.toast = null }, 3000)
        },

        async request(url, method = 'GET', body = null) {
            let res
            try {
                res = await fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${this.user.api_token}`,
                    },
                    body: body && JSON.stringify(body),
                })
            } catch (e) {
                throw 'could not contact the server'
            }
            if (!res.ok) {
                throw 'operation failed, please refresh'
            }
            try {
                return await res.json()
            } catch (e) {
                throw 'server returned invalid result'
            }
        },

        async refresh() {
            this.notes = await this.request('/api/notes')
        },

        async deleteNote(id) {
            const note = await this.request('/api/delete_note', 'DELETE', { id })
            this.notes = this.notes.filter(n => n.id !== note.id)
        },

        async addNote(note) {
            this.notes.unshift(await this.request('/api/create_note', 'POST', { note }))
        },

        async editNote(note) {
            const updated = await this.request('/api/edit_note', 'PATCH', { note })
            const index = this.notes.findIndex(n => n.id === updated.id)
            this.notes.splice(index, 1, updated)
        },
    },
})
