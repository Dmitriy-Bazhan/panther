<template>
        <button v-on:click="logOut" class="btn btn-sm btn-success">Log out</button>
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

</style>
