<template>
    <div>

        <div class="card mb-0">
            <div class="card-body">
                <h5 v-if="!edit" class="card-title">Create a note</h5>
                <h5 v-else class="card-title">Edit a note</h5>
                <form v-on:submit.prevent="() => { if(edit){ editNote() } else { createNote() }}" >

                    <div class="form-group">
                        <textarea v-if="!edit" ref="text" name="text" class="form-control textarea-navbar" rows="10" placeholder="enter text"></textarea>
                        <textarea v-else ref="text" name="text" class="form-control textarea-navbar" rows="10" :value="note.text"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="file" ref="image" name="image" class="form-control-file">
                    </div>

                    <div class="form-group">
                        <a v-if="edit && note.has_image" @click="removeImage" class="text-danger">
                            remove image
                        </a>
                    </div>

                    <div class="form-group">
                        <color-picker v-if="edit" :color="color" v-on:color-change="changeColor"></color-picker>
                        <color-picker v-else :color="color" v-on:color-change="changeColor"></color-picker>
                    </div>

                    <button v-if="!edit" type="submit" class="btn btn-navbar">
                        <i class="fa fa-plus-square"></i>
                        create note
                    </button>
                    <button v-else type="submit" class="btn btn-navbar">
                        <i class="fa fa-edit"></i>
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
                this.$refs.image.value = ""
            },
            removeImage(){
                this.$emit('note-edited', null)
                let note = {
                    id: this.note.id,
                    has_image: false,
                    image_name: null
                }
                this.$store.dispatch('editNote', note)
            },
            generateNote(){
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
                    note.has_image = false
                }
                return note
            },
            createNote(){
                this.$emit('note-edited', null)

                let note = this.generateNote()

                let filter = this.$store.getters.getFilter
                filter.archived = false
                delete filter.search
                this.$store.dispatch('setFilter', filter)

                if(this.$refs.image.files[0]){
                    this.getBase64(this.$refs.image.files[0])
                    .then(encodedFile => {
                        note.has_image = true
                        note.image_data = encodedFile
                        this.$store.dispatch('addNote', note)
                        this.emptyFields()
                    })
                } else {
                    this.$store.dispatch('addNote', note)
                    this.emptyFields()
                }
            },
            editNote(){
                this.$emit('note-edited', null)

                let note = this.generateNote()

                if(this.$refs.image.files[0]){
                    this.getBase64(this.$refs.image.files[0])
                    .then(encodedFile => {
                        note.has_image = true
                        note.image_data = encodedFile
                        this.$store.dispatch('editNote', note)
                        this.emptyFields()
                    })
                } else {
                    this.$store.dispatch('editNote', note)
                    this.emptyFields()
                }
            },
        },
    }
</script>
