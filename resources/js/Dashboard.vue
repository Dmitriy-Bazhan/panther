<template>
    <div>
        <h1>Dashboard</h1>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            auth: window.guard,
            authUsers: null,
        }
    },
    mounted() {
        if (this.auth !== 'guest') {
            axios.get('/get-auth')
                .then((response) => {
                    this.authUsers = response.data.auth;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>

</style>
