<template>
    <div class="pt-section-default">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>{{$t('login_subtitle')}}</span>
            </p>
            <h2 class="pt-title">
                {{$t('login_title')}}
            </h2>

            <form class="pt-form">
                <div class="pt-form--group">
                    <p class="pt-form--label">
                        {{$t('email')}} :
                    </p>
                    <pt-input type="email" :modelValue="email" icon="email"
                              @update:modelValue="newValue => email = newValue"
                    ></pt-input>
                </div>
                <div class="pt-form--group">
                    <p class="pt-form--label">
                        {{$t('password')}} :
                    </p>
                    <pt-input type="password" :modelValue="password" icon="password"
                              @update:modelValue="newValue => password = newValue"
                    ></pt-input>
                </div>

                <div class="pt-form--group">
                    <div class="pt-form--info">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="check" v-model="checkbox">
                            {{$t('remember_me')}}
                        </label>
                        <p>
                            <a href="forgot-password">
                                {{$t('password_forgot')}}
                            </a>
                        </p>
                    </div>
                </div>

                <div class="pt-form--group">
                    <button class="pt-btn pt-md" v-on:click="SendLogin">{{$t('login_btn')}}</button>
                </div>

                <div class="pt-form--group">
                    <p class="pt-form--text">
                        {{$t('register_text')}} <a href="register">{{$t('register_link')}}</a>
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
