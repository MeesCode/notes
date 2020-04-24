<template>
    <div :class="[{'active': isActive}, 'notification']">
        {{notfication}}
    </div>
</template>

<script>
import EventBus from '../event-bus';

export default {
    data(){
        return{
            isActive: false,
            notfication: 'empty notification'
        }
    },
    mounted(){
        EventBus.$on('notification', (payLoad) => {
            this.notfication = payLoad
            this.isActive = true

            setTimeout(() => {
                this.isActive = false
            }, 3000)
        });
    },
}
</script>