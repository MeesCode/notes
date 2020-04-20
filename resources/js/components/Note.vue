<template>
    <div class="card mt-3 mb-0 d-inline-block" :class="`background-${note.color}`">

        <img v-if="note.file" :key="note.file" class="card-img-top" :src="imgSrc">

        <div class="card-body">
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
                    <create-note v-on:note-edited="closeModal" edit="true" :note="note"></create-note>
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
        computed: {
            imgSrc: function(){
                return `/api/get_image?api_token=${this.api_token}&id=${this.note.id}&t=${this.note.file}`
            }
        },
        methods: {
            editNode(id){
                $(this.$refs.modal).modal('show')
            },
            closeModal(){
                $(this.$refs.modal).modal('hide')
            },
            deleteNode(id){
                this.$store.dispatch("deleteNote", id)
            },
            toggleArchiveNode(){
                let n = {
                    id: this.note.id,
                    archived: !this.note.archived
                }
                this.$store.dispatch('editNote', n)
            },
        },
    }
</script>
