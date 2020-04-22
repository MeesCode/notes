<template>
    <form class="search" v-on:submit.prevent="search">
        <input class="form-control mr-2" ref="search" type="search" placeholder="Search">
        <button class="btn btn-outline-light d-inline-block" type="submit">
            <i class="d-block fa fa-search"></i>
        </button>
    </form>
</template>

<script>
export default {
    methods: {
        search(){
            let filter = this.$store.getters.getFilter
            filter.search = this.$refs.search.value
            delete filter.archived
            this.$store.dispatch('setFilter', filter)
            this.$store.dispatch('getNotes', filter)
        }
    }
}
</script>