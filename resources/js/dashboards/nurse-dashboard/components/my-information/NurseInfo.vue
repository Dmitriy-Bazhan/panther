<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">

                <!-- first name -->
                <div class="row">
                    <div class="col-4">
                        <label for="first_name" class="form-label col-form-label-sm">{{ $t('name') }}</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" v-model="user.first_name"
                               id="first_name">
                    </div>
                    <span class="register-form-error" v-if="errors !== null && errors['first_name'] !== undefined">{{ errors['first_name'][0] }}</span>
                </div>

                <!-- last name -->
                <div class="row">
                    <div class="col-4">
                        <label for="last_name" class="form-label col-form-label-sm">{{ $t('last_name') }}</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" v-model="user.last_name"
                               id="last_name">
                    </div>
                    <span class="register-form-error" v-if="errors !== null && errors['last_name'] !== undefined">{{ errors['last_name'][0] }}</span>
                </div>

                <!-- email -->
                <div class="row">
                    <div class="col-4">
                        <label for="email" class="form-label col-form-label-sm">{{ $t('email') }}</label>
                    </div>

                    <div class="col-8">
                        <input type="email" class="form-control form-control-sm" v-model="user.email" id="email">
                    </div>
                    <span class="register-form-error" v-if="errors !== null && errors['email'] !== undefined">{{ errors['email'][0] }}</span>
                </div>

                <!-- phone -->
                <div class="row">
                    <div class="col-4">
                        <label for="phone" class="form-label col-form-label-sm">{{ $t('phone') }}</label>
                    </div>

                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" v-model="user.phone" id="phone">
                    </div>
                    <span class="register-form-error" v-if="errors !== null && errors['phone'] !== undefined">{{ errors['phone'][0] }}</span>
                </div>

                <!-- zip code -->
                <div class="row">
                    <div class="col-4">
                        <label for="zip_code" class="form-label col-form-label-sm">{{ $t('zip_code') }}</label>
                    </div>

                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" v-model="user.zip_code"
                               id="zip_code">
                    </div>
                    <span class="register-form-error" v-if="errors !== null && errors['zip_code'] !== undefined">{{ errors['zip_code'][0] }}</span>
                </div>

                <!-- gender -->
                <div class="row">
                    <div class="col-4">
                        <label for="gender" class="form-label col-form-label-sm">{{ $t('gender') }}</label>
                    </div>

                    <div class="col-8">
                        <select class="form-control form-control-sm" v-model="user.entity.gender" id="gender">
                            <option value="male">{{ $t('male') }}</option>
                            <option value="female">{{ $t('female') }}</option>
                        </select>
                    </div>
                    <span class="register-form-error" v-if="errors !== null && errors['entity.gender'] !== undefined">{{ errors['entity.gender'][0] }}</span>
                </div>

                <!-- age -->
                <div class="row">
                    <div class="col-4">
                        <label for="age" class="form-label col-form-label-sm">{{ $t('age') }}</label>
                    </div>

                    <div class="col-8">
                        <input type="number" class="form-control form-control-sm" v-model="user.entity.age" id="age"
                               min="18" max="100">
                    </div>
                    <span class="register-form-error" v-if="errors !== null && errors['entity.age'] !== undefined">{{ errors['entity.age'][0] }}</span>
                </div>

                <!-- experience -->
                <div class="row">
                    <div class="col-4">
                        <label for="experience" class="form-label col-form-label-sm">{{ $t('experience') }}</label>
                    </div>

                    <div class="col-8">
                        <input type="number" class="form-control form-control-sm" v-model="user.entity.experience"
                               id="experience" min="0" max="100">
                    </div>
                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.experience'] !== undefined">{{ errors['entity.experience'][0] }}</span>
                </div>

                <!-- languages -->
                <div class="row">
                    <div class="col-4">
                        <label for="languages" class="form-label col-form-label-sm">{{ $t('languages') }}</label>
                    </div>

                    <div class="col-6">
                        <select v-if="user.entity.languages.length > 0" class="form-control form-control-sm"
                                v-model="user.entity.languages[0].lang" id="languages">
                            <option value="English">{{ $t('english') }}</option>
                            <option value="Deutsche">{{ $t('german') }}</option>
                        </select>
                    </div>

                    <div class="col-2">
                        <select v-if="user.entity.languages.length > 0" class="form-control form-control-sm"
                                v-model="user.entity.languages[0].level" id="">
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
                            <option value="C1">C1</option>
                            <option value="C2">C2</option>
                        </select>
                    </div>
                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.languages.0.lang'] !== undefined">{{ errors['entity.languages.0.lang'][0] }}</span>
                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.languages.0.level'] !== undefined">{{ errors['entity.languages.0.level'][0] }}</span>
                </div>
            </div>

            <div class="col-4">
                <!-- pref client gender -->
                <div class="row">
                    <div class="col-4">
                        <label for="pref_client_gender" class="form-label col-form-label-sm">
                            {{ $t('preference_client_gender') }}
                        </label>
                    </div>

                    <div class="col-8">
                        <select class="form-control form-control-sm" v-model="user.entity.pref_client_gender"
                                id="pref_client_gender">
                            <option value="no_matter">{{ $t('no_matter') }}</option>
                            <option value="male">{{ $t('male') }}</option>
                            <option value="female">{{ $t('female') }}</option>
                        </select>
                    </div>
                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.pref_client_gender'] !== undefined">{{ errors['entity.pref_client_gender'][0] }}</span>
                </div>

                <!-- available care range -->
                <div class="row">
                    <div class="col-4">
                        <label for="available_care_range" class="form-label col-form-label-sm">
                            {{ $t('available_care_range') }}
                        </label>
                    </div>

                    <div class="col-8">
                        <select class="form-control form-control-sm" v-model="user.entity.available_care_range"
                                id="available_care_range">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="0">{{ $t('not_sure') }}</option>
                        </select>
                    </div>
                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.available_care_range'] !== undefined">{{ errors['entity.available_care_range'][0] }}</span>
                </div>

                <!-- multiple bookings -->
                <div class="row">
                    <div class="col-4">
                        <label for="multiple_bookings" class="form-label col-form-label-sm">
                            {{ $t('multiple_bookings') }}
                        </label>
                    </div>

                    <div class="col-8">
                        <select class="form-control form-control-sm" v-model="user.entity.multiple_bookings"
                                id="multiple_bookings">
                            <option value="yes">{{ $t('yes') }}</option>
                            <option value="no">{{ $t('no') }}</option>
                        </select>
                    </div>
                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.multiple_bookings'] !== undefined">{{ errors['entity.multiple_bookings'][0] }}</span>
                </div>

                <!-- provide supports -->
                <div class="row">
                    <div class="col-4">
                        <label for="provide_supports" class="form-label col-form-label-sm">{{ $t('provide_supports')
                            }}</label>
                    </div>

                    <div class="col-8">
                        <select class="form-control form-control-sm" v-model="user.entity.provide_supports"
                                id="provide_supports" multiple>
                            <option v-for="support in data.provider_supports"
                                    :value="support">
                                {{ $t(support.name) }}
                            </option>
                        </select>
                    </div>
                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.provide_supports'] !== undefined">{{ errors['entity.provide_supports'][0] }}</span>

                </div>
                <br>
                <!--                additional info-->
                <div class="row">
                    <div class="col-4">
                        <label for="additional_info" class="form-label col-form-label-sm">{{ $t('additional_info')
                            }}</label>
                    </div>

                    <div class="col-8">

                        <select class="form-control form-control-sm" v-model="user.entity.additional_info"
                                id="additional_info" multiple>
                            <option v-for="(info_item, index) in data.additional_info"
                                    :value="info_item">
                                {{ data.additional_info_data[index].data }}
                            </option>
                        </select>

                    </div>

                </div>

            </div>

            <div class="col-5">

                <!-- description -->
                <div class="row">
                    <div class="col-2">
                        <label for="description" class="form-label col-form-label-sm">{{ $t('description') }}</label>
                    </div>

                    <div class="col-10">
                            <textarea class="form-control form-control-sm" v-model="user.entity.description"
                                      id="description" rows="5">

                            </textarea>
                        <span class="register-form-error"
                              v-if="errors !== null && errors['entity.description'] !== undefined">{{ errors['entity.description'][0] }}</span>
                    </div>
                </div>
                <br>

            </div>

        </div>

        <div class="row">
            <div class="col-2 offset-10">
                <button class="btn btn-success btn-sm" v-on:click="updateInformation">{{ $t('update') }}</button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "NurseInfo",
        props: ['user', 'data', 'errors'],
        data() {
            return {}
        },
        mounted() {
            this.emitter.on('update-information', e => {
                this.updateInformation();
            });
            console.log(this.data);
            console.log(this.user);
        },
        watch: {
            user: {
                handler(newValue, oldValue) {
                    if (this.user.entity.languages.length === 0) {
                        this.user.entity.languages = [];
                        let lang = new Object({
                            lang: '',
                            level: ''
                        });
                        this.user.entity.languages.push(lang);
                    }
                },
                immediate: true
            },
        },
        methods: {
            updateInformation() {
                axios.put('/dashboard/nurse-my-information/' + this.user.id, {'user': this.user})
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
                            this.emitter.emit('no-errors', response.data.errors);
                            this.emitter.emit('user-finished-fill-info');
                        } else {
                            this.emitter.emit('errors', response.data.errors);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
        }
    }
</script>

<style scoped>

</style>
