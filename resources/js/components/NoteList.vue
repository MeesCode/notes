<template>
    <div class="card-columns">
        <div v-for="note of getAllNotes" v-bind:key="note.id">
            <note :note="note"></note>
        </div>
    </div>
</template>

<script>
export default {
    props: ['filter'],
    mounted() {
        console.log(this.filter)
        this.$store.dispatch('getNotes', this.filter)
    },
    computed: {
        getAllNotes(){
            return this.$store.getters.getNotes
        }
    },

};
</script>
