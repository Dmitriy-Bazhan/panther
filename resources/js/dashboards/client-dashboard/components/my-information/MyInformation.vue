<template>
    <div v-if="authUser">
        <div class="pt-dashboard--user-info">
            <div class="pt-dashboard--user-info--avatar">
                <img
                    v-if="authUser.entity.original_photo !== null"
                    v-bind:src="path + '/storage/' + authUser.entity.original_photo" alt="no-photo"
                >
                <img v-else :src="path + '/images/no-photo.jpg'" alt="no-photo">

                <label class="pt-dashboard--user-info--avatar-btn">
                    <input type="file"
                           ref="file"
                           v-on:change="photoUpload()"
                    >
                    <i class="fa-solid fa-pen-to-square"></i>
                </label>
<!--                <button class="pt-dashboard&#45;&#45;user-info&#45;&#45;avatar-remove" @click.prevent="deleteAvatar">-->
<!--                    <i class="fa-solid fa-trash"></i>-->
<!--                </button>-->
            </div>
            <div class="pt-dashboard--user-info--body">
                <div class="pt-dashboard--user-info--name">
                    {{authUser.first_name}} {{authUser.last_name}} ({{authUser.full_name}})
                </div>
                <p class="pt-dashboard--user-info--text">
                    {{authUser.email}}
                </p>
                <p class="pt-dashboard--user-info--text">
                    {{authUser.phone}}
                </p>
                <p class="pt-dashboard--user-info--text">
                    {{authUser.zip_code}}
                </p>
                <p class="pt-dashboard--user-info--text">
                    {{authUser.email}}
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
                              v-model="authUser.entity.description"
                              @update:modelValue="newValue => authUser.entity.description = newValue"
                    ></pt-textarea>

                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.description'] !== undefined">
                                            {{ errors['entity.description'][0] }}
                                        </span>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <button class="pt-btn--primary pt-sm pt-ml-a" v-on:click="updateInformation">{{ $t('update') }}</button>
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
                            <pt-input type="text" :modelValue="authUser.first_name"
                                      icon="user"
                                      @update:modelValue="newValue => authUser.first_name = newValue"
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
                            <pt-input type="text" :modelValue="authUser.last_name"
                                      icon="user"
                                      @update:modelValue="newValue => authUser.last_name = newValue"
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
                            <pt-input type="text" :modelValue="authUser.email"
                                      icon="email"
                                      @update:modelValue="newValue => authUser.email = newValue"
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
                            <pt-input type="text" :modelValue="authUser.phone"
                                      icon="phone"
                                      @update:modelValue="newValue => authUser.phone = newValue"
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
                            <pt-input type="text" :modelValue="authUser.zip_code"
                                      icon="pin"
                                      @update:modelValue="newValue => authUser.zip_code = newValue"
                            ></pt-input>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['zip_code'] !== undefined"
                            >
                                            {{ errors['zip_code'][0] }}
                                        </span>
                        </div>

                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('gender') }} {{authUser.entity.gender}}
                            </p>
                            <div class="pt-select">
                                <div class="pt-select--icon">
                                    <pt-icon type="users"></pt-icon>
                                </div>
                                <v-select
                                    :value="'Male'"
                                    :options="['Male', 'Female']"
                                    v-model="authUser.entity.gender"
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

                        <div class="pt-finder--form-group">
                            <button class="pt-btn--primary pt-sm pt-ml-a" v-on:click="updateInformation">{{ $t('update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script>
export default {
    name: "MyInformation",
    props: ['user', 'data'],
    data() {
        return {
            isOpen: false,
            path: location.origin,
            authUser: false,
            errors: null,
            file: '',
        }
    },
    mounted() {
        console.log(this.user);
        this.authUser = this.user
    },
    methods : {
        closePopup(id){
            this.isOpen = false
        },
        openPopup(id){
            this.isOpen = true
        },
        selectGender(option){
            this.authUser.entity.gender = option
        },
        deleteAvatar(){
            this.authUser.entity.original_photo = ''
            this.authUser.entity.thumbnail_photo = ''
        },
        updateInformation() {
            this.file = this.$refs.file.files[0];
            let formData = new FormData();

            formData.append('file', this.file);

            let user = JSON.stringify(this.authUser);
            formData.append('user', user);
            axios.post('/dashboard/client-my-information/' + this.authUser.id,
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

</style>
