<template>
    <div>
        <h1>Hello Admin</h1>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    props: ['user', 'data'],
    mounted() {
        this.$store.commit('setNotifications', this.data.notifications);
        this.$store.commit('setMessages', this.data.count_of_unread_messages);
        this.$store.commit('initStore', this.user);
        this.$store.dispatch('messageListener');
        this.emitter.on('response-success-true', e => {
            this.response_success_true = true;
            setTimeout(() => {
                this.response_success_true = false;
            },2000);
        });
    }
}
</script>

<style scoped>

</style>
