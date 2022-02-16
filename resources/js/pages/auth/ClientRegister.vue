<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-4 offset-4">
                <h1>Client register</h1>

                <form>
                    <!-- first name -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First name</label>
                        <input type="text" class="form-control" id="first_name" v-model="data.first_name">
                    </div>

                    <!-- last name -->
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="last_name" v-model="data.last_name">
                    </div>

                    <!-- email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                               v-model="data.email">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <!-- phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" v-model="data.phone">
                    </div>

                    <!-- zip code -->
                    <div class="mb-3">
                        <label for="zip_code" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="zip_code" v-model="data.zip_code">
                    </div>

                    <!-- password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" v-model="data.password">
                    </div>

                    <!-- password confirm-->
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Password confirm</label>
                        <input type="password" class="form-control" id="password_confirm" v-model="data.password_confirm">
                    </div>

                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-primary" v-on:click="sendForm">Send</button>
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
    name: "ClientRegister",
    data() {
        return {
            data : {
                first_name: null,
                last_name: null,
                email: null,
                phone: null,
                zip_code: null,
                password: null,
                password_confirm: null,
            },
            errors : null
        };
    },
    methods: {
        sendForm(event){
            event.preventDefault();
            axios.post('/client-register', {'data' : this.data })
                .then((response) => {
                    console.log(response);
                    if(response.data.success){
                        location.href = response.data.dashboards;
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
