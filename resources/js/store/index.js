export default {

	state: {
        notes: [],
        filter: {
            archived: false,
            color: null
        }
	},

	getters: {

        getNotes(state){ 
            return state.notes
        },

        getFilter(state){ 
            return state.filter
        },

	},

	actions: {

        setFilter(context, filter){
            context.commit('filter', filter)
        },

        getNotes(context, filter){
            let s = ''
            for(let [v, k] of Object.entries(filter)){
                if(k !== null) {
                    s += `&${v}=${k}`
                }
            }
            fetch(`api/notes?api_token=${window.user.api_token}${s}`, {
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


	},

	mutations: {
        filter(state,filter) {
            return state.filter = filter
        },
        notes(state,data) {
            return state.notes = data
        },
        deleteNote(state, id){
            let index = state.notes.findIndex(i => i.id == id)
            return state.notes.splice(index, 1)
        },
        addNote(state, note){
            if(!state.filter.archived){
                return state.notes.unshift(note)
            }
            return state.notes
        },
        updateNote(state, note){
            let index = state.notes.findIndex(i => i.id == note.id)
            if(note.archived != state.notes[index].archived){
                return state.notes.splice(index, 1)
            }
            return state.notes.splice(index, 1, note)
        },
	}
}