<template>
    <div class="card mt-3">
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
</template>

<script>
    export default {
        props: ['note'],
        methods: {
            deleteNode(id){
                this.$store.dispatch("deleteNoteFromDatabase", id)
            },
        },
    }
</script>
