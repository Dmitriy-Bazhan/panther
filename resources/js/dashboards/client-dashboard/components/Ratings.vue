<template>
    <div>
        <h1>Ratings</h1>
    </div>
</template>

<script>
export default {
    name: "Ratings",
    props: ['user', 'data'],
    data() {
        return {
            path: location.origin,
        }
    },
    mounted() {

    },
    methods: {

    }
}
</script>

<style scoped>

</style>
