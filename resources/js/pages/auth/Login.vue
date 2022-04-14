<template>
    <div class="pt-section-default">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>login</span>
            </p>
            <h2 class="pt-title">
                Auf der Plattform anmelden
            </h2>

            <form class="pt-form">
                <div class="pt-form--group">
                    <p class="pt-form--label">
                        E-Mail  :
                    </p>
                    <pt-input type="email" :modelValue="email" icon="email"
                              @update:modelValue="newValue => email = newValue"
                    ></pt-input>
                </div>
                <div class="pt-form--group">
                    <p class="pt-form--label">
                        Passwort :
                    </p>
                    <pt-input type="password" :modelValue="password" icon="password"
                              @update:modelValue="newValue => password = newValue"
                    ></pt-input>
                </div>

                <div class="pt-form--group">
                    <div class="pt-form--info">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="check" v-model="checkbox">
                            Remember Me
                        </label>
                        <p>
                            <a href="">
                                Passwort vergessen?
                            </a>
                        </p>
                    </div>
                </div>

                <div class="pt-form--group">
                    <button class="pt-btn pt-md" v-on:click="SendLogin">login</button>
                </div>

                <div class="pt-form--group">
                    <p class="pt-form--text">
                        Neues Konto erstellen. <a href="register">Registrierung</a>
                    </p>
                </div>
<!--                <button class="btn btn-primary" v-on:click="backToHome">Back</button>-->
            </form>

            <p v-if="errors !== null" v-for="error in errors">{{ error }}</p>



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
            errors : null,
            checkbox: false,
        };
    },
    mounted() {
    },
    methods: {
        SendLogin(event){
            event.preventDefault();
            axios.post('/login', {'email' : this.email, 'password' : this.password, 'checkbox' : this.checkbox})
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
                    console.log(error.response.data.errors);

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
