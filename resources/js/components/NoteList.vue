<template>
    <div v-masonry='masonryId' transition-duration="0.5s" item-selector=".note_tile">
        <div v-for="note of getAllNotes" v-bind:key="note.id" v-masonry-tile class="note_tile">
            <note v-on:img-loaded="redraw" :note="note"></note>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        masonryId: 'note_grid',
    }),
    props: ['filter', 'notes'],
    mounted() {
        this.$store.dispatch('setFilter', this.filter)
        this.$store.dispatch('setNotes', this.notes)
    },
    methods:{
        redraw(){
            this.$redrawVueMasonry(this.masonryId)
        }
    },
    computed: {
        getAllNotes(){
            return this.$store.getters.getNotes
        }
    },
    watch: {
        getAllNotes(val){
            setTimeout(() => {
                this.redraw()
            }, 20)
        }
    }

};
</script>
