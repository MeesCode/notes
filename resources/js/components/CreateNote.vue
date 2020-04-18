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

    </div>
</template>

<script>
    export default {
        methods: {
            createNote(){
                let note = {
                    title: this.$refs.title.value,
                    text: this.$refs.text.value
                }
                this.$refs.title.value = ""
                this.$refs.text.value = ""
                this.$store.dispatch("addNoteToDatabase", note)
            },
        },
    }
</script>
