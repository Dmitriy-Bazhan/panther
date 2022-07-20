<template>
    <div v-if="authUser" class="pt-finder--form">
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
                    {{ authUser.first_name }} {{ authUser.last_name }} ({{ authUser.full_name }})
                </div>
                <p class="pt-dashboard--user-info--text">
                    {{ authUser.email }}
                </p>
                <p class="pt-dashboard--user-info--text">
                    {{ authUser.phone }}
                </p>
                <p class="pt-dashboard--user-info--text">
                    {{ authUser.zip_code }}
                </p>
                <p class="pt-dashboard--user-info--text">
                    {{ authUser.email }}
                </p>
            </div>

            <button class="pt-btn--primary" @click.prevent="openPopup()">
                <i class="fa-solid fa-pen-to-square"></i>
                {{ $t('edit') }}
            </button>
        </div>

        <span class="register-form-error" v-if="errors !== null && errors['file'] !== undefined">{{
                errors['file'][0]
            }}</span>

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
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">2</div>
                {{ $t('experience') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <pt-input type="number" :modelValue="authUser.entity.experience"
                              icon="user"
                              @update:modelValue="newValue => authUser.entity.experience = newValue"
                    ></pt-input>

                    <span class="register-form-error"
                          v-if="errors !== null && errors['entity.experience'] !== undefined">
                                            {{ errors['entity.experience'][0] }}
                                        </span>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">3</div>
                {{ $t('Zertifikate') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <div class="pt-row">
                        <div class="pt-col-md-6" v-for="(item, index) in authUser.entity.files">
                            <div class="pt-profile--file">
                                <img :src="path + '/storage/' + item.file_path" alt="pic" class="pt-profile--file-preview">
                                <div class="pt-profile--file-inner">
                                    <div class="pt-profile--file-title">
                                        {{ item.title }}
                                        <span>2020 - 2021</span>
                                    </div>
                                    <div class="pt-profile--file-ctrl">
                                        <button class="pt-btn--light pt-lg"
                                                @click="openPopup(path + '/images/fake/fake-calendar.png')">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                                            Uhrenzertifikat
                                        </button>
                                        <button class="pt-link" @click.prevent="deleteFile(item)">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="pt-upload">
                <div class="pt-row">
                    <div class="pt-col-md-4">
                        <div class="pt-drop-file">
                            <template v-if="upload.preview">
                                <img class="pt-drop-file--preview" :src="upload.preview" alt="pic">
                                <button class="pt-drop-file--remove" @click.prevent="removeUpload">
                                    <pt-icon type="cross"></pt-icon>
                                </button>
                            </template>
                            <template v-else>
                                <p class="pt-drop-file--title">
                                    Drop files here
                                </p>
                                <pt-icon type="upload"></pt-icon>
                                <p class="pt-drop-file--btn">
                                    Browse File
                                </p>
                                <input type="file" @input="dropFile">
                            </template>
                        </div>
                        <div class="pt-upload--progress">
                            <div class="pt-upload--progress-head">
                                <span>{{ upload.file.name }}</span>
                                <span>54%</span>
                            </div>
                            <div class="pt-upload--progress-body">
                                <div class="pt-upload--progress-line" style="width: 40%"></div>
                            </div>
                        </div>
                        <div class="pt-upload--ctrl">
                            <button class="pt-btn pt-sm" @click.prevent="updateFiles">upload</button>
                        </div>
                    </div>

                    <div class="pt-col-md-8">
                        <div class="pt-row">
                            <div class="pt-col-md-6">
                                <div class="pt-finder--form-group">
                                    <p class="pt-form--label">
                                        Type of document:
                                    </p>
                                    <div class="pt-select">
                                        <div class="pt-select--icon">
                                            <pt-icon type="paper"></pt-icon>
                                        </div>
                                        <v-select :options="docTypes"
                                                  label="title"
                                                  v-model="upload.type"
                                                  :reduce="(option) => option.val">
                                            <template #option="{ title }">
                                                {{ title }}
                                            </template>

                                            <template #open-indicator>
                                                <span class="pt-select--caret"></span>
                                            </template>
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-col-md-6">
                                <div class="pt-finder--form-group">
                                    <p class="pt-form--label">
                                        Date:
                                    </p>
                                    <div class="pt-select">
                                        <div class="pt-select--icon">
                                            <pt-icon type="calendar"></pt-icon>
                                        </div>
                                        <Datepicker  format="MM/dd/yyyy" v-model="upload.date" autoApply></Datepicker>
                                        <span class="pt-select--caret"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-col-md-12">
                                <div class="pt-finder--form-group">
                                    <p class="pt-form--label">
                                        Title:
                                    </p>
                                    <pt-input type="text" :modelValue="upload.title"
                                              icon="paper"
                                              @update:modelValue="newValue => upload.title = newValue"
                                    ></pt-input>
                                </div>
                            </div>
                            <div class="pt-col-md-12">
                                <div class="pt-finder--form-group">
                                    <p class="pt-form--label">
                                        Place of receipt:
                                    </p>
                                    <pt-input type="text" :modelValue="upload.place"
                                              icon="breifcase"
                                              @update:modelValue="newValue => upload.place = newValue"
                                    ></pt-input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">4</div>
                {{ $t('language_skills') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group"
                     v-for="(item, index) in authUser.entity.languages">
                    <div class="pt-row">
                        <div class="pt-col-md-6" :class="{'pt-disabled': index !== activelanguage}">
                            <p class="pt-form--label">
                                {{ $t('language_title') }}
                            </p>

                            <div class="pt-select">
                                <div class="pt-select--icon">
                                    <pt-icon type="globe"></pt-icon>
                                </div>
                                <v-select :options="data.languages"
                                          label="name"
                                          v-model="item.lang_id"
                                          :reduce="(option) => option.id">
                                    <template #option="{ name }">
                                        {{ name }}
                                    </template>

                                    <template #open-indicator>
                                        <span class="pt-select--caret"></span>
                                    </template>
                                </v-select>
                            </div>
                        </div>
                        <div class="pt-col-md-5">
                            <p class="pt-form--label">
                                {{ $t('language_level_title') }}
                            </p>

                            <div class="pt-select">
                                <div class="pt-select--icon">
                                    <pt-icon type="globe"></pt-icon>
                                </div>
                                <v-select :options="languageLevelOptions"
                                          label="title"
                                          v-model="item.level"
                                          :reduce="(option) => option.val">
                                    <template #option="{ title }">
                                        {{ title }}
                                    </template>

                                    <template #open-indicator>
                                        <span class="pt-select--caret"></span>
                                    </template>
                                </v-select>
                            </div>
                        </div>

                        <div class="pt-col-md-1">
                            <button class="pt-btn--icon pt-m-a pt-mt-35" @click.prevent="removeLang(item, index)">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-finder--form-group" v-show="languageOptions.length > authUser.entity.languages.length">
                    <div class="pt-row">
                        <div class="pt-col-md-12">
                            <button class="pt-btn--light pt-md" @click.prevent="addLanguage">
                                <i class="fa-solid fa-plus"></i>
                                {{ $t('add_language') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">5</div>
                Geschlechtspräferenz
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-row">
                    <div class="pt-col-md-3">
                        <div class="pt-finder--form-group">
                            <label class="pt-box">
                                <input type="radio" name="preference_for_the_nurse" value="male"
                                       v-model="authUser.entity.pref_client_gender">
                                <span class="pt-box--body"></span>
                                <span class="pt-box--label">{{ $t('male') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="pt-col-md-3">
                        <div class="pt-finder--form-group">
                            <label class="pt-box">
                                <input type="radio" name="preference_for_the_nurse" value="female"
                                       v-model="authUser.entity.pref_client_gender">
                                <span class="pt-box--body"></span>
                                <span class="pt-box--label">{{ $t('female') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="pt-col-md-3">
                        <div class="pt-finder--form-group">
                            <label class="pt-box">
                                <input type="radio" name="preference_for_the_nurse" value="no_matter"
                                       v-model="authUser.entity.pref_client_gender">
                                <span class="pt-box--body"></span>
                                <span class="pt-box--label">{{ $t('no_matter') }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">6</div>
                Pflegegrad
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <div class="pt-finder--form-grad">
                        <div class="pt-finder--form-grad--item" v-for="n in 5">
                            <div class="pt-finder--form-grad--item-level"></div>
                            <div class="pt-finder--form-grad--item-val">{{ n }}</div>
                            <label class="pt-box">
                                <input type="radio" name="available_care_range" :value="n"
                                       v-model="authUser.entity.available_care_range">
                                <span class="pt-box--body"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">7</div>
                {{ $t('additional_info') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-select">
                    <div class="pt-select--icon">
                        <pt-icon type="help"></pt-icon>
                    </div>
                    <v-select multiple :options="additionalOptions(data.additional_info)"
                              label="alias"
                              v-model="authUser.entity.additional_info">
                        <template #option="{ data }">
                            {{ data.data }}
                        </template>

                        <template #open-indicator>
                            <span class="pt-select--caret"></span>
                        </template>
                    </v-select>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">8</div>
                {{ $t('multiple_bookings') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-select">
                    <div class="pt-select--icon">
                        <pt-icon type="help"></pt-icon>
                    </div>
                    <v-select :options="['yes', 'no']"
                              v-model="authUser.entity.multiple_bookings">


                        <template #open-indicator>
                            <span class="pt-select--caret"></span>
                        </template>
                    </v-select>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">9</div>
                {{ $t('type_of_learning') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-select">
                    <div class="pt-select--icon">
                        <pt-icon type="help"></pt-icon>
                    </div>
                    <v-select :options="data.type_of_learning"
                              label="title"
                              v-model="authUser.entity.type_of_learning"
                              :reduce="(option) => option">
                        <template #option="{ data }">
                            {{ data.data }}
                        </template>

                        <template #open-indicator>
                            <span class="pt-select--caret"></span>
                        </template>
                    </v-select>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">10</div>
                {{ $t('provide_supports') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-select">
                    <div class="pt-select--icon">
                        <pt-icon type="help"></pt-icon>
                    </div>
                    <v-select multiple :options="translateOptions(data.provider_supports)"
                              label="title"
                              v-model="authUser.entity.provide_supports"
                              :reduce="(option) => option">

                        <template #open-indicator>
                            <span class="pt-select--caret"></span>
                        </template>
                    </v-select>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">11</div>
                {{ $t('time_calendar') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('one_or_regular') }}
                    </p>

                    <div class="pt-select">
                        <div class="pt-select--icon">
                            <pt-icon type="help"></pt-icon>
                        </div>

                        <v-select :options="translateOptions(oneOrRegularOptions)"
                                  label="title"
                                  :reduce="(option) => option.val"
                                  v-model="authUser.entity.one_or_regular">
                            <template #open-indicator>
                                <span class="pt-select--caret"></span>
                            </template>
                        </v-select>
                    </div>
                </div>
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('ready_to_work') }}
                    </p>

                    <div class="pt-select">
                        <div class="pt-select--icon">
                            <pt-icon type="help"></pt-icon>
                        </div>

                        <v-select :options="translateOptions(readyToWorkOptions)"
                                  label="title"
                                  :reduce="(option) => option.val"
                                  v-model="authUser.entity.ready_to_work">
                            <template #open-indicator>
                                <span class="pt-select--caret"></span>
                            </template>
                        </v-select>
                    </div>
                </div>
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('start_date_ready_to_work') }}
                    </p>

                    <div class="pt-select">
                        <div class="pt-select--icon">
                            <pt-icon type="calendar"></pt-icon>
                        </div>
                        <Datepicker format="MM/dd/yyyy" v-model="authUser.entity.start_date_ready_to_work"
                                    autoApply></Datepicker>
                        <span class="pt-select--caret"></span>
                    </div>
                </div>

                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('weekdays') }}
                    </p>
                    <div class="">
                        <template v-for="item in time_intervals">
                            <label class="pt-checkbox" v-if="item.type === 'weekdays'">
                                <input type="checkbox"
                                       true-value="1" false-value="0"
                                       v-model="authUser.entity.work_time_pref[item.id]">
                                <span class="pt-checkbox--body">{{ item.interval }} Uhr</span>
                            </label>
                        </template>
                    </div>
                </div>
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('weekends') }}
                    </p>

                    <div class="">
                        <template v-for="item in time_intervals">
                            <label class="pt-checkbox" v-if="item.type === 'weekends'">
                                <input type="checkbox"
                                       true-value="1" false-value="0"
                                       v-model="authUser.entity.work_time_pref[item.id]">
                                <span class="pt-checkbox--body">{{ item.interval }} Uhr</span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <span class="register-form-error" v-if="errors !== null">{{
                errors
            }}</span>

        <div class="row">
            <div class="col-2 offset-10">
                <button class="btn btn-success btn-sm" v-on:click="updateInformation">{{ $t('update') }}</button>
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
                                {{ $t('gender') }}
                            </p>
                            <div class="pt-select">
                                <div class="pt-select--icon">
                                    <pt-icon type="users"></pt-icon>
                                </div>
                                <v-select label="title"
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
                    </div>


                    <button @click.prevent="closePopup" class="pt-btn--primary pt-sm pt-m-a pt-mt-25">
                        edit
                    </button>
                </div>
            </div>
        </Modal>
    </div>


</template>

<script>
    import NurseInfo from "./NurseInfo";
    import NurseFilesAndPhoto from "./NurseFilesAndPhoto";
    import NurseTimeCalendar from "./NurseTimeCalendar";

    export default {
        name: "MyInformation",
        components: {
            nurse_info: NurseInfo,
            nurse_files_and_photo: NurseFilesAndPhoto,
            nurse_time_calendar: NurseTimeCalendar,
        },
        props: ['user', 'data'],
        data() {
            return {
                time_intervals: [],
                readyToWorkOptions: [
                    {
                        val: 'yes',
                        name: 'yes',
                    },
                    {
                        val: 'no',
                        name: 'no',
                    },
                ],
                oneOrRegularOptions: [
                    {
                        val: 'one',
                        name: 'one',
                    },
                    {
                        val: 'regular',
                        name: 'regular',
                    },
                    {
                        val: 'no_matter',
                        name: 'no_matter',
                    },
                ],
                docTypes: [
                    {
                        title: 'Criminal record',
                        val: 'criminal_record',
                    },
                    {
                        title: 'Documentation of training',
                        val: 'documentation_of_training',
                    },
                    {
                        title: 'CPR course',
                        val: 'CPR_course',
                    },
                    {
                        title: 'References',
                        val: 'references',
                    },
                    {
                        title: 'Certificate file',
                        val: 'certificate_file',
                    },
                ],
                upload: {
                    file: false,
                    preview: false,
                    title: '',
                    date: '',
                    place: '',
                    type: '',
                },
                isOpen: false,
                authUser: false,
                info_active: true,
                file_active: false,
                calendar_active: false,
                path: location.origin,
                errors: null,
                languageOptions: [
                    {
                        id: 1,
                        title: 'english',
                    },
                    {
                        id: 2,
                        title: 'german',
                    },
                ],
                languageLevelOptions: [
                    {
                        val: 'A1',
                        title: 'A1',
                    },
                    {
                        val: 'A2',
                        title: 'A2',
                    },
                    {
                        val: 'B1',
                        title: 'B1',
                    },
                    {
                        val: 'B2',
                        title: 'B2',
                    },
                    {
                        val: 'C1',
                        title: 'C1',
                    },
                    {
                        val: 'C2',
                        title: 'C2',
                    },
                    {
                        val: 'no_matter',
                        title: 'no_matter',
                    },
                ],
                activelanguage: 0,
            }
        },
        mounted() {
            let self = this
            this.time_intervals = this.data['time_intervals'];

            self.data.provider_supports.forEach(function (item) {
                item.title = item.title = self.$t(item.name)
            })

            self.data.type_of_learning.forEach(function (item) {
                item.title = item.data.data
            })

            this.getNurse();
            this.emitter.on('errors', e => {
                this.errors = e;
            });

            this.emitter.on('no-errors', e => {
                this.errors = null;
            });
        },
        methods: {
            deleteFile(item) {
                axios.post('/dashboard/nurse-my-information/remove-file/' + this.user.id,
                    {
                        file_id: item.id
                    })
                    .then((response) => {
                        if (response.data.success) {
                            console.log(response.data);
                        } else {
                            this.errors = response.data.errors;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            photoUpload() {

            },
            updateInformation() {
                this.file = this.$refs.file.files[0];
                let formData = new FormData();

                formData.append('file', this.file);

                let user = JSON.stringify(this.authUser);
                formData.append('user', user);
                axios.post('/dashboard/nurse-my-information/' + this.authUser.id,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    })
                    .then((response) => {
                        console.log(response.data.success);
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
            translateOptions(options) {
                let self = this
                options.forEach(function (item) {
                    item.title = self.$t(item.name)
                })
                return options
            },
            additionalOptions(options) {
                let self = this
                options.forEach(function (item) {
                    item.title = item.data.data
                })
                return options
            },
            dropFile(e) {
                let self = this
                let reader = new FileReader();

                self.upload.file = e.target.files[0]

                reader.readAsDataURL(self.upload.file);

                reader.onload = function () {
                    self.upload.preview = reader.result
                };
            },
            removeUpload(id) {
                let self = this
                self.upload.file = false
                self.upload.preview = ''
            },
            updateFiles() {
                let self = this

                let info = {
                    title: self.upload.title,
                    date: self.upload.date,
                    place: self.upload.place,
                    type: self.upload.type,
                }

                let formData = new FormData();
                formData.append('file', self.upload.file);
                formData.append('info', JSON.stringify(info));

                axios.post('/dashboard/nurse-my-information/update-file/ ' + this.user.id,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    })
                    .then((response) => {
                        if (response.data.success) {
                            console.log(response.data);
                            this.emitter.emit('response-success-true');
                            this.errors = null;
                            this.emitter.emit('photo-exist');
                        } else {
                            this.errors = response.data.errors;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            closePopup(id) {
                this.isOpen = false
            },
            openPopup(id) {
                this.isOpen = true
            },
            getNurse() {
                let self = this
                axios.get('/dashboard/nurse/' + this.user.id)
                    .then((response) => {
                        if (response.data.success) {
                            this.authUser = response.data.user;
                            self.authUser.entity.provide_supports.forEach(function (item) {
                                item.title = item.title = self.$t(item.name)
                            })

                            self.data.type_of_learning.forEach(function (item) {
                                if(item.id === self.authUser.entity.type_of_learning.id){
                                    self.authUser.entity.type_of_learning = item
                                }
                            })

                            console.log(this.authUser)
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            showInfo() {
                this.info_active = true;
                this.file_active = false;
                this.calendar_active = false;
            },
            showFilesAndPhoto() {
                this.info_active = false;
                this.file_active = true;
                this.calendar_active = false;
            },
            showCalendar() {
                this.calendar_active = true;
                this.info_active = false;
                this.file_active = false;
            },
            addLanguage() {
                if (
                    this.authUser.entity.languages &&
                    this.authUser.entity.languages.length === 0 ||
                    (this.authUser.entity.languages[this.authUser.entity.languages.length - 1].id &&
                        this.authUser.entity.languages[this.authUser.entity.languages.length - 1].level) &&
                    this.authUser.entity.languages.length < this.languageOptions.length
                ) {
                    this.authUser.entity.languages.push(
                        {
                            id: '',
                            level: '',
                        }
                    )
                    this.activelanguage = this.authUser.entity.languages.length - 1
                }

                if (!this.authUser.entity.languages) {
                    this.authUser.entity.languages = [
                        {
                            id: '',
                            level: '',
                        }
                    ]
                    this.activelanguage = this.authUser.entity.languages.length - 1
                }
            },
        }
    }

</script>

<style scoped>

</style>
