<template>
    <div class="pt-finder">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>{{ $t('finder_subtitle') }}</span>
            </p>
            <h2 class="pt-title">
                {{ $t('finder_title') }}
            </h2>

            <div class="pt-info pt-mt-45" v-show="activeStep === 0">
                <div class="pt-info--icon">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="pt-info--text">
                    {{ $t('how_does_the_booking_process_work') }}?

                    <a href="" @click.prevent="openPopup()">
                        {{ $t('click_to_show_more') }}
                    </a>
                </div>
            </div>

            <div class="pt-finder--steps">
                <div class="pt-finder--steps-item" v-for="(item, index) in 3" :class="{active: index === activeStep}">
                    <div class="pt-finder--steps-item--title" @click="activeStep = index">
                        {{ index + 1 }}
                    </div>
                    <div class="pt-finder--steps-item--text">
                        step {{ index + 1 }}
                    </div>
                </div>
            </div>

            <form action="" class="pt-finder--form" @submit.prevent="">
                <div class="pt-finder--form-step" v-show="activeStep === 0">
                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">1</div>
                            {{ $t('for_whom') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="for_whom" value="to_me"
                                           @change="ForMeOrForRelative"
                                           v-model="clientSearchInfo.for_whom">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('to_me') }}</span>
                                </label>
                            </div>
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="for_whom" value="for_a_relative"
                                           @change="ForMeOrForRelative"
                                           v-model="clientSearchInfo.for_whom">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('for_a_relative') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">2</div>
                            {{ $t('information_about_person') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <div class="pt-row">
                                    <div class="pt-col-md-6">
                                        <p class="pt-form--label">
                                            {{ $t('name') }}
                                        </p>
                                        <pt-input type="text" :modelValue="clientSearchInfo.name"
                                                  icon="user"
                                                  @update:modelValue="newValue => clientSearchInfo.name = newValue"
                                        ></pt-input>

                                        <span class="register-form-error"
                                              v-if="errors !== null && errors['name'] !== undefined">
                                            {{ errors['name'][0] }}
                                        </span>
                                    </div>
                                    <div class="pt-col-md-6">
                                        <p class="pt-form--label">
                                            {{ $t('last_name') }}
                                        </p>
                                        <pt-input type="text" :modelValue="clientSearchInfo.last_name"
                                                  icon="user"
                                                  @update:modelValue="newValue => clientSearchInfo.last_name = newValue"
                                        ></pt-input>

                                        <span class="register-form-error"
                                              v-if="errors !== null && errors['last_name'] !== undefined">
                                            {{ errors['last_name'][0] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-finder--form-group">
                                <div class="pt-row">
                                    <div class="pt-col-md-12">
                                        <p class="pt-form--label">
                                            {{ $t('age_range') }}
                                        </p>
                                        <div class="pt-form--box-list">
                                            <div class="pt-form--box-list--item" v-for="box in age_range">
                                                <label class="pt-box">
                                                    <input type="radio" name="age-range" :value="box"
                                                           v-model="clientSearchInfo.age_range">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ box }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">3</div>
                            {{ $t('one_or_regular') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="age-range" value="one"
                                           v-on:click="OneOrRegularCalendar('one')"
                                           v-model="clientSearchInfo.one_or_regular">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('one') }}</span>
                                </label>
                            </div>
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="age-range" value="regular"
                                           v-on:click="OneOrRegularCalendar('regular')"
                                           v-model="clientSearchInfo.one_or_regular">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('regular') }}</span>
                                </label>
                            </div>

                            <div class="pt-finder--form-group">

                                <div class="pt-calendar">
                                    <Datepicker v-model="clientSearchInfo.one_time_date"
                                                inline
                                                autoApply
                                                :monthChangeOnScroll="false"
                                                v-show="showOneTimeCalendar"
                                                :enableTimePicker="false"/>

                                    <Datepicker v-model="clientSearchInfo.regular_time_range"
                                                inline
                                                autoApply
                                                range
                                                v-show="showRegularCalendar"
                                                :monthChangeOnScroll="false"
                                                :enableTimePicker="false"/>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">4</div>
                            {{ $t('weekdays') }} {{ $t('mon_fri') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <div class="">
                                    <template v-for="item in data.time_intervals">
                                        <label class="pt-checkbox" v-if="item.type === 'weekdays'">
                                            <input type="checkbox" name="work_time_pref"
                                                   true-value="1" false-value="0"
                                                   v-model="clientSearchInfo.work_time_pref[item.id]">
                                            <span class="pt-checkbox--body">{{item.interval}} Uhr</span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">5</div>
                            {{ $t('weekends') }} {{ $t('sat_sun') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <div class="">
                                    <template v-for="item in data.time_intervals">
                                        <label class="pt-checkbox" v-if="item.type === 'weekends'">
                                            <input type="checkbox" name="work_time_pref"
                                                   true-value="1" false-value="0"
                                                   v-model="clientSearchInfo.work_time_pref[item.id]">
                                            <span class="pt-checkbox--body">{{item.interval}} Uhr</span>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">6</div>
                            {{ $t('what_support_looking') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <p class="pt-form--label">
                                    {{ $t('what_support_looking_subtitle') }} :
                                </p>

                                <div class="pt-select">
                                    <div class="pt-select--icon">
                                        <pt-icon type="help"></pt-icon>
                                    </div>
                                    <v-select multiple :options="translateOptions(data.provider_supports)"
                                              label="title"
                                              v-model="clientSearchInfo.provider_supports"
                                              :reduce="(option) => option.id">
                                        <template #option="{ title }">
                                            {{ title }}
                                        </template>

                                        <template #open-indicator>
                                            <span class="pt-select--caret"></span>
                                        </template>
                                    </v-select>
                                </div>

                                <span class="register-form-error"
                                      v-if="errors !== null && errors['provider_supports'] !== undefined">{{
                                        errors['provider_supports'][0]
                                    }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <button class="pt-btn--primary pt-md pt-mt-20 pt-m-a"
                                @click.prevent="setStep(++activeStep)">
                            {{ $t('next_btn') }}
                        </button>
                    </div>
                </div>

                <div class="pt-finder--form-step" v-show="activeStep === 1">
                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">1</div>
                            {{ $t('nurse_location_title') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <p class="pt-form--label">
                                    {{ $t('nurse_location_subtitle') }}
                                </p>
                                <div class="pt-input">
                                    <div class="pt-input--icon">
                                        <pt-icon type="pin"></pt-icon>
                                    </div>
                                    <GMapAutocomplete
                                        class="pt-input"
                                        placeholder=""
                                        @place_changed="setPlace"
                                    >
                                    </GMapAutocomplete>
                                    <div class="pt-input--box"></div>
                                </div>
                            </div>
                            <div class="pt-finder--form-group">
                                <GMapMap
                                    class="map"
                                    :center="{lat: 51.093048, lng: 6.842120}"
                                    :zoom="7"
                                >
                                </GMapMap>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">2</div>
                            {{ $t('degree_of_care_title') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <p class="pt-form--label">
                                    {{ $t('degree_of_care_subtitle') }}
                                </p>

                                <div class="pt-select">
                                    <div class="pt-select--icon">
                                        <pt-icon type="help"></pt-icon>
                                    </div>
                                    <v-select :options="translateOptions(care_degree_options)"
                                              label="title"
                                              v-model="clientSearchInfo.degree_of_care_available"
                                              :reduce="(option) => option.id">
                                        <template #option="{ title }">
                                            {{ title }}
                                        </template>

                                        <template #open-indicator>
                                            <span class="pt-select--caret"></span>
                                        </template>
                                    </v-select>
                                </div>

                                <span class="register-form-error"
                                      v-if="errors !== null && errors['provider_supports'] !== undefined">{{
                                        errors['provider_supports'][0]
                                    }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">3</div>
                            {{ $t('language_skills') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group"
                                 v-for="(item, index) in clientSearchInfo.languages">
                                <div class="pt-row">
                                    <div class="pt-col-md-6" :class="{'pt-disabled': index !== activelanguage}">
                                        <p class="pt-form--label">
                                            {{ $t('language_title') }}
                                        </p>

                                        <div class="pt-select">
                                            <div class="pt-select--icon">
                                                <pt-icon type="globe"></pt-icon>
                                            </div>
                                            <v-select :options="filteredOption(languageOptions)"
                                                      label="title"
                                                      v-model="item.id"
                                                      :reduce="(option) => option.id">
                                                <template #option="{ title }">
                                                    {{ title }}
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

                            <div class="pt-finder--form-group" v-show="languageOptions.length > clientSearchInfo.languages.length">
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

                    <div class="pt-finder--form-block pt-mt-20">
                        <div class="pt-row">
                            <div class="pt-col-md-6">
                                <button class="pt-btn--primary-border pt-md pt-ml-a" @click="setStep(--activeStep)">
                                    {{ $t('back_btn') }}
                                </button>
                            </div>
                            <div class="pt-col-md-6">
                                <button class="pt-btn--primary pt-md pt-mr-a"
                                        @click.prevent="setStep(++activeStep)">
                                    {{ $t('next_btn') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-finder--form-step" v-show="activeStep === 2">
                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">1</div>
                            {{ $t('do_you_need_help_moving') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="do_you_need_help_moving" value="yes"
                                           v-model="clientSearchInfo.do_you_need_help_moving">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('yes') }}</span>
                                </label>
                            </div>
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="do_you_need_help_moving" value="no"
                                           v-model="clientSearchInfo.do_you_need_help_moving">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('no') }}</span>
                                </label>
                            </div>
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="do_you_need_help_moving" value="unknown"
                                           v-model="clientSearchInfo.do_you_need_help_moving">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('unknown') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">2</div>
                            {{ $t('disease') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <p class="pt-form--label">
                                    {{ $t('disease_subtitle') }}
                                </p>

                                <div class="pt-select">
                                    <div class="pt-select--icon">
                                        <pt-icon type="help"></pt-icon>
                                    </div>
                                    <v-select :options="data.additional_info"
                                              label="alias"
                                              v-model="clientSearchInfo.disease"
                                              :reduce="(option) => option.id">
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
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">3</div>
                            {{ $t('additional_transportation') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <div class="pt-row">
                                    <div class="pt-col-md-6">
                                        <div class="pt-form--box-list">
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="additional_transportation"
                                                           value="need_help_with_walking"
                                                           v-model="clientSearchInfo.additional_transportation">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('need_help_with_walking') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="additional_transportation" value="nothing"
                                                           v-model="clientSearchInfo.additional_transportation">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('nothing') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="additional_transportation"
                                                           value="wheelchair"
                                                           v-model="clientSearchInfo.additional_transportation">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('wheelchair') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="additional_transportation" value="unknown"
                                                           v-model="clientSearchInfo.additional_transportation">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('unknown') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="additional_transportation"
                                                           value="crutches"
                                                           v-model="clientSearchInfo.additional_transportation">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('crutches') }}</span>
                                                </label>
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
                            {{ $t('memory') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <div class="pt-row">
                                    <div class="pt-col-md-6">
                                        <div class="pt-form--box-list">
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="memory"
                                                           value="good"
                                                           v-model="clientSearchInfo.memory">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('good') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="memory"
                                                           value="minor_difficulties"
                                                           v-model="clientSearchInfo.memory">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('minor_difficulties') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="memory"
                                                           value="significant_difficulties"
                                                           v-model="clientSearchInfo.memory">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('significant_difficulties') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="memory"
                                                           value="unknown"
                                                           v-model="clientSearchInfo.memory">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('unknown') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">5</div>
                            {{ $t('incontinence') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="incontinence" value="yes"
                                           v-model="clientSearchInfo.incontinence">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('yes') }}</span>
                                </label>
                            </div>
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="incontinence" value="no"
                                           v-model="clientSearchInfo.incontinence">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('no') }}</span>
                                </label>
                            </div>
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="incontinence" value="unknown"
                                           v-model="clientSearchInfo.incontinence">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('unknown') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">6</div>
                            {{ $t('preference_for_the_nurse') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="preference_for_the_nurse" value="male"
                                           v-model="clientSearchInfo.preference_for_the_nurse">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('male') }}</span>
                                </label>
                            </div>
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="preference_for_the_nurse" value="female"
                                           v-model="clientSearchInfo.preference_for_the_nurse">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('female') }}</span>
                                </label>
                            </div>
                            <div class="pt-finder--form-group">
                                <label class="pt-box">
                                    <input type="radio" name="preference_for_the_nurse" value="no_matter"
                                           v-model="clientSearchInfo.preference_for_the_nurse">
                                    <span class="pt-box--body"></span>
                                    <span class="pt-box--label">{{ $t('no_matter') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">7</div>
                            {{ $t('hearing') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <div class="pt-row">
                                    <div class="pt-col-md-6">
                                        <div class="pt-form--box-list">
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="hearing"
                                                           value="good"
                                                           v-model="clientSearchInfo.hearing">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('good') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="hearing"
                                                           value="weak"
                                                           v-model="clientSearchInfo.hearing">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('weak') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="hearing"
                                                           value="difficulties"
                                                           v-model="clientSearchInfo.hearing">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('difficulties') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="hearing"
                                                           value="unknown"
                                                           v-model="clientSearchInfo.hearing">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('unknown') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="hearing"
                                                           value="essential"
                                                           v-model="clientSearchInfo.hearing">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('essential') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">8</div>
                            {{ $t('vision') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <div class="pt-row">
                                    <div class="pt-col-md-6">
                                        <div class="pt-form--box-list">
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="vision"
                                                           value="good"
                                                           v-model="clientSearchInfo.vision">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('good') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="vision"
                                                           value="minor_difficulties"
                                                           v-model="clientSearchInfo.vision">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('minor_difficulties') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="vision"
                                                           value="significant_difficulties"
                                                           v-model="clientSearchInfo.vision">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{
                                                            $t('significant_difficulties')
                                                        }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="vision"
                                                           value="unknown"
                                                           v-model="clientSearchInfo.vision">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('unknown') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block">
                        <div class="pt-finder--form-label">
                            <div class="pt-finder--form-label--number">9</div>
                            {{ $t('areas_help') }}
                        </div>
                        <div class="pt-finder--form-block--inner">
                            <div class="pt-finder--form-group">
                                <div class="pt-row">
                                    <div class="pt-col-md-6">
                                        <div class="pt-form--box-list">
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="areas_help"
                                                           value="dressing"
                                                           v-model="clientSearchInfo.areas_help">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('dressing') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="areas_help"
                                                           value="mobility"
                                                           v-model="clientSearchInfo.areas_help">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('mobility') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="areas_help"
                                                           value="hygiene"
                                                           v-model="clientSearchInfo.areas_help">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('hygiene') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="areas_help"
                                                           value="preparation_of_medicines"
                                                           v-model="clientSearchInfo.areas_help">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('preparation_of_medicines') }}</span>
                                                </label>
                                            </div>
                                            <div class="pt-form--box-list--item">
                                                <label class="pt-box">
                                                    <input type="radio" name="areas_help"
                                                           value="skin_care"
                                                           v-model="clientSearchInfo.areas_help">
                                                    <span class="pt-box--body"></span>
                                                    <span class="pt-box--label">{{ $t('skin_care') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-finder--form-group">
                                <div class="pt-row">
                                    <div class="pt-col-md-6">
                                        <p class="pt-form--label">
                                            {{ $t('other_areas') }}
                                        </p>
                                        <pt-input type="text" :modelValue="clientSearchInfo.other_areas"
                                                  icon="user"
                                                  @update:modelValue="newValue => clientSearchInfo.other_areas = newValue"
                                        ></pt-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-finder--form-block pt-mt-20">
                        <div class="pt-row">
                            <div class="pt-col-md-6">
                                <button class="pt-btn--primary-border pt-md pt-ml-a" @click="setStep(--activeStep)">
                                    {{ $t('back_btn') }}
                                </button>
                            </div>
                            <div class="pt-col-md-6">
                                <button class="pt-btn--primary pt-md pt-mr-a" @click="saveClientInfo()">
                                    {{ $t('find') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

                </h3>
                <p>{{ $t('how_does_the_booking_process_work_description') }}</p>
                <button @click.prevent="closePopup" class="pt-btn--primary pt-sm pt-m-a pt-mt-25">
                    ok
                </button>
            </div>
        </div>
    </Modal>

</template>

<script>

import NursesListing from "./NursesListing";
import NurseProfile from "./NurseProfile";
import Slider from '@vueform/slider'
import '@vueform/slider/themes/default.css'

export default {
    //name: "Finder"
    name: 'Finder',
    components: {
        Slider,
        'nurses-listing': NursesListing,
        'nurses-profile': NurseProfile,
    },
    props: ['data', 'user'],
    data() {
        return {
            isOpen: false,
            mapOptions: {

            },
            center: {
                lat: 43.689247,
                lng: -74.044502
            },
            date: new Date(),
            care_degree_options: [
                {
                    id: 0,
                    name: 'not_sure'
                },
                {
                    id: 1,
                    name: '1'
                },
                {
                    id: 2,
                    name: '2'
                },
                {
                    id: 3,
                    name: '3'
                },
                {
                    id: 4,
                    name: '4'
                },
                {
                    id: 5,
                    name: '5'
                },
            ],
            age_range: [
                '0-20',
                '20-40',
                '40-60',
                '60-70',
                '70-80',
                '80-90',
                '90+',
            ],
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
            activeStep: 0,
            activelanguage: 0,
            path: location.origin,
            nurses: [],
            nurse: null,
            errors: null,
            showReminder: false,
            showModalNursesListing: false,
            showModalNurseProfile: false,
            showOneTimeCalendar: false,
            showRegularCalendar: false,
            url: 'finder/save-client-search-info',
            clientSearchInfo: {
                languages: [
                    {
                        id: '',
                        level: '',
                    }
                ],
                regular_time_range: [],
                for_whom: 'for_a_relative',
                name: '',
                last_name: '',
                age_range: '20-40',
                provider_supports: [],
                disease: [],
                other_disease: '',
                degree_of_care_available: 3,
                // language: 'no_matter',
                // language_level: 'no_matter',
                do_you_need_help_moving: 'unknown',
                additional_transportation: 'unknown',
                memory: 'unknown',
                incontinence: 'unknown',
                preference_for_the_nurse: 'no_matter',
                hearing: 'unknown',
                vision: 'unknown',
                areas_help: 'hygiene',
                other_areas: '',
                one_or_regular: '',
                one_time_date: null,
                regular_time_start_date: null,
                regular_time_finish_date: null,
                work_time_pref: [],
            }
        }
    },
    watch: {
        showReminder(showReminder) {
            if (showReminder) {
                document.addEventListener('click', this.closeReminderBlock);
            }
        },
    },
    computed: {},
    mounted() {
        console.log(this.data);
        this.getClientSearchInfo();

    },
    methods: {
        closePopup(id){
            this.isOpen = false
        },
        openPopup(id){
            this.isOpen = true
        },
        setPlace(e) {
            console.log(e)
            console.log('test')
        },
        test(e) {
            this.center.lat = e.latLng.lat()
            this.center.lng = e.latLng.lng()
        },
        removeLang(item, index) {
            this.clientSearchInfo.languages.splice(index, 1)
            this.activelanguage = this.clientSearchInfo.languages.length - 1
        },
        filteredOption(options) {
            let self = this
            let result = self.data.languages.filter(function (item){
                let tmp = self.clientSearchInfo.languages.find(function (el){
                    return el.id === item.id
                })
                return !tmp
            })
            return result
        },
        addLanguage() {
            if(
                this.clientSearchInfo.languages &&
                this.clientSearchInfo.languages.length === 0 ||
                (this.clientSearchInfo.languages[this.clientSearchInfo.languages.length-1].id &&
                    this.clientSearchInfo.languages[this.clientSearchInfo.languages.length-1].level) &&
                this.clientSearchInfo.languages.length < this.languageOptions.length
            ){
                this.clientSearchInfo.languages.push(
                    {
                        id: '',
                        level: '',
                    }
                )
                this.activelanguage = this.clientSearchInfo.languages.length - 1
            }

            if(!this.clientSearchInfo.languages){
                this.clientSearchInfo.languages = [
                    {
                        id: '',
                        level: '',
                    }
                ]
                this.activelanguage = this.clientSearchInfo.languages.length - 1
            }
        },
        translateOptions(options) {
            let self = this
            options.forEach(function (item) {
                item.title = self.$t(item.name)
            })
            return options
        },
        setStep(n) {
            this.activeStep = n
        },
        getClientSearchInfo() {
            axios.get('finder/get-client-search-info')
                .then((response) => {
                    if (response.data.success) {
                        console.log(response.data.clientSearchInfo)
                        this.clientSearchInfo = response.data.clientSearchInfo;
                        this.clientSearchInfo.provider_supports = JSON.parse(this.clientSearchInfo.provider_supports);
                        this.clientSearchInfo.work_time_pref = JSON.parse(this.clientSearchInfo.work_time_pref);
                        this.clientSearchInfo.languages = JSON.parse(this.clientSearchInfo.languages);
                        this.clientSearchInfo.disease = JSON.parse(this.clientSearchInfo.disease);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        saveClientInfo() {
            this.closeCalendars();
            axios.post(this.url, {'clientSearchInfo': this.clientSearchInfo})
                .then((response) => {
                    if (response.data.success) {
                        this.$router.push({ name: 'Listing' })
                    } else {
                        this.errors = response.data.errors;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showReminderBlock() {
            this.showReminder === true ? this.showReminder = false : this.showReminder = true;
        },
        closeReminderBlock(event) {
            if (!document.getElementById('listing-reminder-end').contains(event.target)) {
                this.showReminder = false;
                document.removeEventListener('click', this.closeReminderBlock);
            }
        },
        ForMeOrForRelative() {
            if (this.clientSearchInfo.for_whom == 'to_me') {
                this.clientSearchInfo.name = this.user.first_name;
                this.clientSearchInfo.last_name = this.user.last_name;
            }

            if (this.clientSearchInfo.for_whom == 'for_a_relative') {
                this.clientSearchInfo.name = '';
                this.clientSearchInfo.last_name = '';
            }
        },
        OneOrRegularCalendar(item) {
            if (item == 'one') {
                this.showOneTimeCalendar = true;
                this.showRegularCalendar = false;
            }

            if (item == 'regular') {
                this.showOneTimeCalendar = false;
                this.showRegularCalendar = true;
            }
        },
        closeCalendars() {
            this.showOneTimeCalendar = false;
            this.showRegularCalendar = false;
        },
    }
}

</script>

<style scoped>

.map{
    display: block;
    width: 100%;
    height: 500px;
}

</style>
