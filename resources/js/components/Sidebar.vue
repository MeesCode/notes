<template>
    <nav id="sidebar" v-bind:class="{'active': isActive}">
    <ul class="list-unstyled components">

            <li class="nav-item divider pt-2">filters</li>
        
            <li :class="[{'active': !$store.getters.getFilter.archived && $store.getters.getFilter.archived != null}, 'nav-item cursor-pointer toggle-button']">
                <router-link :to="{name: 'notes', query: {archived: false, color: null, search: null}}">
                    <i class="mr-2 fa fa-sticky-note"></i>
                    active
                </router-link>
            </li>

            <li :class="[{'active': $store.getters.getFilter.archived}, 'nav-item cursor-pointer toggle-button']">
                <router-link :to="{name: 'notes', query: {archived: true, color: null, search: null}}">
                    <i class="mr-2 fa fa-archive"></i>
                    archive
                </router-link>
            </li>

            <color-picker class="ml-3 my-2" :color="$store.getters.getFilter.color" v-on:color-change="changeColor"></color-picker>

            <li class="nav-item divider mt-3">pages</li>

            <li class="nav-item">
                <router-link :to="{ name: 'api details' }">
                    <i class="mr-2 fa fa-cog"></i>
                    api details
                </router-link>
            </li>

            <li class="nav-item divider mt-3">actions</li>

            <li class="nav-item">
                <a @click="refresh" href="javascript: void(0)" class="cursor-pointer">
                    <i class="mr-2 fa fa-refresh"></i>
                    refresh notes
                </a>
            </li>
            
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
            isActive: true, 
        }
    },
    methods:{
        changeColor(val){
            let filter = this.$store.getters.getFilter

            // we ignore white and show everything instead
            if(val == 'white'){
                filter.color = null
            } else {
                filter.color = val
            }

            this.$router.push({ path: 'notes', query: filter })
        },
        refresh(){
            this.$store.dispatch("getNotes", {archived: null, color: null, test: null})
            .then(res => EventBus.$emit('notification', 'notes refreshed'))
            .catch(error => EventBus.$emit('notification', error))
        }
    },  
    mounted(){
        EventBus.$on('toggle-sidebar', (payLoad) => {
            this.isActive = !this.isActive
        });
    },
}
</script>