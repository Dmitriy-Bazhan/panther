<template>
    <div class="container-fluid">
        <div class="row">

            <div v-if="auth == null" class="col-2 offset-10">
                <a href="login"><button>Login</button></a>
                <a href="register"><button>Register</button></a>
            </div>

            <div v-else class="col-2 offset-10">
                <span>{{ auth.first_name }}</span>
                <button v-on:click="logOut">Log out</button>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "Header",
    props: {
        auth: Object,
    },
    mounted() {
    },
    methods : {
        logOut(){
            axios.get('/log-out')
                .then((response) => {
                    if(response.data.success){
                        location.href = '/';
                    }
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
