export default {

	state: {
        notes: [],
	},

	getters: {

        allNotes(state){ 
            return state.notes
        },

	},

	actions: {

        allNotes(context){
            fetch(`api/notes?api_token=${window.user.api_token}`, {
                "headers": {
                    "Content-Type": "application/json",
                },
                "method": "GET",
                "mode": "cors" })
            .then(res => {
                if(res.status != 200) {
                    console.log('the server did not accept our request')
                    return
                }
                res.json()
                .then(notes => {
                    context.commit('notes', notes)
                })
            })
            .catch(err => console.log('could not fetch resource', err))
        },

        allArchivedNotes(context){
            fetch(`api/archived_notes?api_token=${window.user.api_token}`, {
                "headers": {
                    "Content-Type": "application/json",
                },
                "method": "GET",
                "mode": "cors" })
            .then(res => {
                if(res.status != 200) {
                    console.log('the server did not accept our request')
                    return
                }
                res.json()
                .then(notes => {
                    context.commit('notes', notes)
                })
            })
            .catch(err => console.log('could not fetch resource', err))
        },

        deleteNote(context, id){
            fetch('api/delete_note', {
                "headers": {
                    "Content-Type": "application/json",
                },
                "body": JSON.stringify({
                    api_token: window.user.api_token,
                    id: id,
                }),
                "method": "DELETE",
                "mode": "cors" })
            .then(res => {
                if(res.status != 200) {
                    console.log('the server did not accept our request')
                    return
                }
                res.json()
                .then(context.commit('deleteNote', id))
            })
            .catch(err => console.log('could not fetch resource', err))
        },

        addNote(context, note){
            fetch('api/create_note', {
                "headers": {
                    "Content-Type": "application/json",
                },
                "body": JSON.stringify({
                    api_token: window.user.api_token,
                    note: note,
                }),
                "method": "POST",
                "mode": "cors" })
            .then(res => {
                if(res.status != 200) {
                    console.log('the server did not accept our request')
                    return
                }
                res.json()
                .then(note => {
                    context.commit('addNote', note)
                })
            })
            .catch(err => console.log('could not fetch resource', err))
        },

        editNote(context, note){
            fetch('api/edit_note', {
                "headers": {
                    "Content-Type": "application/json",
                },
                "body": JSON.stringify({
                    api_token: window.user.api_token,
                    note: note,
                }),
                "method": "PATCH",
                "mode": "cors" })
            .then(res => {
                if(res.status != 200) {
                    console.log('the server did not accept our request')
                    return
                }
                res.json()
                .then(note => {
                    context.commit('updateNote', note)
                })
            })
            .catch(err => console.log('could not fetch resource', err))
        },

        toggleArchiveNote(context, id){
            fetch('api/toggle_archive', {
                "headers": {
                    "Content-Type": "application/json",
                },
                "body": JSON.stringify({
                    api_token: window.user.api_token,
                    id: id,
                }),
                "method": "PATCH",
                "mode": "cors" })
            .then(res => {
                if(res.status != 200) {
                    console.log('the server did not accept our request')
                    return
                }
                res.json()
                .then(note => context.commit('deleteNote', note.id))
            })
            .catch(err => console.log('could not fetch resource', err))
    }

	},

	mutations: {
        notes(state,data) {
            return state.notes = data
        },
        deleteNote(state, id){
            let index = state.notes.findIndex(i => i.id == id)
            return state.notes.splice(index, 1)
        },
        addNote(state, note){
            return state.notes.push(note)
        },
        updateNote(state, note){
            let index = state.notes.findIndex(i => i.id == note.id)
            return state.notes.splice(index, 1, note)
        },
	}
}