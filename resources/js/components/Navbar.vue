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
            <button class="btn btn-navbar" @click="openModal">
                <i class="fa fa-plus-square"></i>
                add note
            </button>
        </span>

        <div class="modal fade" tabindex="-1" ref="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <create-note v-on:note-edited="closeModal"></create-note>
                </div>
            </div>
        </div>

    </nav>

</template>

<script>
import EventBus from '../event-bus';

export default {
    props: ['appname'],
    methods: {
        toggle(){
            EventBus.$emit('toggle-sidebar', null);
        },
        openModal(id){
            $(this.$refs.modal).modal('show')
        },
        closeModal(){
            $(this.$refs.modal).modal('hide')
        },
    }
}
</script>