<template>
    <div class="card-columns">
        <div v-for="note of getAllNotes" v-bind:key="note.id">
            <note :note="note"></note>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.$store.dispatch("allNotesFromDatabase")
    },
    computed: {
        getAllNotes(){
            return this.$store.getters.allNotes
        }
    },

};
</script>
