<template>
    <div>
        <h1>Overview</h1>
    </div>
</template>

<script>
    export default {
        name: "Overview",
        props: ['data'],
        mounted() {
            console.log(this.$i18n);
            console.log(this.$i18n.messages);
        }
    }
</script>

<style scoped>

</style>
