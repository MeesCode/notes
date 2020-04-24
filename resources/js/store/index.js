
function customFetch(url, body, method, commit, commitType){
    return new Promise((resolve, reject) => {
        fetch(url, {
            "headers": {
                "Content-Type": "application/json",
            },
            "method": method,
            "body": body,
            "mode": "cors" })
        .then(res => {
            if(res.status != 200) {
                reject('operation failed, please refresh')
            }
            res.json()
            .then(res => {
                commit(commitType, res)
                resolve('success')
            })
            .catch(error => reject('server returned invalid result'))
        })
        .catch(error => reject('could not contact the server'))
    });
}

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
            for(let [key, value] of Object.entries(filter)){
                if(value == null){
                    delete filter[key]
                }
            }
            const url = `api/notes?${new URLSearchParams(filter).toString()}`
            return customFetch(url, null, 'GET', commit, 'notes')
        },

        deleteNote({commit, getters}, id){
            const body = JSON.stringify({
                api_token: getters.getUser.api_token,
                id: id,
            })
            return customFetch('api/delete_note', body, 'DELETE', commit, 'deleteNote')
        },

        addNote({commit, getters}, note){
            const body = JSON.stringify({
                api_token: getters.getUser.api_token,
                note: note,
            })
            return customFetch('api/create_note', body, 'POST', commit, 'addNote')
        },

        editNote({commit, getters}, note){
            const body = JSON.stringify({
                api_token: getters.getUser.api_token,
                note: note,
            })
            return customFetch('api/edit_note', body, 'PATCH', commit, 'updateNote')
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
        deleteNote(state, note){
            let index = state.notes.findIndex(i => i.id == note.id)
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