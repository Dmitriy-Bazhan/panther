<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-9">
                <div class="row">
                    <div class="col-4">
                        <div>
                            <label class="form-label col-form-label-sm">Client propose price: {{
                                booking.suggested_price_per_hour }}</label>
                        </div>
                        <div>
                            <label class="form-label col-form-label-sm">Your price</label>
                            <input type="number" class="form-control form-control-sm"
                                   v-model="alternative.alternative_suggested_price_per_hour" min="15">
                        </div>
                    </div>
                    <div class="col-4">
                        <div>
                            <label class="form-label col-form-label-sm">{{ $t('one_time_or_regular') }}: {{
                                booking.one_time_or_regular }}</label>
                        </div>
                        <div>
                            <label class="form-label col-form-label-sm">{{ $t('your_one_time_or_regular') }}</label>
                            <select class="form-control form-control-sm"
                                    v-model="alternative.alternative_one_time_or_regular">
                                <option value="one">{{ $t('one') }}</option>
                                <option value="regular">{{ $t('regular') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div>
                            <label class="form-label col-form-label-sm">{{ $t('start_date') }}: {{ booking.start_date
                                }}</label>
                        </div>
                        <div>
                            <label class="form-label col-form-label-sm">{{ $t('your_start_date') }}</label>
                            <input type="date" class="form-control form-control-sm"
                                   v-model="alternative.alternative_start_date">
                        </div>
                    </div>
                </div>
                <div class="row" v-if="show_for_regular">
                    <div class="col-4">
                        <div>
                            <label class="form-label col-form-label-sm">{{ $t('weeks') }}: {{
                                booking.weeks }}</label>
                        </div>
                        <div>
                            <label class="form-label col-form-label-sm">{{ $t('your_weeks') }}</label>
                            <input type="number" min="1" class="form-control form-control-sm"
                                   v-model="alternative.alternative_weeks">
                        </div>
                    </div>

                    <div class="col-8">
                        <div>
                            <label class="form-label col-form-label-sm">{{ $t('propose_days') }}:
                                <span v-for="day in booking.days">{{ $t(day) + ' ' }}</span>
                            </label>
                        </div>
                        <div class='weekdays'>
                            <div class='weekday' v-for='weekday in weekdayLabels'>
                                    <span v-if="checkWorkWeekDays()" class="work-day" v-on:click="addDays(weekday)">
                                    <span v-if="in_array(weekday, alternative.alternative_days)">+</span>
                                         {{ weekday }}
                                      </span>
                                <span v-else>{{ weekday }}</span>
                            </div>

                            <div class='weekday' v-for='weekend in weekendLabels'>
                                  <span v-if="checkWorkweekEnds()" class="work-day" v-on:click="addDays(weekend)">
                                    <span v-if="in_array(weekend, alternative.alternative_days)">+</span>
                                            {{ weekend }}
                                     </span>
                                <span v-else>{{ weekend }}</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-4">
                        {{ $t('total') + ': ' + alternative.alternative_total}}
                    </div>

                </div>
            </div>
            <div class="col-3">
                <div class="row">
                    <span>{{ $t('time_client_propose') }}</span>
                    <div class="col-12" v-for="time in booking.time">
                        {{ time.time_interval + ': ' + time.time + ' ' + $t('hours') }}
                    </div>

                </div>
                <div class="row">
                    {{ $t('your_alternative_time_propose') }}
                </div>
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
                               v-on:change="checkMultySelect('weekdays_7_11')"
                               v-bind:disabled="nurse.entity.work_time_pref.weekdays_7_11 === '0'"
                               v-model="alternative.alternative_time.time_interval['weekdays_7_11']">
                        &nbsp;<label for="weekdays_morning"></label>
                        <select class="form-control form-control-sm"
                                v-if="nurse.entity.work_time_pref.weekdays_7_11 === '1'"
                                v-model="alternative.alternative_time.time['weekdays_7_11']">
                            <option value="1" selected>1 h</option>
                            <option value="2">2 h</option>
                            <option value="3">3 h</option>
                            <option value="4">4 h</option>
                        </select>
                    </div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekends_morning" true-value="1" false-value="0"
                               v-on:change="checkMultySelect('weekends_7_11')"
                               v-bind:disabled="nurse.entity.work_time_pref.weekends_7_11 === '0'"
                               v-model="alternative.alternative_time.time_interval['weekends_7_11']">
                        &nbsp;<label for="weekends_morning"></label>
                        <select class="form-control form-control-sm"
                                v-if="nurse.entity.work_time_pref.weekends_7_11 === '1'"
                                v-model="alternative.alternative_time.time['weekends_7_11']">
                            <option value="1" selected>1 h</option>
                            <option value="2">2 h</option>
                            <option value="3">3 h</option>
                            <option value="4">4 h</option>
                        </select>
                    </div>
                </div>
                <!--                        11-14 Uhr  -->
                <div class="row">
                    <div class="col-4">11-14 Uhr</div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekdays_afternoon" true-value="1" false-value="0"
                               v-on:change="checkMultySelect('weekdays_11_14')"
                               v-bind:disabled="nurse.entity.work_time_pref.weekdays_11_14 === '0'"
                               v-model="alternative.alternative_time.time_interval['weekdays_11_14']">
                        &nbsp;<label for="weekdays_afternoon"></label>
                        <select class="form-control form-control-sm"
                                v-if="nurse.entity.work_time_pref.weekdays_11_14 === '1'"
                                v-model="alternative.alternative_time.time['weekdays_11_14']">
                            <option value="1" selected>1 h</option>
                            <option value="2">2 h</option>
                            <option value="3">3 h</option>
                        </select>
                    </div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekends_afternoon" true-value="1" false-value="0"
                               v-on:change="checkMultySelect('weekends_11_14')"
                               v-bind:disabled="nurse.entity.work_time_pref.weekends_11_14 === '0'"
                               v-model="alternative.alternative_time.time_interval['weekends_11_14']">
                        &nbsp;<label for="weekends_afternoon"></label>
                        <select class="form-control form-control-sm"
                                v-if="nurse.entity.work_time_pref.weekends_11_14 === '1'"
                                v-model="alternative.alternative_time.time['weekends_11_14']">
                            <option value="1" selected>1 h</option>
                            <option value="2">2 h</option>
                            <option value="3">3 h</option>
                        </select>
                    </div>
                </div>
                <!--                        14-17 Uhr -->
                <div class="row">
                    <div class="col-4">14-17 Uhr</div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekdays_evening" true-value="1" false-value="0"
                               v-on:change="checkMultySelect('weekdays_14_17')"
                               v-bind:disabled="nurse.entity.work_time_pref.weekdays_14_17 === '0'"
                               v-model="alternative.alternative_time.time_interval['weekdays_14_17']">
                        &nbsp;<label for="weekdays_evening"></label>
                        <select class="form-control form-control-sm"
                                v-if="nurse.entity.work_time_pref.weekdays_14_17 === '1'"
                                v-model="alternative.alternative_time.time['weekdays_14_17']">
                            <option value="1" selected>1 h</option>
                            <option value="2">2 h</option>
                            <option value="3">3 h</option>
                        </select>
                    </div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekends_evening" true-value="1" false-value="0"
                               v-on:change="checkMultySelect('weekends_14_17')"
                               v-bind:disabled="nurse.entity.work_time_pref.weekends_14_17 === '0'"
                               v-model="alternative.alternative_time.time_interval['weekends_14_17']">
                        &nbsp;<label for="weekends_evening"></label>
                        <select class="form-control form-control-sm"
                                v-if="nurse.entity.work_time_pref.weekends_14_17 === '1'"
                                v-model="alternative.alternative_time.time['weekends_14_17']">
                            <option value="1" selected>1 h</option>
                            <option value="2">2 h</option>
                            <option value="3">3 h</option>
                        </select>
                    </div>
                </div>
                <!--                        17-21 Uhr -->
                <div class="row">
                    <div class="col-4">17-21 Uhr</div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekdays_overnight" true-value="1" false-value="0"
                               v-on:change="checkMultySelect('weekdays_17_21')"
                               v-bind:disabled="nurse.entity.work_time_pref.weekdays_17_21 === '0'"
                               v-model="alternative.alternative_time.time_interval['weekdays_17_21']">
                        &nbsp;<label for="weekdays_overnight"></label>
                        <select class="form-control form-control-sm"
                                v-if="nurse.entity.work_time_pref.weekdays_17_21 === '1'"
                                v-model="alternative.alternative_time.time['weekdays_17_21']">
                            <option value="1" selected>1 h</option>
                            <option value="2">2 h</option>
                            <option value="3">3 h</option>
                            <option value="4">4 h</option>
                        </select>
                    </div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekends_overnight" true-value="1" false-value="0"
                               v-on:change="checkMultySelect('weekends_17_21')"
                               v-bind:disabled="nurse.entity.work_time_pref.weekends_17_21 === '0'"
                               v-model="alternative.alternative_time.time_interval['weekends_17_21']">
                        &nbsp;<label for="weekends_overnight"></label>
                        <select class="form-control form-control-sm"
                                v-if="nurse.entity.work_time_pref.weekends_17_21 === '1'"
                                v-model="alternative.alternative_time.time['weekends_17_21']">
                            <option value="1" selected>1 h</option>
                            <option value="2">2 h</option>
                            <option value="3">3 h</option>
                            <option value="4">4 h</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-6 offset-3">
                    <button class="btn btn-sm btn-success" v-on:click="sendAlternativeBooking()">{{ $t('send') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Alternative",
        props: ['booking', 'nurse'],
        data() {
            return {
                weekdayLabels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                weekendLabels: ['Saturday', 'Sunday'],
                alternative: {
                    booking_id: 0,
                    alternative_suggested_price_per_hour: 0,
                    alternative_total: 0,
                    alternative_one_time_or_regular: null,
                    alternative_start_date: null,
                    alternative_finish_date: null,
                    alternative_weeks: 0,
                    alternative_days: null,
                    comment: null,
                    alternative_time: {
                        time_interval: {},
                        time: {},
                    }
                },
                show_for_regular: false,
            }
        },
        watch: {
            nurse: {
                handler(newValue, oldValue) {
                    if(typeof this.nurse.entity.work_time_pref === 'string' ){
                        this.nurse.entity.work_time_pref = JSON.parse(this.nurse.entity.work_time_pref);
                    }
                },
                immediate: true,
            },
            booking: {
                handler(newValue, oldValue) {
                    this.alternative.booking_id = this.booking.id;
                    this.alternative.alternative_suggested_price_per_hour = this.booking.suggested_price_per_hour;
                    this.alternative.alternative_one_time_or_regular = this.booking.one_time_or_regular;
                    this.alternative.alternative_start_date = this.booking.start_date;
                    this.alternative.alternative_finish_date = this.booking.finish_date;
                    this.alternative.alternative_weeks = this.booking.weeks;
                    this.alternative.alternative_days = this.booking.days;
                    this.alternative.alternative_total = this.booking.total;
                    for(let i in this.booking.time){
                        this.alternative.alternative_time.time_interval[this.booking.time[i].time_interval] = '1';
                        this.alternative.alternative_time.time[this.booking.time[i].time_interval] = this.booking.time[i].time;
                    }
                    if (this.alternative.alternative_one_time_or_regular == 'regular') {
                        this.show_for_regular = true;
                    }
                },
                immediate: true,
            },

            alternative: {
                handler(newValue, oldValue) {
                    if (newValue.alternative_one_time_or_regular === 'regular') {
                        this.show_for_regular = true;
                    } else {
                        this.show_for_regular = false;
                    }

                    let hours = 0;
                    for (let index in newValue.alternative_time.time){
                        hours = hours + Number(newValue.alternative_time.time[index]);
                    }
                    this.alternative.alternative_total = hours * this.alternative.alternative_suggested_price_per_hour
                        * this.alternative.alternative_days.length;

                    if(newValue.alternative_one_time_or_regular === 'regular'){
                        this.alternative.alternative_total = this.alternative.alternative_total * this.alternative.alternative_weeks;
                    }

                },
                deep: true
            }
        },
        mounted() {
        },
        methods: {
            sendAlternativeBooking() {
                axios.post('/dashboard/nurse-bookings', { 'alternative' : this.alternative})
                .then((response) => {
                    if(response.data.success){
                        this.emitter.emit('close-alternative-booking-modal');
                        this.emitter.emit('response-success-true');
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
            },
            setIndex(index) {
                let modelIndex = this.alternative.alternative_time.filter((value) => {
                    if (value.time_interval === index) {
                        return true;
                    }
                });
                let i = this.alternative.alternative_time.indexOf(modelIndex[0]);
                return i;
            },
            addDays(day) {
                if (this.in_array(day, this.alternative.alternative_days)) {
                    let evens = _.remove(this.alternative.alternative_days,
                        function (n) {
                            return n === day;
                        });
                    this.alternative.alternative_days = evens;
                } else {
                    this.alternative.alternative_days.push(day);
                }
            },
            checkWorkWeekDays() {
                if (this.nurse.entity.work_time_pref.weekdays_7_11 === "1" ||
                    this.nurse.entity.work_time_pref.weekdays_11_14 === "1" ||
                    this.nurse.entity.work_time_pref.weekdays_14_17 === "1" ||
                    this.nurse.entity.work_time_pref.weekdays_17_21 === "1") {
                    return true;
                }
            },
            checkWorkweekEnds() {
                if (this.nurse.entity.work_time_pref.weekends_7_11 === "1" ||
                    this.nurse.entity.work_time_pref.weekends_11_14 === "1" ||
                    this.nurse.entity.work_time_pref.weekends_14_17 === "1" ||
                    this.nurse.entity.work_time_pref.weekends_17_21 === "1") {
                    return true;
                }
            },
            in_array(needle, haystack, strict) {
                var found = false, key, strict = !!strict;
                for (key in haystack) {
                    if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
                        found = true;
                        break;
                    }
                }
                return found;
            },
            checkMultySelect(index) {
                if (this.nurse.entity.multiple_bookings === 'no') {
                    this.alternative.alternative_time.time_interval = {};
                    this.alternative.alternative_time.time = {};
                    this.alternative.alternative_time.time_interval[index] = "1";
                }

                if (this.alternative.alternative_time.time[index] !== undefined) {
                    this.alternative.alternative_time.time[index] = "0";
                }

                if (this.alternative.alternative_time.time[index] !== undefined && this.alternative.alternative_time.time_interval[index] === "1") {
                    this.alternative.alternative_time.time[index] = "1";
                }

                if (this.alternative.alternative_time.time[index] === undefined) {
                    this.alternative.alternative_time.time[index] = "1";
                }
            },
        }
    }
</script>

<style scoped>
    .weekdays {
        display: flex;
        flex: auto;
    }

    .weekday {
        width: 14.2857%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0.4rem 0;
        color: #aaaaaa;
        border: 1px solid #aaaaaa;
        background-color: #eaeaea;
    }

    .work-day {
        cursor: pointer;
        color: #0a58ca;
    }
</style>
