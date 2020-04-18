export default {

	state: {
       notes: []
	},

	getters: {

       allNotes(state){ 
          return state.notes
       }

	},

	actions: {

        allNotesFromDatabase(context){
            fetch(`api/notes?api_token=${window.user.api_token}`, {
                "headers": {
                    "Content-Type": "application/json",
                },
                "method": "GET",
                "mode": "cors" })
            .then(data => data.json())
            .then(notes => {
                context.commit('notes', notes)
            })
        },

        deleteNoteFromDatabase(context, id){
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
            .then(data => data.json())
            .then(notes => {
                context.commit('notes', notes)
            })
        },

        addNoteToDatabase(context, note){
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
            .then(data => data.json())
            .then(notes => {
                context.commit('notes', notes)
            })
        }

	},

	mutations: {
       notes(state,data) {
          return state.notes = data
       }
	}
}