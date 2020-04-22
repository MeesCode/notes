<template>
    
    <nav class="navbar fixed-top navbar-expand-md navbar-dark shadow-sm">

        <a class="navbar-brand cursor-pointer mr-auto" @click="toggle">
            <i class="fa fa-bars mr-2"></i>
            MeesNote
        </a>

        <span class="search-nav navbar-nav ml-auto mr-auto w-25">
            <search></search>
        </span>

        <span class="navbar-nav ml-auto">
            <create-from-poppup></create-from-poppup>
        </span>

    </nav>

</template>

<script>
import EventBus from '../event-bus';

export default {
    props: ['appname'],
    methods: {
        toggle(){
            EventBus.$emit('toggle-sidebar', null);
        }
    }
}
</script>