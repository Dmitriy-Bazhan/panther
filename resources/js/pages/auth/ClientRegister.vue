<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <h1>{{ $t('client_register') }}</h1>

                <!-- first name -->
                <div class="row">
                    <div class="col-6">
                        <label for="first_name" class="form-label col-form-label-sm">{{ $t('name') }}</label>
                        <input type="text" class="form-control form-select-sm" id="first_name" v-model="client.first_name">
                        <span class="register-form-error" v-if="errors !== null && errors.first_name !== undefined">{{ errors.first_name[0] }}</span>
                    </div>

                <!-- last name -->
                    <div class="col-6">
                        <label for="last_name" class="form-label col-form-label-sm">{{ $t('last_name') }}</label>
                        <input type="text" class="form-control form-select-sm" id="last_name" v-model="client.last_name">
                        <span class="register-form-error" v-if="errors !== null && errors.last_name !== undefined">{{ errors.last_name[0] }}</span>
                    </div>
                </div>

                <!-- email -->
                <div class="row">
                    <div class="col-3">
                        <label for="email" class="form-label col-form-label-sm">{{ $t('email') }}</label>
                    </div>
                    <div class="col-9">
                        <input type="email" class="form-control form-select-sm" id="email" aria-describedby="emailHelp"
                               v-model="client.email">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        <span class="register-form-error" v-if="errors !== null && errors.email !== undefined">{{ errors.email[0] }}</span>
                    </div>
                </div>

                <!-- phone -->
                <div class="row">
                    <div class="col-3">
                        <label for="phone" class="form-label col-form-label-sm">{{ $t('phone') }}</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control form-select-sm" id="phone" v-model="client.phone">
                        <span class="register-form-error" v-if="errors !== null && errors.phone !== undefined">{{ errors.phone[0] }}</span>
                    </div>
                </div>

                <!-- zip code -->
                <div class="row">
                    <div class="col-3">
                        <label for="zip_code" class="form-label col-form-label-sm">{{ $t('zip_code') }}</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control form-select-sm" id="zip_code" v-model="client.zip_code">
                        <span class="register-form-error" v-if="errors !== null && errors.zip_code !== undefined">{{ errors.zip_code[0] }}</span>
                    </div>
                </div>

                <!-- password -->
                <div class="row">
                    <div class="col-3">
                        <label for="password" class="form-label col-form-label-sm">{{ $t('password') }}</label>
                    </div>
                    <div class="col-9">
                        <input type="password" class="form-control form-select-sm" id="password" v-model="client.password">
                        <span class="register-form-error" v-if="errors !== null && errors.password !== undefined">{{ errors.password[0] }}</span>
                    </div>
                </div>

                <!-- password confirm-->
                <div class="row">
                    <div class="col-3">
                        <label for="password_confirm" class="form-label col-form-label-sm">{{ $t('password_confirm') }}</label>
                    </div>
                    <div class="col-9">
                        <input type="password" class="form-control form-select-sm" id="password_confirm"
                               v-model="client.password_confirmation">
                    </div>
                </div>

                <!-- hear about us -->
                <div class="row">
                    <div class="col-3">
                        <label for="hear_about_us" class="form-label col-form-label-sm">{{ $t('hear_about_us') }}</label>
                    </div>
                    <div class="col-9">
                        <select id="hear_about_us" class="form-select form-select-sm"
                                v-model="client.hear_about_us">
                            <option v-if="data.hear_about_us.length > 0"
                                    v-for="hear_about_us in data.hear_about_us"
                                    v-bind:value="hear_about_us.id">
                                {{ filterHearAboutUs(hear_about_us) }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- hear about us other -->
                <div class="row">
                    <div class="col-3">
                        <label for="hear_about_us_other"
                               class="form-label col-form-label-sm">{{ $t('hear_about_us_other') }}</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control form-control-sm" id="hear_about_us_other"
                               v-model="client.hear_about_us_other">
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <button class="btn btn-primary btn-sm" v-on:click="sendForm">Send</button>
                    </div>
                    <div class="col-2 offset-8">
                        <button class="btn btn-primary btn-sm" v-on:click="backToHome">Back</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ClientRegister",
        props: ['data'],
        data() {
            return {
                client: {
                    first_name: null,
                    last_name: null,
                    email: null,
                    phone: null,
                    zip_code: null,
                    password: null,
                    password_confirmation: null,
                    hear_about_us: null,
                    hear_about_us_other: null,
                },
                errors: null,
                locale: window.localStorage.getItem('locale'),
            };
        },
        mounted() {
        },
        methods: {
            sendForm(event) {
                event.preventDefault();
                this.client.locale = this.locale;
                axios.post('/client-register', {'data': this.client})
                    .then((response) => {
                        this.errors = null;
                        console.log(response);
                        if (response.data.success) {
                            location.href = '/email/verify';
                        } else {
                            this.errors = response.data.errors;
                        }
                    })
                    .catch((error) => {
                        // console.log(error.response.data.errors);

                    });
            },
            backToHome(event) {
                event.preventDefault();
                location.href = '/register';
            },
            filterHearAboutUs(hear_about_as) {
                let lang = this.locale;
                let el = hear_about_as.data.filter(function (value) {
                    if (value.lang == lang) {
                        return value;
                    }
                });
                return el[0].data;
            }
        }
    }
</script>

<style scoped>

</style>
