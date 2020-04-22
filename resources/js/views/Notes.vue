<template>
    <div v-masonry='masonryId' transition-duration="0.5s" item-selector=".note_tile">
        <div v-for="note of getNotes" v-bind:key="note.id" v-masonry-tile class="note_tile">
            <note v-on:img-loaded="redraw" :note="note"></note>
        </div>
    </div>
</template>

<script>
import EventBus from '../event-bus';

export default {
    data: () => ({
        masonryId: 'note_grid'
    }),
    mounted() {
        EventBus.$on('toggle-sidebar', (payLoad) => {
            setTimeout(() => {
                this.redraw()
            }, 300)
        });
    },
    methods:{
        redraw(){
            this.$redrawVueMasonry(this.masonryId)
        }
    },
    computed: {
        getNotes(){
            return this.$store.getters.getNotes
        },
        getFilter(){
            return this.$store.getters.getFilter
        },
    },
    watch: {
        filter(val){
            this.$store.dispatch('setFilter', this.filter)
        },
        getNotes(val){
            setTimeout(() => {
                this.redraw()
            }, 100)
        }
    }

};
</script>
