<template>
    <form class="search" v-on:submit.prevent="search">
        <input class="form-control mr-2" ref="text" type="search" placeholder="Search">
        <button class="btn btn-navbar d-inline-block" type="submit">
            <i class="d-block fa fa-search"></i>
        </button>
    </form>
</template>

<script>
export default {
    methods: {
        search(){
            let filter = {archived: null, color: null}
            filter.text = this.$refs.text.value
            this.$refs.text.value = ""
            this.$router.push({ path: 'notes', query: filter })
        }
    }
}
</script>