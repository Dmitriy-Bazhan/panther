<template>
     <svg class="pt-icon">
        <use v-if="type" :xlink:href="'/images/sprite.svg#'+ type"></use>
        <use width="40px" height="40px" v-else :xlink:href="'/images/sprite.svg#empty-type'"></use>
    </svg>
</template>

<script>
    export default {
        name: "pt-icon",
        props: ['type'],
        methods: {

        }
    }
</script>

<style scoped>

</style>
