<template>
    <div class="pt-section-default">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>{{$t('forgot_password_subtitle')}}</span>
            </p>
            <h2 class="pt-title">
                {{$t('forgot_password_title')}}
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
                    <button class="pt-btn pt-md" v-on:click="SendLinkOnEmail">{{$t('send_link_on_email')}}</button>
                </div>

            </form>

            <p v-if="errors !== null" v-for="error in errors">{{ error }}</p>

        </div>
    </div>
</template>

<script>
    export default {
        name: "ForgotPassword",
        data(){
            return {
                email: null,
                errors : null,
            }
        },
        mounted() {
        },
        methods: {
            SendLinkOnEmail(event){
                event.preventDefault();
                axios.post('/forgot-password', {'email' : this.email})
                    .then((response) => {
                        if(response.data.success){
                            location.href = '/';
                        }else{
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
