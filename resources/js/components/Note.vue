<template>
    <div class="card mt-3">

        <img v-if="note.file" class="card-img-top" :src="`/api/get_image?api_token=${api_token}&id=${note.id}`">


        <div class="card-body">
            <h5 class="card-title">{{ note.title }}</h5>
            <p class="card-text">{{ note.text }}

            <div class="float-right text-right inline-block">
                <button class="btn p-0" type="submit">
                    <i @click="toggleArchiveNode(note.id)" class="fa fa-archive text-primary"></i>
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
                api_token: window.user.api_token
            }
        },
        props: ['note'],
        methods: {
            deleteNode(id){
                this.$store.dispatch("deleteNote", id)
            },
            toggleArchiveNode(id){
                this.$store.dispatch("toggleArchiveNote", id)
            },
        },
    }
</script>
