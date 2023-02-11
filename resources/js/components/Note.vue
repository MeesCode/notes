<template>
    <div>
        <div ref="card" :data-archived="note.archived" class="card mb-0 d-inline-block" :class="`d-inline-block background-${note.color}`">

            <img v-if="note.has_image" @load="$emit('img-loaded', null)" @click="imgModalOpen" :key="note.file" class="cursor-pointer card-img-top" :src="imgSrc">

            <div class="card-body">
                <div v-html="markdown"></div>

                <div class="float-left text-left">
                    
                </div>

                <div class="float-right text-right">
                    <button v-if="markdown.length > 230" class="btn p-0" type="submit">
                        <i v-if="!expanded" @click="expand()" title="expand note" class="fa fa-expand text-white note-edit-button"></i>
                        <i v-else @click="expand()" title="expand note" class="fa fa-compress text-white note-edit-button"></i>
                    </button>	
                    <button class="btn p-0" type="submit">
                        <i @click="editNode()" title="edit this note" class="fa fa-edit text-white note-edit-button"></i>
                    </button>	
                    <button class="btn p-0" type="submit">
                        <i @click="toggleArchiveNode(note.id)" title="toggle archive" class="fa fa-archive text-white note-edit-button"></i>
                    </button>						
                    <button class="btn p-0" type="submit">
                        <i @click="deleteNode(note.id)" title="delete this note" class="fa fa-trash text-white note-edit-button"></i>
                    </button>						
                </div>
            </div>

        </div>

        <div class="modal fade" tabindex="-1" ref="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <create-note v-on:note-edited="closeModal" edit="true" :note="note"></create-note>
                </div>
            </div>
        </div>

        <div v-if="note.has_image" class="modal fade" tabindex="-1" ref="imgModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <img class="w-100" :src="imgSrc">
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import EventBus from '../event-bus';

    import MarkdownIt from 'markdown-it'
    import emoji from 'markdown-it-emoji'
    const md = new MarkdownIt({
        html: true,
        linkify: true,
        breaks: true
    });
    md.use(emoji)

    export default {
        data(){
            return{
                expanded: false,
            }
        },
        props: ['note'],
        computed: {
            imgSrc: function(){
                return `/api/get_image?api_token=${this.$store.getters.getUser.api_token}&id=${this.note.id}&t=${this.note.image_name}`
            },
            markdown: function(){
                let t = md.render(this.note.text)
                let span = document.createElement('span');
                span.innerHTML = t;
                if(span.textContent.length > 230 && !this.expanded){
                    return t.substring(0,230) + '<span>...</span>'
                }
                return t
            }
        },
        methods: {
            expand(){
                this.expanded = !this.expanded
                EventBus.$emit('redraw', null);
            },
            editNode(id){
                $(this.$refs.modal).modal('show')
            },
            imgModalOpen(id){
                $(this.$refs.imgModal).modal('show')
            },
            closeModal(){
                $(this.$refs.modal).modal('hide')
            },
            deleteNode(id){
                if(confirm('This will permanently delete this note')){
                    this.$store.dispatch("deleteNote", id)
                    .catch(error => EventBus.$emit('notification', error))
                }
            },
            toggleArchiveNode(){
                let n = {
                    id: this.note.id,
                    archived: !this.note.archived
                }
                this.$store.dispatch('editNote', n)
                .catch(error => EventBus.$emit('notification', error))
            },
        },
    }
</script>
