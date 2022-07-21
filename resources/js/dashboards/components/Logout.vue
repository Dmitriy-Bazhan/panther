<template>
  <button class="pt-btn" v-on:click="logOut">
    <pt-icon type="log_in"></pt-icon>
    {{ $t('log_out') }}
  </button>
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
