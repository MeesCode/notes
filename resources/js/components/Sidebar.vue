<template>
    <nav id="sidebar" v-bind:class="{'active': isActive}">
    <ul class="list-unstyled components">

            <li class="nav-item divider pt-2">filters</li>
        
            <li class="nav-item cursor-pointer">
                <router-link :to="{ name: 'notes', query: {archived: false, color: null, text: null} }">
                    <i class="mr-2 fa fa-sticky-note"></i>
                    active
                </router-link>
            </li>

            <li class="nav-item cursor-pointer">
                <router-link :to="{ name: 'notes', query: {archived: true, color: null, text: null} }">
                    <i class="mr-2 fa fa-archive"></i>
                    archive
                </router-link>
            </li>

            <color-picker class="ml-3 my-2" color="white" v-on:color-change="changeColor"></color-picker>

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
            isActive: true
        }
    },
    methods:{
        changeColor(c){
            let filter = {archived: null, text: null}
            filter.color = c
            this.$router.push({ path: 'notes', query: filter })
        }
    },  
    mounted(){
        EventBus.$on('toggle-sidebar', (payLoad) => {
            this.isActive = !this.isActive
        });
    },
}
</script>