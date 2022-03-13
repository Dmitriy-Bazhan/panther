<template>
    <div class="main-left-panel">
        <h5>
            Main Left Panel
        </h5>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">Home</li>
            <li v-if="user.entity_type !== 'nurse' && user" class="list-group-item"><router-link :to="{ name : 'Listing' }">Listing</router-link></li>
            <li class="list-group-item">Bookings</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "LeftPanel",
        props: ['user'],
        mounted() {
            // console.log(this.user);
        }

    }
</script>

<style scoped>
    .main-left-panel {
        height: 100%;
        background: #d9d9d9;
        min-height: calc(100vh - 50px);
    }
    .list-group-item {
        background: #d9d9d9;
    }

    .list-group-item:hover {
        background: #f8f7f7;
    }
</style>
