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
                        <span class="register-form-error" v-if="errors !== null && errors.first_name !== undefined">{{ errors.first_name[0] }}</span>
                    </div>

                    <!-- last name -->
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="last_name" v-model="data.last_name">
                        <span class="register-form-error" v-if="errors !== null && errors.last_name !== undefined">{{ errors.last_name[0] }}</span>
                    </div>

                    <!-- email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                               v-model="data.email">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        <span class="register-form-error" v-if="errors !== null && errors.email !== undefined">{{ errors.email[0] }}</span>
                    </div>

                    <!-- phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" v-model="data.phone">
                        <span class="register-form-error" v-if="errors !== null && errors.phone !== undefined">{{ errors.phone[0] }}</span>
                    </div>

                    <!-- zip code -->
                    <div class="mb-3">
                        <label for="zip_code" class="form-label">Zip code</label>
                        <input type="text" class="form-control" id="zip_code" v-model="data.zip_code">
                        <span class="register-form-error" v-if="errors !== null && errors.zip_code !== undefined">{{ errors.zip_code[0] }}</span>
                    </div>

                    <!-- password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" v-model="data.password">
                        <span class="register-form-error" v-if="errors !== null && errors.password !== undefined">{{ errors.password[0] }}</span>
                    </div>

                    <!-- password confirm-->
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Password confirm</label>
                        <input type="password" class="form-control" id="password_confirm" v-model="data.password_confirmation">
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
                password_confirmation: null,
            },
            errors : null
        };
    },
    mounted() {
        this.emitter.emit('not-show-left-panel');
    },
    methods: {
        sendForm(event){
            event.preventDefault();
            this.data.locale = window.localStorage.getItem('locale');
            axios.post('/client-register', {'data' : this.data })
                .then((response) => {
                    this.errors = null;
                    console.log(response);
                    if(response.data.success){
                        location.href = '/email/verify';
                    }else{
                        this.errors = response.data.errors;
                    }
                })
                .catch((error) => {
                    // console.log(error.response.data.errors);

                });
        },
        backToHome(event){
            event.preventDefault();
            location.href = '/register';
        }
    }
}
</script>

<style scoped>

</style>
