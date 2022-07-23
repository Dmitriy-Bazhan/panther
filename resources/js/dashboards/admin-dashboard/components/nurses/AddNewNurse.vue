<template>
    <div class="add-new-nurse-wrapper">
        <div class="add-new-nurse-content">
            <div v-if="nurse" class="pt-finder--form">
                <div class="pt-dashboard--user-info">
                    <div class="pt-finder--form-block">
                        <div class="pt-dashboard--user-info--avatar">
                            <h2>Photo</h2>
                            <label class="pt-dashboard--user-info--avatar-btn">
                                <input type="file"
                                       ref="file"
                                >
                                <i class="fa-solid fa-pen-to-square"></i>
                            </label>
                        </div>

                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('name') }}
                            </p>
                            <pt-input type="text" :modelValue="nurse.first_name"
                                      icon="user"
                                      @update:modelValue="newValue => nurse.first_name = newValue"
                            ></pt-input>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['first_name'] !== undefined"
                            >{{ errors['first_name'][0] }}</span>
                        </div>

                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('last_name') }}
                            </p>
                            <pt-input type="text" :modelValue="nurse.last_name"
                                      icon="user"
                                      @update:modelValue="newValue => nurse.last_name = newValue"
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
                            <pt-input type="text" :modelValue="nurse.email"
                                      icon="email"
                                      @update:modelValue="newValue => nurse.email = newValue"
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
                            <pt-input type="text" :modelValue="nurse.phone"
                                      icon="phone"
                                      @update:modelValue="newValue => nurse.phone = newValue"
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
                            <pt-input type="text" :modelValue="nurse.zip_code"
                                      icon="pin"
                                      @update:modelValue="newValue => nurse.zip_code = newValue"
                            ></pt-input>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['zip_code'] !== undefined"
                            >
                                            {{ errors['zip_code'][0] }}
                                        </span>
                        </div>

                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{ $t('age') }}
                            </p>
                            <pt-input type="number" :modelValue="nurse.age" min="18" max="200"
                                      icon="user"
                                      @update:modelValue="newValue => nurse.age = newValue"
                            ></pt-input>

                            <span class="register-form-error" v-if="errors !== null && errors['age'] !== undefined"> {{ errors['age'][0] }} </span>
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
                                          v-model="nurse.gender"
                                >

                                    <template #open-indicator>
                                        <span class="pt-select--caret"></span>
                                    </template>
                                </v-select>
                            </div>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['nurse.gender'] !== undefined"
                            >
                                            {{ errors['nurse.gender'][0] }}
                                        </span>
                        </div>
                    </div>


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
                                v-model="nurse.description"
                                @update:modelValue="newValue => nurse.description = newValue"
                            ></pt-textarea>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['description'] !== undefined">
                                            {{ errors['description'][0] }}
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
                            <pt-input type="number" :modelValue="nurse.experience"
                                      icon="user"
                                      @update:modelValue="newValue => nurse.experience = newValue"
                            ></pt-input>

                            <span class="register-form-error"
                                  v-if="errors !== null && errors['experience'] !== undefined">
                                            {{ errors['experience'][0] }}
                                        </span>
                        </div>
                    </div>
                </div>

                <div class="pt-finder--form-block">
                    <div class="pt-finder--form-label">
                        <div class="pt-finder--form-label--number">3</div>
                        {{ $t('Zertifikate') }}
                    </div>
                    <!--                <div class="pt-finder&#45;&#45;form-block&#45;&#45;inner">-->
                    <!--                    <div class="pt-finder&#45;&#45;form-group">-->
                    <!--                        <div class="pt-row">-->
                    <!--                            <div class="pt-col-md-6" v-for="(item, index) in authUser.nurse.files">-->
                    <!--                                <div class="pt-profile&#45;&#45;file">-->
                    <!--                                    <img :src="path + '/storage/' + item.file_path" alt="pic"-->
                    <!--                                         class="pt-profile&#45;&#45;file-preview">-->
                    <!--                                    <div class="pt-profile&#45;&#45;file-inner">-->
                    <!--                                        <div class="pt-profile&#45;&#45;file-title">-->
                    <!--                                            {{ item.title }}-->
                    <!--                                            <span>2020 - 2021</span>-->
                    <!--                                        </div>-->
                    <!--                                        <div class="pt-profile&#45;&#45;file-ctrl">-->
                    <!--                                            <button class="pt-btn&#45;&#45;light pt-lg"-->
                    <!--                                                    @click="openPopup(path + '/images/fake/fake-calendar.png')">-->
                    <!--                                                <i class="fa-solid fa-magnifying-glass-plus"></i>-->
                    <!--                                                Uhrenzertifikat-->
                    <!--                                            </button>-->
                    <!--                                            <button class="pt-link" @click.prevent="deleteFile(item)">Delete</button>-->
                    <!--                                        </div>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                </div>-->


                    <!--                <div class="pt-upload">-->
                    <!--                    <div class="pt-row">-->
                    <!--                        <div class="pt-col-md-4">-->
                    <!--                            <div class="pt-drop-file">-->
                    <!--                                <template v-if="upload.preview">-->
                    <!--                                    <img class="pt-drop-file&#45;&#45;preview" :src="upload.preview" alt="pic">-->
                    <!--                                    <button class="pt-drop-file&#45;&#45;remove" @click.prevent="removeUpload">-->
                    <!--                                        <pt-icon type="cross"></pt-icon>-->
                    <!--                                    </button>-->
                    <!--                                </template>-->
                    <!--                                <template v-else>-->
                    <!--                                    <p class="pt-drop-file&#45;&#45;title">-->
                    <!--                                        Drop files here-->
                    <!--                                    </p>-->
                    <!--                                    <pt-icon type="upload"></pt-icon>-->
                    <!--                                    <p class="pt-drop-file&#45;&#45;btn">-->
                    <!--                                        Browse File-->
                    <!--                                    </p>-->
                    <!--                                    <input type="file" @input="dropFile">-->
                    <!--                                </template>-->
                    <!--                            </div>-->
                    <!--                            <div class="pt-upload&#45;&#45;progress">-->
                    <!--                                <div class="pt-upload&#45;&#45;progress-head">-->
                    <!--                                    <span>{{ upload.file.name }}</span>-->
                    <!--                                    <span>54%</span>-->
                    <!--                                </div>-->
                    <!--                                <div class="pt-upload&#45;&#45;progress-body">-->
                    <!--                                    <div class="pt-upload&#45;&#45;progress-line" style="width: 40%"></div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                            <div class="pt-upload&#45;&#45;ctrl">-->
                    <!--                                <button class="pt-btn pt-sm" @click.prevent="updateFiles">upload</button>-->
                    <!--                            </div>-->
                    <!--                        </div>-->

                    <!--                        <div class="pt-col-md-8">-->
                    <!--                            <div class="pt-row">-->
                    <!--                                <div class="pt-col-md-6">-->
                    <!--                                    <div class="pt-finder&#45;&#45;form-group">-->
                    <!--                                        <p class="pt-form&#45;&#45;label">-->
                    <!--                                            Type of document:-->
                    <!--                                        </p>-->
                    <!--                                        <div class="pt-select">-->
                    <!--                                            <div class="pt-select&#45;&#45;icon">-->
                    <!--                                                <pt-icon type="paper"></pt-icon>-->
                    <!--                                            </div>-->
                    <!--                                            <v-select :options="docTypes"-->
                    <!--                                                      label="title"-->
                    <!--                                                      v-model="upload.type"-->
                    <!--                                                      :reduce="(option) => option.val">-->
                    <!--                                                <template #option="{ title }">-->
                    <!--                                                    {{ title }}-->
                    <!--                                                </template>-->

                    <!--                                                <template #open-indicator>-->
                    <!--                                                    <span class="pt-select&#45;&#45;caret"></span>-->
                    <!--                                                </template>-->
                    <!--                                            </v-select>-->
                    <!--                                        </div>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                                <div class="pt-col-md-6">-->
                    <!--                                    <div class="pt-finder&#45;&#45;form-group">-->
                    <!--                                        <p class="pt-form&#45;&#45;label">-->
                    <!--                                            Date:-->
                    <!--                                        </p>-->
                    <!--                                        <div class="pt-select">-->
                    <!--                                            <div class="pt-select&#45;&#45;icon">-->
                    <!--                                                <pt-icon type="calendar"></pt-icon>-->
                    <!--                                            </div>-->
                    <!--                                            <Datepicker format="MM/dd/yyyy" v-model="upload.date"-->
                    <!--                                                        autoApply></Datepicker>-->
                    <!--                                            <span class="pt-select&#45;&#45;caret"></span>-->
                    <!--                                        </div>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                                <div class="pt-col-md-12">-->
                    <!--                                    <div class="pt-finder&#45;&#45;form-group">-->
                    <!--                                        <p class="pt-form&#45;&#45;label">-->
                    <!--                                            Title:-->
                    <!--                                        </p>-->
                    <!--                                        <pt-input type="text" :modelValue="upload.title"-->
                    <!--                                                  icon="paper"-->
                    <!--                                                  @update:modelValue="newValue => upload.title = newValue"-->
                    <!--                                        ></pt-input>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                                <div class="pt-col-md-12">-->
                    <!--                                    <div class="pt-finder&#45;&#45;form-group">-->
                    <!--                                        <p class="pt-form&#45;&#45;label">-->
                    <!--                                            Place of receipt:-->
                    <!--                                        </p>-->
                    <!--                                        <pt-input type="text" :modelValue="upload.place"-->
                    <!--                                                  icon="breifcase"-->
                    <!--                                                  @update:modelValue="newValue => upload.place = newValue"-->
                    <!--                                        ></pt-input>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                </div>-->


                </div>

                <div class="pt-finder--form-block">
                    <div class="pt-finder--form-label">
                        <div class="pt-finder--form-label--number">4</div>
                        {{ $t('language_skills') }}
                    </div>
                    <div class="pt-finder--form-block--inner">
                        <div class="pt-finder--form-group"
                             v-for="(item, index) in nurse.languages">
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
                                    <button class="pt-btn--icon pt-m-a pt-mt-35"
                                            @click.prevent="removeLang(item, index)">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="pt-finder--form-group"
                             v-show="languageOptions.length > nurse.languages.length">
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
                                               v-model="nurse.pref_client_gender">
                                        <span class="pt-box--body"></span>
                                        <span class="pt-box--label">{{ $t('male') }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="pt-col-md-3">
                                <div class="pt-finder--form-group">
                                    <label class="pt-box">
                                        <input type="radio" name="preference_for_the_nurse" value="female"
                                               v-model="nurse.pref_client_gender">
                                        <span class="pt-box--body"></span>
                                        <span class="pt-box--label">{{ $t('female') }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="pt-col-md-3">
                                <div class="pt-finder--form-group">
                                    <label class="pt-box">
                                        <input type="radio" name="preference_for_the_nurse" value="no_matter"
                                               v-model="nurse.pref_client_gender">
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
                                <div class="pt-finder--form-grad--item" v-for="n in 6">
                                    <div class="pt-finder--form-grad--item-level"></div>
                                    <div v-if="n - 1 === 0" class="pt-finder--form-grad--item-val"
                                         v-bind:title="$t('not_sure')">{{ n - 1 }}
                                    </div>
                                    <div v-else class="pt-finder--form-grad--item-val">{{ n - 1 }}</div>
                                    <label class="pt-box">
                                        <input type="radio" name="available_care_range" :value="n - 1"
                                               v-model="nurse.available_care_range">
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
                                      v-model="nurse.additional_info">
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
                                      v-model="nurse.multiple_bookings">


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
                                      v-model="nurse.type_of_learning"
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
                                      v-model="nurse.provide_supports"
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
                                          v-model="nurse.one_or_regular">
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
                                          v-model="nurse.ready_to_work">
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
                                <Datepicker format="MM/dd/yyyy" v-model="nurse.start_date_ready_to_work"
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
                                               v-model="nurse.work_time_pref[item.id]">
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
                                               v-model="nurse.work_time_pref[item.id]">
                                        <span class="pt-checkbox--body">{{ item.interval }} Uhr</span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

<!--                <span class="register-form-error" v-if="errors !== null">{{-->
<!--                errors-->
<!--            }}</span>-->


            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-2 offset-8">
                <button class="btn btn-danger btn-sm" v-on:click="closeAddNewNurse()">{{ $t('close_modal') }}
                </button>
            </div>

            <div class="col-2">
                <button class="btn btn-success btn-sm" v-on:click="addNewNurse()">{{ $t('add_new_nurse') }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddNewNurse",
        props: ['data'],
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
                nurse: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    zip_code: '',
                    age: 18,
                    gender: 'male',
                    description: '',
                    experience: '',
                    languages: [],
                    additional_info: [],
                    provide_supports: [],
                    pref_client_gender: 'no_matter',
                    available_care_range: 5,
                    multiple_bookings: 'no',
                    type_of_learning: '',
                    one_or_regular: 'one',
                    ready_to_work: 'yes',
                    start_date_ready_to_work: '',
                    work_time_pref: {
                        "weekdays_7_11": "0",
                        "weekdays_11_14": "0",
                        "weekdays_14_17": "0",
                        "weekdays_17_21": "0",
                        "weekends_7_11": "0",
                        "weekends_11_14": "0",
                        "weekends_14_17": "0",
                        "weekends_17_21": "0"
                    }
                },
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

            this.emitter.on('errors', e => {
                this.errors = e;
            });

            this.emitter.on('no-errors', e => {
                this.errors = null;
            });
        },
        methods: {
            closeAddNewNurse() {
                this.emitter.emit('close-modal');
            },
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
            addNewNurse() {
                this.file = this.$refs.file.files[0];
                let formData = new FormData();
                let nurse = JSON.stringify(this.nurse);
                formData.append('file', this.file);
                formData.append('nurse', nurse);

                axios.post('/dashboard/admin/add-new-nurse',
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
                            this.emitter.emit('response-success-true');
                            this.errors = null;
                        } else {
                            this.errors = response.data.errors;
                            console.log(this.errors);
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
                    (this.nurse.languages && this.nurse.languages.length === 0) ||
                    (this.nurse.languages[this.nurse.languages.length - 1].lang_id &&
                        this.nurse.languages[this.nurse.languages.length - 1].level) &&
                    this.nurse.languages.length < this.languageOptions.length
                ) {
                    this.nurse.languages.push(
                        {
                            id: '',
                            level: '',
                        }
                    )
                    this.activelanguage = this.nurse.languages.length - 1
                }

                if (!this.nurse.languages) {
                    this.nurse.languages = [
                        {
                            id: '',
                            level: '',
                        }
                    ]
                    this.activelanguage = this.nurse.languages.length - 1
                }
            },
        }
    }
</script>

<style scoped>
    .add-new-nurse-wrapper {
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

    .add-new-nurse-content {
        height: 550px;
        overflow-x: hidden;
        overflow-y: auto;
    }


</style>
