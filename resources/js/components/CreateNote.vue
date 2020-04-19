<template>
    <div>

        <div class="card mb-0">
            <div class="card-body">
                <h5 v-if="!edit" class="card-title">Create a note</h5>
                <h5 v-else class="card-title">Edit a note</h5>
                <form v-on:submit.prevent="() => { if(edit){ createNote('editNote') } else { createNote('addNote') }}" >
                    <div class="form-group">
                        <input v-if="!edit" type="text" ref="title" name="title" class="form-control" id="title" placeholder="enter title">
                        <input v-else type="text" ref="title" name="title" class="form-control" id="title" :value="note.title">
                    </div>

                    <div class="form-group">
                        <textarea v-if="!edit" ref="text" name="text" class="form-control" id="text" placeholder="enter text"></textarea>
                        <textarea v-else ref="text" name="text" class="form-control" :value="note.text" id="text"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="file" ref="file" name="file" class="form-control-file" id="file">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        create note
                    </button>						
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['edit', 'note'],
        computed: {
                id: function() {
                    if(this.edit) { 
                        return this.note.id 
                    } else { 
                        return 0 
                    }
                }
            },
        methods: {
            getBase64(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => resolve(error);
                });
            },
            createNote(fun){
                if(this.$refs.file.files[0]){
                    this.getBase64(this.$refs.file.files[0])
                    .then(encodedFile => {
                        let note = {
                            title: this.$refs.title.value,
                            text: this.$refs.text.value,
                            file: encodedFile,
                            id: this.id
                        }
                        this.$store.dispatch(fun, note)
                        this.$refs.title.value = ""
                        this.$refs.text.value = ""
                        this.$refs.text.file = []
                    })
                } else {
                    let note = {
                        title: this.$refs.title.value,
                        text: this.$refs.text.value,
                        id: this.id
                    }
                    this.$store.dispatch(fun, note)
                    this.$refs.title.value = ""
                    this.$refs.text.value = ""
                    this.$refs.text.file = []
                }
            },
        },
    }
</script>
