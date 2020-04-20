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

                    <div class="form-group">
                        <a v-if="edit && note.file" @click="removeImage" type="submit" class="text-danger">
                            remove image
                        </a>
                    </div>

                    <div class="form-group">
                        <color-picker v-if="edit" :color="color" v-on:color-change="changeColor"></color-picker>
                        <color-picker v-else :color="color" v-on:color-change="changeColor"></color-picker>
                    </div>

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
            emptyFields(){
                this.$refs.text.value = ""
                this.$refs.file.value = ""
            },
            removeImage(){
                this.$emit('note-edited', null)
                let note = {
                    id: this.note.id,
                    file: ""
                }
                this.$store.dispatch('editNote', note)
            },
            createNote(fun){
                this.$emit('note-edited', null)

                let note = {}

                if(this.edit){
                    note.id = this.note.id
                    if(this.color != this.note.color){
                        note.color = this.color
                    }
                    if(this.$refs.text.value != this.note.text){
                        note.text = this.$refs.text.value
                    }
                } else {
                    note.text = this.$refs.text.value
                    note.color = this.color
                }

                if(this.$refs.file.files[0]){
                    this.getBase64(this.$refs.file.files[0])
                    .then(encodedFile => {
                        note.file = encodedFile
                        this.$store.dispatch(fun, note)
                        this.emptyFields()
                    })
                } else {
                    this.$store.dispatch(fun, note)
                    this.emptyFields()
                }
            },
        },
    }
</script>
