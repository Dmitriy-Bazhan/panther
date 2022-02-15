<template>

    <div>
        <pf-header :auth="authUsers"></pf-header>

        <router-view></router-view>

        <pf-footer></pf-footer>
    </div>

</template>

<script>
export default {
    name: "app",
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
