<template>
    <div class="container-fluild">
        <div class="row">

            <div class="col-4 offset-4">
                <h1>Login</h1>

                <form>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="email">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" v-model="password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button class="btn btn-primary" v-on:click="SendLogin">Send</button>
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
                        location.href = '/dashboard';
                    }else{
                        this.errors = response.data.errors;
                        console.log(this.errors);
                    }
                })
                .catch((error) => {
                    // console.log(error.response.data.errors);

                });
        }
    }
}
</script>

<style scoped>

</style>
