<template>
    <div class="show-chats-wrapper">
        <div class="chat-wrapper">
        <div class="pt-dashboard--client-info">
            <div class="pt-dashboard--client-info--avatar">
                <img
                    v-if="client.entity.original_photo !== null"
                    v-bind:src="path + '/storage/' + client.entity.original_photo" alt="no-photo"
                >
                <img v-else :src="path + '/images/no-photo.jpg'" alt="no-photo">

                <label class="pt-dashboard--client-info--avatar-btn">
                    <input type="file"
                           ref="file"
                           v-on:change="photoUpload()"
                    >
                    <i class="fa-solid fa-pen-to-square"></i>
                </label>
                <!--                <button class="pt-dashboard&#45;&#45;client-info&#45;&#45;avatar-remove" @click.prevent="deleteAvatar">-->
                <!--                    <i class="fa-solid fa-trash"></i>-->
                <!--                </button>-->
            </div>
            <div class="pt-dashboard--client-info--body">
                <div class="pt-dashboard--client-info--name">
                    {{client.first_name}} {{client.last_name}} ({{client.full_name}})
                </div>
                <p class="pt-dashboard--client-info--text">
                    {{client.email}}
                </p>
                <p class="pt-dashboard--client-info--text">
                    {{client.phone}}
                </p>
                <p class="pt-dashboard--client-info--text">
                    {{client.zip_code}}
                </p>
                <p class="pt-dashboard--client-info--text">
                    {{client.email}}
                </p>
            </div>

            <button class="pt-btn--primary" @click.prevent="openPopup()">
                <i class="fa-solid fa-pen-to-square"></i>
                {{ $t('edit') }}
            </button>
        </div>

        <span class="register-form-error" v-if="errors !== null && errors['file'] !== undefined">{{ errors['file'][0] }}</span>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">1</div>
                {{ $t('description') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <pt-textarea
                        v-model="client.entity.description"
                        @update:modelValue="newValue => client.entity.description = newValue"
                    ></pt-textarea>

                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.description'] !== undefined">
                                            {{ errors['entity.description'][0] }}
                                        </span>
                </div>
            </div>
        </div>



        <Modal
            v-model="isOpen"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">
                    <h3 class="pt-title">
                        Edit
                    </h3>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('name') }}
                            </p>
                            <pt-input type="text" :modelValue="client.first_name"
                                      icon="client"
                                      @update:modelValue="newValue => client.first_name = newValue"
                            ></pt-input>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['first_name'] !== undefined"
                            >
                                            {{ errors['first_name'][0] }}
                                        </span>
                        </div>

                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('last_name') }}
                            </p>
                            <pt-input type="text" :modelValue="client.last_name"
                                      icon="client"
                                      @update:modelValue="newValue => client.last_name = newValue"
                            ></pt-input>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['last_name'] !== undefined"
                            >
                                            {{ errors['last_name'][0] }}
                                        </span>
                        </div>

                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('email') }}
                            </p>
                            <pt-input type="text" :modelValue="client.email"
                                      icon="client"
                                      @update:modelValue="newValue => client.email = newValue"
                            ></pt-input>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['email'] !== undefined"
                            >
                                            {{ errors['email'][0] }}
                                        </span>
                        </div>

                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('phone') }}
                            </p>
                            <pt-input type="text" :modelValue="client.phone"
                                      icon="client"
                                      @update:modelValue="newValue => client.phone = newValue"
                            ></pt-input>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['phone'] !== undefined"
                            >
                                            {{ errors['phone'][0] }}
                                        </span>
                        </div>

                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('zip_code') }}
                            </p>
                            <pt-input type="text" :modelValue="client.zip_code"
                                      icon="client"
                                      @update:modelValue="newValue => client.zip_code = newValue"
                            ></pt-input>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['zip_code'] !== undefined"
                            >
                                            {{ errors['zip_code'][0] }}
                                        </span>
                        </div>



                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('gender') }} {{client.entity.gender}}
                            </p>
                            <div class="pt-select">
                                <div class="pt-select--icon">
                                    <pt-icon type="clients"></pt-icon>
                                </div>
                                <v-select
                                    :value="'Male'"
                                    :options="['Male', 'Female']"
                                    @option:selecting="selectGender($event)"
                                >

                                    <template #open-indicator>
                                        <span class="pt-select--caret"></span>
                                    </template>
                                </v-select>
                            </div>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['entity.gender'] !== undefined"
                            >
                                            {{ errors['entity.gender'][0] }}
                                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
        </div>
        <br>
        <div class="row">
            <div class="col-2 offset-8">
                <button class="btn btn-sm btn-danger" v-on:click="closeWindow()">{{ $t('close') }}</button>

            </div>
            <div class="col-2">
                    <button class="pt-btn--primary pt-sm pt-ml-a" v-on:click="updateInformation">{{ $t('update') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ClientInfo",
        props: ['client', 'data'],
        data() {
            return {
                isOpen: false,
                path: location.origin,
                errors: null,
                file: '',
            }
        },
        mounted() {
            console.log(this.client);
        },
        methods : {
            closeWindow() {
                this.emitter.emit('close-modal');
            },
            closePopup(id){
                this.isOpen = false
            },
            openPopup(id){
                this.isOpen = true
            },
            selectGender(option){
                console.log(option)
                this.client.entity.gender = option
            },
            deleteAvatar(){
                this.client.entity.original_photo = ''
                this.client.entity.thumbnail_photo = ''
            },
            updateInformation() {
                this.file = this.$refs.file.files[0];
                let formData = new FormData();

                formData.append('file', this.file);

                let client = JSON.stringify(this.client);
                formData.append('user', client);
                axios.post('/dashboard/client-my-information/' + this.client.id,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    })
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
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
            photoUpload() {
                //todo:: photo preview
            },
        }
    }
</script>

<style scoped>
    .show-chats-wrapper {
        position: fixed;
        top: 10%;
        left: 10%;
        width: 80%;
        height: 600px;
        border: solid 1px black;
        border-radius: 10px;
        background-color: #0a58ca;
        padding: 15px;
    }
    .chat-wrapper {
        height: 500px;
        overflow: auto;
    }
</style>
