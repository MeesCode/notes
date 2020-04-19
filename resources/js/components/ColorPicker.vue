<template>
    <div>
        <i v-for="c of colors" :key="c" 
        @click="setColor(c)" 
        :class="[{active: c == curColor}, `color-picker mr-1 d-inline-block background-${c}`]"
        ></i>
    </div>
</template>

<script>
export default {
    data(){
        return {
            curColor: this.color,
            colors: ['red', 'blue', 'green', 'white', 'yellow', 'pink', 'purple', 'orange', 'turqoise', 'brown', 'grey']
        }
    },
    props: {
        color: {
            type: String,
            default: 'white'
        }
    },
    mounted(){
        this.$emit('color-change', this.color)
    },
    methods: {
        setColor(c){
            this.curColor = c
            this.$emit('color-change', c)
        }
    }
}
</script>
