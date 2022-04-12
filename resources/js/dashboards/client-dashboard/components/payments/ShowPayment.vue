<template>
    <div>
        <pre>
        {{ payment }}
        </pre>
    </div>
</template>

<script>
    export default {
        name: "ShowPayment",
        props: ['payment'],
    }
</script>

<style scoped>

</style>
