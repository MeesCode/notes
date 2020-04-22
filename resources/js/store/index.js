export default {

	state: {
        notes: [],
        filter: {
            archived: null,
            color: null,
            text: null
        },
        user: {}
	},

	getters: {

        getNotes(state){ 
            return state.notes.filter(note => {
                return ((state.filter.archived == null || note.archived == state.filter.archived) &&
                    (state.filter.color == null || state.filter.color == note.color) &&
                    (state.filter.text == null || note.text.toLowerCase().includes(state.filter.text.toLowerCase())))
            })
        },

        getAllNotes(state){ 
            return state.notes
        },

        getFilter(state){ 
            return state.filter
        },

        getUser(state){ 
            return state.user
        },

	},

	actions: {

        setFilter({commit, getters}, filter){
            commit('filter', filter)
        },

        setUser({commit, getters}, user){
            commit('user', user)
        },

        setNotes({commit, getters}, notes){
            commit('notes', notes)
        },

        getNotes({commit, getters}, filter){
            filter.api_token = getters.getUser.api_token
            const params = new URLSearchParams(filter).toString();
            fetch(`api/notes?${params}`, {
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
                    commit('notes', notes)
                })
            })
            .catch(err => console.log('could not fetch resource', err))
        },

        deleteNote({commit, getters}, id){
            fetch('api/delete_note', {
                "headers": {
                    "Content-Type": "application/json",
                },
                "body": JSON.stringify({
                    api_token: getters.getUser.api_token,
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
                .then(commit('deleteNote', id))
            })
            .catch(err => console.log('could not fetch resource', err))
        },

        addNote({commit, getters}, note){
            fetch('api/create_note', {
                "headers": {
                    "Content-Type": "application/json",
                },
                "body": JSON.stringify({
                    api_token: getters.getUser.api_token,
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
                    commit('addNote', note)
                })
            })
            .catch(err => console.log('could not fetch resource', err))
        },

        editNote({commit, getters}, note){
            fetch('api/edit_note', {
                "headers": {
                    "Content-Type": "application/json",
                },
                "body": JSON.stringify({
                    api_token: getters.getUser.api_token,
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
                    commit('updateNote', note)
                })
            })
            .catch(err => console.log('could not fetch resource', err))
        },


	},

	mutations: {
        filter(state,filter) {
            return state.filter = filter
        },
        user(state,user) {
            return state.user = user
        },
        notes(state,data) {
            return state.notes = data
        },
        deleteNote(state, id){
            let index = state.notes.findIndex(i => i.id == id)
            return state.notes.splice(index, 1)
        },
        addNote(state, note){
            return state.notes.unshift(note)
        },
        updateNote(state, note){
            let index = state.notes.findIndex(i => i.id == note.id)
            return state.notes.splice(index, 1, note)
        },
	}
}