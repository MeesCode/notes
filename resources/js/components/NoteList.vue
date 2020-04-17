<template>
    <div>

        <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                <form v-on:submit.prevent="createNote()" >
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" ref="title" name="title" class="form-control" id="title" placeholder="enter title">
                    </div>
                    <div class="form-group">
                        <label for="text">Text</label>
                        <input type="text" ref="text" name="text" class="form-control" id="text" placeholder="enter text">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        create note
                    </button>						
                </form>
            </div>
        </div>

        <div class="card-columns">
            <div v-for="note of notes" v-bind:key="note.id" class="card mt-3">
                <div class="card-header">
                    {{ note.title }}
                </div>

                <div class="card-body">
                    {{ note.text }}

                    <div class="float-right text-right inline-block">
                        <button class="btn p-0" type="submit">
                            <i class="fa fa-archive text-primary"></i>
                        </button>						
                        <button class="btn p-0" type="submit">
                            <i @click="deleteNode(note.id)" class="fa fa-trash text-danger"></i>
                        </button>						
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                notes: Object
            }
        },
        props: ['access_token'],
        methods: {
            updateNotes(endpoint, body = {}){
                body.access_token = this.access_token
                fetch(endpoint, {
                    "headers": {
                        "Content-Type": "application/json",
                    },
                    "body": JSON.stringify(body),
                    "method": "POST",
                    "mode": "cors" })
                .then(data => data.json())
                .then(notes => {
                    if(!notes.error){
                        this.notes = notes
                    }
                })
            },
            createNote(){
                this.updateNotes("/api/create_note", {
                    title: this.$refs.title.value,
                    text: this.$refs.text.value
                })
                this.$refs.title.value = ""
                this.$refs.text.value = ""
            },
            deleteNode(id){
                this.updateNotes("/api/delete_note", {
                    id: id
                })
            },
        },
        mounted() {
            this.updateNotes("/api/notes")
        }
    }
</script>
