<template>
    <nav id="sidebar" v-bind:class="{'active': active}">
    <ul class="list-unstyled components">

            <li class="nav-item divider mt-3">toggles</li>
        
            <li class="nav-item cursor-pointer">
                <router-link :to="{ name: 'active' }">
                    <i class="mr-2 fa fa-sticky-note"></i>
                    active
                </router-link>
            </li>

            <li class="nav-item cursor-pointer">
                <router-link :to="{ name: 'archive' }">
                    <i class="mr-2 fa fa-archive"></i>
                    archive
                </router-link>
            </li>


            <li class="nav-item divider mt-3">pages</li>

            <li class="nav-item">
                <router-link :to="{ name: 'api details' }">
                    <i class="mr-2 fa fa-cog"></i>
                    api details
                </router-link>
            </li>

            <li class="nav-item divider mt-3">actions</li>
            
            <li class="nav-item">
                <a class="dropdown-item" href="/logout">
                    <i class="mr-2 fa fa-sign-out"></i>
                    logout
                </a>
            </li>

    </ul>
    
</nav>
</template>

<script>
import EventBus from '../event-bus';

export default {
    data(){
        return{
            active: false
        }
    },
    mounted(){
        EventBus.$on('toggle-sidebar', (payLoad) => {
            this.active = !this.active
        });
    },
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