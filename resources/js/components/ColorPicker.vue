<template>
    <div>
        <i v-for="c of colors" :key="c" 
        @click="setColor(c)" 
        :class="[{active: c == curColor, blank: c == 'white'}, `color-picker mr-1 d-inline-block background-${c}`]"
        ></i>
    </div>
</template>

<script>
export default {
    data(){
        return {
            curColor: this.color,
            colors: ['white', 'pink', 'red', 'orange', 'yellow', 'green', 'turqoise', 'blue', 'purple']
        }
    },
    props: {
        color: {
            type: String
        }
    },
    methods: {
        setColor(c){
            this.curColor = c
            this.$emit('color-change', c)
        }
    }
}
</script>
