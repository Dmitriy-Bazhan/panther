<template>
    <div>
        <h1>REGULAR</h1>


        <nurse_info :data="data"></nurse_info>
    </div>
</template>

<script>
    import NurseInfo from "./NurseInfo";

    export default {
        name: "RegularBooking",
        props: ['data'],
        components: {
            'nurse_info' : NurseInfo,
        }
    }
</script>

<style scoped>

</style>
