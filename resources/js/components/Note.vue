<template>
    <div class="card mt-3 mb-0" style="display: inline-block">

        <img v-if="note.file" class="card-img-top" :src="`/api/get_image?api_token=${api_token}&id=${note.id}`">


        <div class="card-body">
            <h5 class="card-title">{{ note.title }}</h5>
            <vue-markdown :source="note.text"></vue-markdown>

            <div class="float-right text-right inline-block">
                <button class="btn p-0" type="submit">
                    <i data-toggle="modal" @click="editNode()" class="fa fa-edit text-primary"></i>
                </button>	
                <button class="btn p-0" type="submit">
                    <i @click="toggleArchiveNode(note.id)" class="fa fa-archive text-primary"></i>
                </button>						
                <button class="btn p-0" type="submit">
                    <i @click="deleteNode(note.id)" class="fa fa-trash text-danger"></i>
                </button>						
            </div>
        </div>

        <div class="modal fade" tabindex="-1" ref="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <create-note edit="true" :note="note"></create-note>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import VueMarkdown from 'vue-markdown'

    export default {
        data(){
            return {
                api_token: window.user.api_token
            }
        },
        props: ['note'],
        components: {
            VueMarkdown
        },
        methods: {
            editNode(id){
                $(this.$refs.modal).modal({
                    backdrop: true,
                    keyboard: true,
                    focus: true,
                    show: true
                })
            },
            deleteNode(id){
                this.$store.dispatch("deleteNote", id)
            },
            toggleArchiveNode(id){
                this.$store.dispatch("toggleArchiveNote", id)
            },
        },
    }
</script>
