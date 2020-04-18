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

                    <div class="form-group">
                        <label for="file">File</label>
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
        methods: {
            getBase64(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => resolve(error);
                });
            },
            createNote(){
                if(this.$refs.file.files[0]){
                    this.getBase64(this.$refs.file.files[0])
                    .then(encodedFile => {
                        let note = {
                            title: this.$refs.title.value,
                            text: this.$refs.text.value,
                            file: encodedFile,
                        }
                        this.$store.dispatch("addNoteToDatabase", note)
                        this.$refs.title.value = ""
                        this.$refs.text.value = ""
                        this.$refs.text.file = []
                    })
                } else {
                    let note = {
                        title: this.$refs.title.value,
                        text: this.$refs.text.value,
                    }
                    this.$store.dispatch("addNoteToDatabase", note)
                    this.$refs.title.value = ""
                    this.$refs.text.value = ""
                    this.$refs.text.file = []
                }
            },
        },
    }
</script>
