<template>
    <div class="add-new-client-wrapper">
        <div class="add-new-client-content">
            <div class="pt-dashboard--user-info">
                <div class="pt-dashboard--user-info--avatar">

                    <label class="pt-dashboard--user-info--avatar-btn">
                        <input type="file"
                               ref="file"
                        >
                        <i class="fa-solid fa-pen-to-square"></i>
                    </label>
                </div>
            </div>

            <span class="register-form-error" v-if="errors !== null && errors['file'] !== undefined">{{ errors['file'][0] }}</span>

            <div class="pt-finder--form-block">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('name') }}
                    </p>
                    <pt-input type="text" :modelValue="client.first_name"
                              icon="user"
                              @update:modelValue="newValue => client.first_name = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors['first_name'] !== undefined">{{ errors['first_name'][0] }}</span>
                </div>

                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('last_name') }}
                    </p>
                    <pt-input type="text" :modelValue="client.last_name"
                              icon="user"
                              @update:modelValue="newValue => client.last_name = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors['last_name'] !== undefined">{{ errors['last_name'][0] }}</span>
                </div>

                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('email') }}
                    </p>
                    <pt-input type="text" :modelValue="client.email"
                              icon="user"
                              @update:modelValue="newValue => client.email = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors['email'] !== undefined">{{ errors['email'][0] }}</span>
                </div>

                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('phone') }}
                    </p>
                    <pt-input type="text" :modelValue="client.phone"
                              icon="user"
                              @update:modelValue="newValue => client.phone = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors['phone'] !== undefined"> {{ errors['phone'][0] }}</span>
                </div>

                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('zip_code') }}
                    </p>
                    <pt-input type="text" :modelValue="client.zip_code"
                              icon="user"
                              @update:modelValue="newValue => client.zip_code = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors['zip_code'] !== undefined">{{ errors['zip_code'][0] }}</span>
                </div>

                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('age') }}
                    </p>
                    <pt-input type="number" :modelValue="client.age" min="18" max="200"
                              icon="user"
                              @update:modelValue="newValue => client.age = newValue"
                    ></pt-input>

                    <span class="register-form-error" v-if="errors !== null && errors['age'] !== undefined"> {{ errors['age'][0] }} </span>
                </div>

                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('gender') }} {{client.gender}}
                    </p>
                    <div class="pt-select">
                        <div class="pt-select--icon">
                            <pt-icon type="help"></pt-icon>
                        </div>
                        <v-select label="title"
                                  :options="['male', 'female']"
                                  :reduce="selectGender">
                            <template #option="{ title }">
                                {{ title }}
                            </template>

                            <template #open-indicator>
                                <span class="pt-select--caret"></span>
                            </template>
                        </v-select>
                    </div>

                    <span class="register-form-error" v-if="errors !== null && errors['client.gender'] !== undefined"
                    > {{ errors['client.gender'][0] }} </span>
                </div>
            </div>

            <div class="pt-finder--form-block">
                <div class="pt-finder--form-label">
                    <div class="pt-finder--form-label--number">1</div>
                    {{ $t('description') }}
                </div>
                <div class="pt-finder--form-block--inner">
                    <div class="pt-finder--form-group">
                        <pt-textarea
                            v-model="client.description"
                            @update:modelValue="newValue => client.description = newValue"
                        ></pt-textarea>

                        <span class="register-form-error"
                              v-if="errors !== null && errors['client.description'] !== undefined">{{ errors['client.description'][0] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-2 offset-8">
                <button class="btn btn-danger btn-sm" v-on:click="closeAddNewClient()">{{ $t('close_modal') }}
                </button>
            </div>

            <div class="col-2">
                <button class="btn btn-success btn-sm" v-on:click="updateInformation">{{ $t('update') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddNewClient",
        props: ['data'],
        data() {
            return {
                errors: [],
                client: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    zip_code: '',
                    age: 18,
                    gender: 'no_matter',
                    description: '',
                }
            }
        },
        methods: {
            updateInformation() {
                this.file = this.$refs.file.files[0];
                let formData = new FormData();
                formData.append('file', this.file);
                let client = JSON.stringify(this.client);
                formData.append('client', client);

                axios.post('/dashboard/admin/add-new-client',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    })
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
                            this.emitter.emit('close-modal');
                            this.errors = null;
                        } else {
                            this.errors = response.data.errors;
                            console.log(response.data.errors);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            closeAddNewClient() {
                this.emitter.emit('close-modal');
            },
            selectGender(option) {
                this.client.gender = option
            },
        }
    }
</script>

<style scoped>
    .add-new-client-wrapper {
        position: fixed;
        top: 10%;
        left: 10%;
        width: 80%;
        height: 650px;
        border: solid 1px black;
        border-radius: 10px;
        background-color: #fff;
        padding: 25px;
    }

    .add-new-client-content {
        height: 550px;
        overflow-x: hidden;
        overflow-y: auto;
    }
</style>
