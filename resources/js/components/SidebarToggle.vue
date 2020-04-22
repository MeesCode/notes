<template>
    <a class="navbar-brand cursor-pointer mr-auto" @click="toggle">
        <i class="fa fa-bars mr-2"></i>
        {{appname}}
    </a>
</template>

<script>
import EventBus from '../event-bus';

export default {
    props: ['appname'],
    methods: {
        toggle(){
            EventBus.$emit('toggle-sidebar', null);
            document.getElementById('sidebar').classList.toggle('active')
        }
    }
}
</script>