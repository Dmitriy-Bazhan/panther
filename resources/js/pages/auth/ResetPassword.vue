<template>
    <div class="pt-section-default">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>{{$t('reset_password_subtitle')}}</span>
            </p>
            <h2 class="pt-title">
                {{$t('reset_password')}}
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
                    <pt-input type="password" :modelValue="password" icon="password" placeholder="min 8 symbols"
                              @update:modelValue="newValue => password = newValue"
                    ></pt-input>
                </div>

                <div class="pt-form--group">
                    <p class="pt-form--label">
                        {{$t('password_confirmation')}} :
                    </p>
                    <pt-input type="password" :modelValue="password_confirmation" icon="password"
                              @update:modelValue="newValue => password_confirmation = newValue"
                    ></pt-input>
                </div>

                <div class="pt-form--group">
                    <button class="pt-btn pt-md" v-on:click="SendNewPassword">{{$t('reset_password')}}</button>
                </div>
            </form>

            <p v-if="errors !== null" v-for="error in errors">{{ error }}</p>

        </div>
    </div>
</template>

<script>
    export default {
        name: "ResetPassword",
        props: ['data'],
        data() {
            return {
                token: null,
                email: null,
                password: null,
                password_confirmation: null,
                errors: null,
                checkbox: false,
            };
        },
        mounted() {
            console.log(this.data);
            this.token = this.data.token;
        },
        methods: {
            SendNewPassword(event) {
                event.preventDefault();
                axios.post('/reset-password',
                    {
                        'email': this.email,
                        'password': this.password,
                        'token': this.token,
                        'password_confirmation': this.password_confirmation
                    })
                    .then((response) => {
                        if (response.data.success) {
                            location.href = '/login';
                        } else {
                            this.errors = response.data.errors;
                        }
                    })
                    .catch((error) => {
                        console.log(error.response.data.errors);

                    });
            }
        }
    }
</script>

<style scoped>

</style>
