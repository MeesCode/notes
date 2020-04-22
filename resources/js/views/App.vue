<template>
    <div>
        <navbar></navbar>
        <div class="wrapper">

            <sidebar></sidebar>

            <div id="content">

                <div class="search-content">
                    <!-- @auth -->
                        <!-- @if($toggles ?? '') -->
                            <search></search>
                        <!-- @endif -->
                    <!-- @endauth -->
                </div>

                <main class="py-4">
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
    </div>
</template>

<script>
export default {
    props: ['notes', 'user'],
    mounted() {
        this.$store.dispatch('setNotes', this.notes)
        this.$store.dispatch('setUser', this.user)
    }
}
</script>