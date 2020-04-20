<template>
    <div>
        <button class="btn btn-outline-light" @click="openModal">
            <i class="fa fa-plus-square"></i>
            add note
        </button>

        <div class="modal fade" tabindex="-1" ref="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <create-note v-on:note-edited="closeModal"></create-note>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        openModal(id){
            $(this.$refs.modal).modal('show')
        },
        closeModal(){
            $(this.$refs.modal).modal('hide')
        },
    }
}
</script>