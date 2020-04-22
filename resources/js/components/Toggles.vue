<template>
    <div>
        <li class="nav-item cursor-pointer">
            <a @click="active">
                <i class="mr-2 fa fa-sticky-note"></i>
                acitve
            </a>
        </li>

        <li class="nav-item cursor-pointer">
            <a @click="archived">
                <i class="mr-2 fa fa-archive"></i>
                archive
            </a>
        </li>
    </div>
</template>

<script>
export default {
    methods: {
        archived(){
            let filter = this.$store.getters.getFilter
            filter.archived = true
            delete filter.search
            this.$store.dispatch('setFilter', filter)
            this.$store.dispatch('getNotes', filter)
        },
        active(){
            let filter = this.$store.getters.getFilter
            filter.archived = false
            delete filter.search
            this.$store.dispatch('setFilter', filter)
            this.$store.dispatch('getNotes', filter)
        }
    },
}
</script>