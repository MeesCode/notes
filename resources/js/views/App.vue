<template>
    <div>
        <navbar :appname="appname"></navbar>
        <div class="wrapper">

            <sidebar></sidebar>

            <div id="content">

                <div class="search-content">
                    <search></search>
                </div>

                <main class="pt-2 mb-5">
                    <div class="my-container">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <router-view></router-view>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </div> 

        <notification></notification> 
    </div>
</template>

<script>
export default {
    props: ['notes', 'user', 'appname'],
    mounted() {
        this.$store.dispatch('setNotes', this.notes)
        this.$store.dispatch('setUser', this.user)
    },
    watch: {
        '$route.params': function (val) {
            this.$store.dispatch('setFilter', this.$route.query)
        },
    }
}
</script>