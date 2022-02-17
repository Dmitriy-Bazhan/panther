<template>
    <div>
        <pf-header :auth="authUsers" v-if="showHeader"></pf-header>

        <router-view></router-view>

        <pf-footer v-if="showFooter"></pf-footer>
    </div>
</template>

<script>
export default {
    name: "app",

    data() {
        return {
            auth: window.guard,
            authUsers: null,
            showHeader: true,
            showFooter: true,
        }
    },
    mounted() {

        this.emitter.on('not-show-layouts', e => {
            this.showHeader = false;
            this.showFooter = false;
        });

        if (this.auth !== 'guest') {
            axios.get('/get-auth')
                .then((response) => {
                    this.authUsers = response.data.auth;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
    methods: {}

}
</script>

<style scoped>

</style>
