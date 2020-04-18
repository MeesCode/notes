<template>
    <div class="card mt-3">

        <img v-if="note.file" class="card-img-top" :src="`/api/get_image?access_token=${access_token}&id=${note.id}`">


        <div class="card-body">
            <h5 class="card-title">{{ note.title }}</h5>
            <p class="card-text">{{ note.text }}

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
        data(){
            return {
                access_token: window.user.access_token
            }
        },
        props: ['note'],
        methods: {
            deleteNode(id){
                this.$store.dispatch("deleteNoteFromDatabase", id)
            },
        },
    }
</script>
