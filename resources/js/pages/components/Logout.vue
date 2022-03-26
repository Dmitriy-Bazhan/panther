<template>
    <span v-on:click="logOut" class="menu-item-name">&nbsp;{{ $t('log_out') }}</span>
</template>

<script>
export default {
    name: "Logout",
    methods : {
        logOut() {
            axios.get('/log-out')
                .then((response) => {
                    if (response.data.success) {
                        location.href = '/';
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
}
</script>

<style scoped>
    .menu-item-name {
        font-size: 14px;
        font-weight: 700;
        color: black;
    }
</style>
