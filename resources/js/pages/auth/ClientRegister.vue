<template>
    <div class="pt-section-default">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>{{ $t('client_register') }}</span>
            </p>
            <h2 class="pt-title">
                Registrierung
            </h2>

            <form class="pt-form pt-form--big">
                <div class="pt-form--group">
                    <p class="pt-form--label">
                        {{ $t('name') }} :
                    </p>
                    <pt-input type="text" :modelValue="client.first_name"
                              icon="user"
                              @update:modelValue="newValue => client.first_name = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors.first_name !== undefined">{{ errors.first_name[0] }}</span>
                </div>

                <div class="pt-form--group">
                    <p class="pt-form--label">
                        {{ $t('last_name') }} :
                    </p>
                    <pt-input type="text" :modelValue="client.last_name"
                              icon="user"
                              @update:modelValue="newValue => client.last_name = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors.last_name !== undefined">{{ errors.last_name[0] }}</span>
                </div>

                <div class="pt-form--group">
                    <p class="pt-form--label">
                        {{ $t('phone') }} :
                    </p>
                    <pt-input type="text" :modelValue="client.phone"
                              icon="phone"
                              @update:modelValue="newValue => client.phone = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors.phone !== undefined">{{ errors.phone[0] }}</span>
                </div>

                <div class="pt-form--group">
                    <p class="pt-form--label">
                        {{ $t('zip_code') }} :
                    </p>
                    <pt-input type="text" :modelValue="client.zip_code"
                              icon="home"
                              @update:modelValue="newValue => client.zip_code = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors.zip_code !== undefined">{{ errors.zip_code[0] }}</span>
                </div>

                <div class="pt-form--group pt-lg">
                    <p class="pt-form--label">
                        {{ $t('email') }} :
                    </p>
                    <pt-input type="email" :modelValue="client.email"
                              icon="email"
                              @update:modelValue="newValue => client.email = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors.email !== undefined">{{ errors.email[0] }}</span>
                </div>

                <div class="pt-form--group">
                    <p class="pt-form--label">
                        {{ $t('password') }} :
                    </p>
                    <pt-input type="password" :modelValue="client.password"
                              icon="password"
                              @update:modelValue="newValue => client.password = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors.password !== undefined">{{ errors.password[0] }}</span>
                </div>

                <div class="pt-form--group">
                    <p class="pt-form--label">
                        {{ $t('password_confirm') }} :
                    </p>
                    <pt-input type="password" :modelValue="client.password_confirmation"
                              icon="password"
                              @update:modelValue="newValue => client.password_confirmation = newValue"
                    ></pt-input>
                </div>

                <div class="pt-form--group pt-lg">
                    <p class="pt-form--label">
                        {{ $t('hear_about_us') }} :
                    </p>

                    <div class="pt-select">
                        <div class="pt-select--icon">
                            <pt-icon type="pin"></pt-icon>
                        </div>
                        <v-select :options="filterOptions()"
                                  label="title"
                                  v-model="client.hear_about_us"
                                  :reduce="(option) => option.id">
                            <template #open-indicator>
                                <span class="pt-select--caret"></span>
                            </template>
                        </v-select>
                    </div>
                </div>

                <div class="pt-form--group pt-lg">
                    <p class="pt-form--label">
                        {{ $t('hear_about_us_other') }} :
                    </p>
                    <pt-input type="text" :modelValue="client.hear_about_us_other"
                              @update:modelValue="newValue => client.hear_about_us_other = newValue"
                    ></pt-input>
                </div>

                <div class="pt-form--group pt-lg">
                    <button class="pt-btn" v-on:click="sendForm">
                        Registrierung abschließen
                    </button>
                </div>

                <div class="pt-form--group pt-lg">
                    <p class="pt-form--text">
                        Ich habe bereits einen Account. <a href="/login">Login</a>
                    </p>
                </div>
            </form>
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
                location.href = '/';
            },
            filterHearAboutUs(hear_about_as) {
                let lang = this.locale;
                let el = hear_about_as.data.filter(function (value) {
                    if (value.lang == lang) {
                        return value;
                    }
                });
                return el[0].data;
            },
            filterOptions() {
                let result = []
                let lang = this.locale;
                this.data.hear_about_us.forEach(function (item){
                    if(item.is_show){
                        let tmp = {
                            id: item.id
                        }

                        item.data.forEach(function (val){
                            if(val.lang == lang){
                                tmp.title = val.data
                            }
                        })

                        result.push(tmp)
                    }
                })
                return result
            },
        }
    }
</script>

<style scoped>

</style>
