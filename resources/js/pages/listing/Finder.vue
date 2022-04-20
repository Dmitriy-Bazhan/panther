<template>
    <div class="pt-finder">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>Suchen</span>
            </p>
            <h2 class="pt-title">
                Pflegecraft finden
            </h2>

            <div class="listing-reminder-begin">
                {{ $t('how_does_the_booking_process_work') }}?
                <div class="listing-reminder-end" id="listing-reminder-end" v-on:click="showReminderBlock()">
                    {{ $t('click_to_show_more') }}
                </div>
            </div>

            <div v-if="showReminder" class="block-with-reminder">
                <p>{{ $t('how_does_the_booking_process_work_description') }}</p>
            </div>

            <div class="pt-finder--steps">
                <div class="pt-finder--steps-item" v-for="(item, index) in 3" :class="{active: index === activeStep}">
                    <div class="pt-finder--steps-item--title">
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

                                <Datepicker v-model="clientSearchInfo.one_time_date"
                                            inline
                                            autoApply
                                            :monthChangeOnScroll="false"
                                            v-show="showOneTimeCalendar"
                                            :enableTimePicker="false" />

                                <Datepicker v-model="clientSearchInfo.regular_time_range"
                                            inline
                                            autoApply
                                            range
                                            v-show="showRegularCalendar"
                                            :monthChangeOnScroll="false"
                                            :enableTimePicker="false" />

                            </div>
                        </div>
                    </div>
                </div>


                <div class="pt-finder--form-step" v-show="activeStep === 1">
                    <div class="container-fluid">
                        <div class="row">


                            <div class="col-3">
                                <!--provider supports-->
                                <label for="provider_support" class="form-label col-form-label-sm">{{
                                        $t('what_support_looking')
                                    }}</label>
                                <select id="provider_support" class="form-select form-select-sm" multiple
                                        v-model="clientSearchInfo.provider_supports">
                                    <option v-if="data.provider_supports.length > 0"
                                            v-for="provider_support in data.provider_supports"
                                            v-bind:value="provider_support.id">
                                        {{ $t(provider_support.name) }}
                                    </option>
                                </select>
                                <span class="register-form-error"
                                      v-if="errors !== null && errors['provider_supports'] !== undefined">{{
                                        errors['provider_supports'][0]
                                    }}</span>

                                <!--                additional info , disease -->
                                <label for="disease" class="form-label col-form-label-sm">{{ $t('disease') }}</label>
                                <select id="disease" class="form-select form-select-sm" multiple
                                        v-model="clientSearchInfo.disease">
                                    <option v-if="data.additional_info.length > 0"
                                            v-for="info in data.additional_info"
                                            v-bind:value="info.id">
                                        {{ info.data.data }}
                                    </option>
                                </select>

                                <label for="other_disease" class="form-label col-form-label-sm">{{
                                        $t('other_disease')
                                    }}</label>
                                <input id="other_disease" class="form-control form-control-sm" type="text"
                                       v-model="clientSearchInfo.other_disease">

                                <!--degree of care available-->
                                <label for="degree_of_care_available" class="form-label col-form-label-sm">{{
                                        $t('is_degree_of_care')
                                    }}</label><br>
                                <select id="degree_of_care_available" class="form-select form-select-sm"
                                        v-model="clientSearchInfo.degree_of_care_available">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="0">{{ $t('not_sure') }}</option>
                                </select>

                            </div>


                            <div class="col-3">
                                <!--languages-->
                                <label class="form-label col-form-label-sm">{{ $t('language_skills') }}</label><br>
                                <div class="row">
                                    <div class="col-8">
                                        <select class="form-control form-control-sm" id="language"
                                                v-model="clientSearchInfo.language">
                                            <option value="english">{{ $t('english') }}</option>
                                            <option value="deutsche">{{ $t('german') }}</option>
                                            <option value="no_matter">{{ $t('no_matter') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <select class="form-control form-control-sm"
                                                v-model="clientSearchInfo.language_level">
                                            <option value="A1">A1</option>
                                            <option value="A2">A2</option>
                                            <option value="B1">B1</option>
                                            <option value="B2">B2</option>
                                            <option value="C1">C1</option>
                                            <option value="C2">C2</option>
                                            <option value="no_matter">{{ $t('no_matter') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!--                help to move-->
                                <label for="do_you_need_help_moving" class="form-label col-form-label-sm">{{
                                        $t('do_you_need_help_moving')
                                    }}</label><br>
                                <select class="form-control form-control-sm" id="do_you_need_help_moving"
                                        v-model="clientSearchInfo.do_you_need_help_moving">
                                    <option value="yes">{{ $t('yes') }}</option>
                                    <option value="no">{{ $t('no') }}</option>
                                    <option value="unknown">{{ $t('unknown') }}</option>
                                </select>

                                <!--                additional means of transportation-->
                                <label for="additional_transportation" class="form-label col-form-label-sm">{{
                                        $t('additional_transportation')
                                    }}</label><br>
                                <select class="form-control form-control-sm" id="additional_transportation"
                                        v-model="clientSearchInfo.additional_transportation">
                                    <option value="need_help_with_walking">{{ $t('need_help_with_walking') }}</option>
                                    <option value="wheelchair">{{ $t('wheelchair') }}</option>
                                    <option value="crutches">{{ $t('crutches') }}</option>
                                    <option value="nothing">{{ $t('nothing') }}</option>
                                    <option value="unknown">{{ $t('unknown') }}</option>
                                </select>

                                <!--                Memory-->
                                <label for="memory" class="form-label col-form-label-sm">{{ $t('memory') }}</label><br>
                                <select class="form-control form-control-sm" id="memory"
                                        v-model="clientSearchInfo.memory">
                                    <option value="good">{{ $t('good') }}</option>
                                    <option value="minor_difficulties">{{ $t('minor_difficulties') }}</option>
                                    <option value="significant_difficulties">{{
                                            $t('significant_difficulties')
                                        }}
                                    </option>
                                    <option value="unknown">{{ $t('unknown') }}</option>
                                </select>

                                <!--                suffer from urinary incontinence-->
                                <label for="incontinence" class="form-label col-form-label-sm">{{
                                        $t('incontinence')
                                    }}</label><br>
                                <select class="form-control form-control-sm" id="incontinence"
                                        v-model="clientSearchInfo.incontinence">
                                    <option value="yes">{{ $t('yes') }}</option>
                                    <option value="no">{{ $t('no') }}</option>
                                    <option value="unknown">{{ $t('unknown') }}</option>
                                </select>

                            </div>

                            <div class="col-3">

                                <!--                Is there a gender preference for the nurse-->
                                <label for="preference_for_the_nurse" class="form-label col-form-label-sm">{{
                                        $t('preference_for_the_nurse')
                                    }}</label><br>
                                <select class="form-control form-control-sm" id="preference_for_the_nurse"
                                        v-model="clientSearchInfo.preference_for_the_nurse">
                                    <option value="male">{{ $t('male') }}</option>
                                    <option value="female">{{ $t('female') }}</option>
                                    <option value="no_matter">{{ $t('no_matter') }}</option>
                                </select>

                                <!--                hearing-->
                                <label for="hearing" class="form-label col-form-label-sm">{{
                                        $t('hearing')
                                    }}</label><br>
                                <select class="form-control form-control-sm" id="hearing"
                                        v-model="clientSearchInfo.hearing">
                                    <option value="good">{{ $t('good') }}</option>
                                    <option value="weak">{{ $t('weak') }}</option>
                                    <option value="difficulties">{{ $t('difficulties') }}</option>
                                    <option value="essential">{{ $t('essential') }}</option>
                                    <option value="unknown">{{ $t('unknown') }}</option>
                                </select>

                                <!--                Vision-->
                                <label for="vision" class="form-label col-form-label-sm">{{ $t('vision') }}</label><br>
                                <select class="form-control form-control-sm" id="vision"
                                        v-model="clientSearchInfo.vision">
                                    <option value="good">{{ $t('good') }}</option>
                                    <option value="minor_difficulties">{{ $t('minor_difficulties') }}</option>
                                    <option value="significant_difficulties">{{
                                            $t('significant_difficulties')
                                        }}
                                    </option>
                                    <option value="unknown">{{ $t('unknown') }}</option>
                                </select>

                                <!--                Areas where help is needed-->
                                <label for="areas_help" class="form-label col-form-label-sm">{{
                                        $t('areas_help')
                                    }}</label><br>
                                <select class="form-control form-control-sm" id="areas_help"
                                        v-model="clientSearchInfo.areas_help">
                                    <option value="dressing">{{ $t('dressing') }}</option>
                                    <option value="mobility">{{ $t('mobility') }}</option>
                                    <option value="hygiene">{{ $t('hygiene') }}</option>
                                    <option value="preparation_of_medicines">{{
                                            $t('preparation_of_medicines')
                                        }}
                                    </option>
                                    <option value="skin_care">{{ $t('skin_care') }}</option>
                                </select>

                                <label for="other_areas" class="form-label col-form-label-sm">{{
                                        $t('other_areas')
                                    }}</label>
                                <input id="other_areas" class="form-control form-control-sm" type="text"
                                       v-model="clientSearchInfo.other_areas">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4 offset-4 justify-content-center">{{ $t('weekdays') }}</div>
                                    <div class="col-4 justify-content-center">{{ $t('weekends') }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 offset-4 justify-content-center">{{ $t('mon_fri') }}</div>
                                    <div class="col-4 justify-content-center">{{ $t('sat_sun') }}</div>
                                </div>

                                <!--                        7-11 Uhr  -->
                                <div class="row">
                                    <div class="col-4">7-11 Uhr</div>
                                    <div class="col-4 justify-content-center">
                                        <input type="checkbox" id="weekdays_morning" true-value="1" false-value="0"
                                               v-model="clientSearchInfo.work_time_pref.weekdays_7_11">
                                        &nbsp;<label for="weekdays_morning"></label>
                                    </div>
                                    <div class="col-4 justify-content-center">
                                        <input type="checkbox" id="weekends_morning" true-value="1" false-value="0"
                                               v-model="clientSearchInfo.work_time_pref.weekends_7_11">
                                        &nbsp;<label for="weekends_morning"></label>
                                    </div>
                                </div>
                                <!--                        11-14 Uhr  -->
                                <div class="row">
                                    <div class="col-4">11-14 Uhr</div>
                                    <div class="col-4 justify-content-center">
                                        <input type="checkbox" id="weekdays_afternoon" true-value="1" false-value="0"
                                               v-model="clientSearchInfo.work_time_pref.weekdays_11_14">
                                        &nbsp;<label for="weekdays_afternoon"></label>
                                    </div>
                                    <div class="col-4 justify-content-center">
                                        <input type="checkbox" id="weekends_afternoon" true-value="1" false-value="0"
                                               v-model="clientSearchInfo.work_time_pref.weekends_11_14">
                                        &nbsp;<label for="weekends_afternoon"></label>
                                    </div>
                                </div>
                                <!--                        14-17 Uhr -->
                                <div class="row">
                                    <div class="col-4">14-17 Uhr</div>
                                    <div class="col-4 justify-content-center">
                                        <input type="checkbox" id="weekdays_evening" true-value="1" false-value="0"
                                               v-model="clientSearchInfo.work_time_pref.weekdays_14_17">
                                        &nbsp;<label for="weekdays_evening"></label>
                                    </div>
                                    <div class="col-4 justify-content-center">
                                        <input type="checkbox" id="weekends_evening" true-value="1" false-value="0"
                                               v-model="clientSearchInfo.work_time_pref.weekends_14_17">
                                        &nbsp;<label for="weekends_evening"></label>
                                    </div>
                                </div>
                                <!--                        17-21 Uhr -->
                                <div class="row">
                                    <div class="col-4">17-21 Uhr</div>
                                    <div class="col-4 justify-content-center">
                                        <input type="checkbox" id="weekdays_overnight" true-value="1" false-value="0"
                                               v-model="clientSearchInfo.work_time_pref.weekdays_17_21">
                                        &nbsp;<label for="weekdays_overnight"></label>
                                    </div>
                                    <div class="col-4 justify-content-center">
                                        <input type="checkbox" id="weekends_overnight" true-value="1" false-value="0"
                                               v-model="clientSearchInfo.work_time_pref.weekends_17_21">
                                        &nbsp;<label for="weekends_overnight"></label>
                                    </div>
                                </div>
                            </div>
                            <!--            <div class="col-5">-->
                            <!--                <label for="where_should_help_be_provided" class="form-label col-form-label-sm">-->
                            <!--                    {{ $t('where_should_help_be_provided') }}</label><br>-->
                            <!--                <input id="where_should_help_be_provided" placeholder="Later">-->
                            <!--            </div>-->

                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-2 offset-10">
                                <button class="btn btn-success btn-sm" v-on:click="findNeedNurses()">{{
                                        $t('find')
                                    }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <div v-if="showModalNursesListing" class="nurses-listing-wrapper">
                <nurses-listing :nurses="nurses"></nurses-listing>
            </div>

            <div v-if="showModalNurseProfile" class="nurse-profile-wrapper">
                <nurses-profile :nurse="nurse" :data="data" :user="user"></nurses-profile>
            </div>
        </div>
    </div>

</template>

<script>
import NursesListing from "./NursesListing";
import NurseProfile from "./NurseProfile";

export default {
    //name: "Finder"
    name: 'Finder',
    components: {
        'nurses-listing': NursesListing,
        'nurses-profile': NurseProfile,
    },
    props: ['data', 'user'],
    data() {
        return {
            date: new Date(),
            age_range: [
                '0-20',
                '20-40',
                '40-60',
                '60-70',
                '70-80',
                '80-90',
                '90+',
            ],

            activeStep: 0,
            path: location.origin,
            nurses: [],
            nurse: null,
            errors: null,
            showReminder: false,
            showModalNursesListing: false,
            showModalNurseProfile: false,
            showOneTimeCalendar: false,
            showRegularCalendar: false,
            url: 'finder/get-nurses-to-listing',
            clientSearchInfo: {
                regular_time_range: [],
                for_whom: 'for_a_relative',
                name: '',
                last_name: '',
                age_range: '',
                provider_supports: [],
                disease: [],
                other_disease: '',
                degree_of_care_available: 3,
                language: 'no_matter',
                language_level: 'no_matter',
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
                work_time_pref: {
                    weekdays_7_11: "0",
                    weekends_7_11: "0",
                    weekdays_11_14: "0",
                    weekends_11_14: "0",
                    weekdays_14_17: "0",
                    weekends_14_17: "0",
                    weekdays_17_21: "0",
                    weekends_17_21: "0",
                },
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
    mounted() {
        this.getClientSearchInfo();
        this.emitter.on('close-modal-nurse-listing', e => {
            this.showModalNursesListing = false;
        });

        this.emitter.on('close-modal-nurse-profile', e => {
            this.nurse = null;
            this.showModalNurseProfile = false;
        });

        this.emitter.on('get-nurses-new-page', url => {
            if (url !== null) {
                this.url = url;
                this.findNeedNurses();
            }

        });

        this.emitter.on('show-nurse-profile', nurse => {
            if (nurse !== null) {
                this.nurse = nurse;
                this.showModalNurseProfile = true;
            }
        });
    },
    methods: {
        getClientSearchInfo() {
            axios.get('finder/get-client-search-info')
                .then((response) => {
                    if (response.data.success) {
                        //this.clientSearchInfo = response.data.clientSearchInfo;
                        this.clientSearchInfo.provider_supports = JSON.parse(this.clientSearchInfo.provider_supports);
                        this.clientSearchInfo.work_time_pref = JSON.parse(this.clientSearchInfo.work_time_pref);
                        this.clientSearchInfo.disease = JSON.parse(this.clientSearchInfo.disease);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        findNeedNurses() {
            this.closeCalendars();
            axios.post(this.url, {'clientSearchInfo': this.clientSearchInfo})
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.errors = null;
                        this.nurses = response.data.nurses;
                        this.showModalNursesListing = true;
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
            console.log('input')
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
        }
    }
}

</script>

<style scoped>
.listing-reminder-begin {
    font-size: 14px;
    color: green;
}

.listing-reminder-end {
    font-size: 12px;
    color: blue;
    text-decoration: underline;
    cursor: pointer;
}

.block-with-reminder {
    position: absolute;
    border: solid 1px red;
    border-radius: 10px;
    background: blue;
    padding: 10px;
    width: 50%;
}

.nurses-listing-wrapper {
    position: fixed;
    width: 70%;
    top: 10%;
    left: 20%;
    background: #d9d9d9;
    padding: 15px;
    border: #888888;
    border-radius: 10px;
    height: 70%;
    z-index: 100;
    overflow: auto;
}

.nurse-profile-wrapper {
    position: fixed;
    width: 94%;
    top: 3%;
    left: 3%;
    background: #98d9b2;
    padding: 15px;
    border: #388844;
    border-radius: 10px;
    height: 90%;
    z-index: 200;
    overflow: auto;
}

.listing-one-time-calendar-wrapper, .listing-regular-calendar-wrapper {
    position: fixed;
    width: 50%;
    top: 20%;
    left: 25%;
    background: #98d9b2;
    padding: 15px;
    border: #388844;
    border-radius: 10px;
    height: 50%;
    z-index: 200;
    overflow: auto;
}

</style>
