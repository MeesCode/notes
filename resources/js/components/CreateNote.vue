<template>
    <div>

        <div class="card mb-0">
            <div class="card-body">
                <h5 v-if="!edit" class="card-title">Create a note</h5>
                <h5 v-else class="card-title">Edit a note</h5>
                <form v-on:submit.prevent="() => { if(edit){ createNote('editNote') } else { createNote('addNote') }}" >

                    <div class="form-group">
                        <textarea v-if="!edit" ref="text" name="text" class="form-control" placeholder="enter text"></textarea>
                        <textarea v-else ref="text" name="text" class="form-control" :value="note.text"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="file" ref="file" name="file" class="form-control-file">
                    </div>

                    <color-picker v-if="edit" :color="note.color" v-on:color-change="changeColor"></color-picker>
                    <color-picker v-else color="white" v-on:color-change="changeColor"></color-picker>

                    <button v-if="!edit" type="submit" class="btn btn-primary">
                        create note
                    </button>
                    <button v-else type="submit" class="btn btn-primary">
                        edit note
                    </button>							
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                color: this.edit ? this.note.color : 'white',
                id: this.edit ? this.note.id : 0
            }
        },
        props: ['edit', 'note'],
        methods: {
            changeColor(c) {
                this.color = c
            },
            getBase64(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => resolve(error);
                });
            },
            createNote(fun){
                this.$emit('note-edited', null)
                if(this.$refs.file.files[0]){
                    this.getBase64(this.$refs.file.files[0])
                    .then(encodedFile => {
                        let note = {
                            text: this.$refs.text.value,
                            color: this.color,
                            file: encodedFile,
                            archived: this.edit ? this.note.archived : false,
                            id: this.id
                        }
                        this.$store.dispatch(fun, note)
                        this.$refs.text.value = ""
                        this.$refs.file.value = ""
                    })
                } else {
                    let note = {
                        text: this.$refs.text.value,
                        color: this.color,
                        archived: this.edit ? this.note.archived : false,
                        id: this.id
                    }
                    this.$store.dispatch(fun, note)
                    this.$refs.text.value = ""
                    this.$refs.file.value = ""
                }
            },
        },
    }
</script>
