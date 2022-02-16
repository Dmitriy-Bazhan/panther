<template>
    <div class="container-fluild">
        <div class="row">

            <div class="col-4 offset-4">
                <h1>Login</h1>

                <form>
                    <div class="mb-3">
                        <label for="input_email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="input_email" aria-describedby="emailHelp" v-model="email">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="input_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="input_password" v-model="password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="check">
                        <label class="form-check-label" for="check">Check me out</label>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-primary" v-on:click="SendLogin">Send</button>
                        </div>
                        <div class="col-2 offset-8">
                            <button class="btn btn-primary" v-on:click="backToHome">Back</button>
                        </div>
                    </div>
                </form>

                <p v-if="errors !== null" v-for="error in errors">{{ error }}</p>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            email: null,
            password: null,
            errors : null
        };
    },
    methods: {
        SendLogin(event){
            event.preventDefault();
            axios.post('/login', {'email' : this.email, 'password' : this.password})
                .then((response) => {
                    console.log(response);
                    if(response.data.success){
                        location.href = '/dashboard/' + response.data.dashboards;
                    }else{
                        this.errors = response.data.errors;
                        console.log(this.errors);
                    }
                })
                .catch((error) => {
                    // console.log(error.response.data.errors);

                });
        },
        backToHome(event){
            event.preventDefault();
            location.href = '/';
        }
    }
}
</script>

<style scoped>

</style>
