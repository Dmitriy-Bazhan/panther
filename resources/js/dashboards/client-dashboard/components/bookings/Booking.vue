<template>
    <div class="row">
        <div class="col-8">
            <div class="row">
                <div class="col-3">
                    <label for="suggested_price_per_hour" class="form-label col-form-label-sm">{{
                        $t('suggested_price_per_hour') }}</label>
                    <input id="suggested_price_per_hour" class="form-control form-control-sm"
                           type="number" v-model="booking.suggested_price_per_hour" v-on:change="changeWeek()">
                </div>
                <div class="col-3">
                    <label for="additional_email" class="form-label col-form-label-sm">{{
                        $t('additional_email') }}</label>
                    <input type="email" class="form-control form-control-sm"
                           id="additional_email"
                           v-model="booking.additional_email">
                </div>
                <div class="col-3">
                    <label for="start_date" class="form-label col-form-label-sm">{{
                        $t('start_date') }}</label>
                    <input type="date" class="form-control form-control-sm"
                           id="start_date"
                           v-model="booking.start_date">
                </div>
                <div class="col-3">
                    <label for="one_time_or_regular" class="form-label col-form-label-sm">{{ $t('one_time_or_regular')
                        }}</label>
                    <select id="one_time_or_regular" class="form-control form-control-sm"
                            v-model="booking.one_time_or_regular" v-on:change="changeRegularOrOne()">
                        <option value="one">{{ $t('one') }}</option>
                        <option value="regular">{{ $t('regular') }}</option>
                    </select>
                </div>
            </div>

            <br>
            <div class="row" v-if="show_for_regular">
                <div class="col-4">
                    <label class="form-label col-form-label-sm">{{ $t('weeks') }}</label>
                    <input type="number" min="1" class="form-control form-control-sm"
                           v-model="booking.weeks" v-on:change="changeWeek()">
                </div>

                <div class="col-8">
                    <br>
                    <div class='weekdays'>
                        <div class='weekday' v-for='weekday in weekdayLabels'>
                                    <span v-if="checkWorkWeekDays()" class="work-day" v-on:click="addDays(weekday)">
                                    <span v-if="in_array(weekday, booking.days)">+</span>
                                         {{ weekday }}
                                      </span>
                            <span v-else>{{ weekday }}</span>
                        </div>

                        <div class='weekday' v-for='weekend in weekendLabels'>
                                  <span v-if="checkWorkweekEnds()" class="work-day" v-on:click="addDays(weekend)">
                                    <span v-if="in_array(weekend, booking.days)">+</span>
                                            {{ weekend }}
                                     </span>
                            <span v-else>{{ weekend }}</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-4">
                    {{ $t('total') + ': ' + booking.total}}
                </div>

            </div>
        </div>
        <div class="col-4">
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
                           v-bind:disabled="booking.nurse.entity.work_time_pref.weekdays_7_11 === '0'"
                           v-model="time.time_interval['weekdays_7_11']">
                    &nbsp;<label for="weekdays_morning"></label>
                    <select class="form-control form-control-sm"
                            v-if="booking.nurse.entity.work_time_pref.weekdays_7_11 === '1'"
                            v-model="time.time['weekdays_7_11']">
                        <option value="1" selected>1 h</option>
                        <option value="2">2 h</option>
                        <option value="3">3 h</option>
                        <option value="4">4 h</option>
                    </select>
                </div>
                <div class="col-4 justify-content-center">
                    <input type="checkbox" id="weekends_morning" true-value="1" false-value="0"
                           v-on:change="checkMultySelect('weekends_7_11')"
                           v-bind:disabled="booking.nurse.entity.work_time_pref.weekends_7_11 === '0'"
                           v-model="time.time_interval['weekends_7_11']">
                    &nbsp;<label for="weekends_morning"></label>
                    <select class="form-control form-control-sm"
                            v-if="booking.nurse.entity.work_time_pref.weekends_7_11 === '1'"
                            v-model="time.time['weekends_7_11']">
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
                           v-bind:disabled="booking.nurse.entity.work_time_pref.weekdays_11_14 === '0'"
                           v-model="time.time_interval['weekdays_11_14']">
                    &nbsp;<label for="weekdays_afternoon"></label>
                    <select class="form-control form-control-sm"
                            v-if="booking.nurse.entity.work_time_pref.weekdays_11_14 === '1'"
                            v-model="time.time['weekdays_11_14']">
                        <option value="1" selected>1 h</option>
                        <option value="2">2 h</option>
                        <option value="3">3 h</option>
                    </select>
                </div>
                <div class="col-4 justify-content-center">
                    <input type="checkbox" id="weekends_afternoon" true-value="1" false-value="0"
                           v-on:change="checkMultySelect('weekends_11_14')"
                           v-bind:disabled="booking.nurse.entity.work_time_pref.weekends_11_14 === '0'"
                           v-model="time.time_interval['weekends_11_14']">
                    &nbsp;<label for="weekends_afternoon"></label>
                    <select class="form-control form-control-sm"
                            v-if="booking.nurse.entity.work_time_pref.weekends_11_14 === '1'"
                            v-model="time.time['weekends_11_14']">
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
                           v-bind:disabled="booking.nurse.entity.work_time_pref.weekdays_14_17 === '0'"
                           v-model="time.time_interval['weekdays_14_17']">
                    &nbsp;<label for="weekdays_evening"></label>
                    <select class="form-control form-control-sm"
                            v-if="booking.nurse.entity.work_time_pref.weekdays_14_17 === '1'"
                            v-model="time.time['weekdays_14_17']">
                        <option value="1" selected>1 h</option>
                        <option value="2">2 h</option>
                        <option value="3">3 h</option>
                    </select>
                </div>
                <div class="col-4 justify-content-center">
                    <input type="checkbox" id="weekends_evening" true-value="1" false-value="0"
                           v-on:change="checkMultySelect('weekends_14_17')"
                           v-bind:disabled="booking.nurse.entity.work_time_pref.weekends_14_17 === '0'"
                           v-model="time.time_interval['weekends_14_17']">
                    &nbsp;<label for="weekends_evening"></label>
                    <select class="form-control form-control-sm"
                            v-if="booking.nurse.entity.work_time_pref.weekends_14_17 === '1'"
                            v-model="time.time['weekends_14_17']">
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
                           v-bind:disabled="booking.nurse.entity.work_time_pref.weekdays_17_21 === '0'"
                           v-model="time.time_interval['weekdays_17_21']">
                    &nbsp;<label for="weekdays_overnight"></label>
                    <select class="form-control form-control-sm"
                            v-if="booking.nurse.entity.work_time_pref.weekdays_17_21 === '1'"
                            v-model="time.time['weekdays_17_21']">
                        <option value="1" selected>1 h</option>
                        <option value="2">2 h</option>
                        <option value="3">3 h</option>
                        <option value="4">4 h</option>
                    </select>
                </div>
                <div class="col-4 justify-content-center">
                    <input type="checkbox" id="weekends_overnight" true-value="1" false-value="0"
                           v-on:change="checkMultySelect('weekends_17_21')"
                           v-bind:disabled="booking.nurse.entity.work_time_pref.weekends_17_21 === '0'"
                           v-model="time.time_interval['weekends_17_21']">
                    &nbsp;<label for="weekends_overnight"></label>
                    <select class="form-control form-control-sm"
                            v-if="booking.nurse.entity.work_time_pref.weekends_17_21 === '1'"
                            v-model="time.time['weekends_17_21']">
                        <option value="1" selected>1 h</option>
                        <option value="2">2 h</option>
                        <option value="3">3 h</option>
                        <option value="4">4 h</option>
                    </select>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Booking",
        props: ['booking'],
        data() {
            return {
                weekdayLabels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                weekendLabels: ['Saturday', 'Sunday'],
                show_for_regular: false,
                time: {
                    time_interval: {},
                    time: {}
                }
            }
        },
        watch: {
            booking: {
                handler(newValue, oldValue) {
                    for (let i in this.booking.time) {
                        this.time.time_interval[this.booking.time[i].time_interval] = '1';
                        this.time.time[this.booking.time[i].time_interval] = this.booking.time[i].time;
                    }
                    if (this.booking.one_time_or_regular == 'regular') {
                        this.show_for_regular = true;
                    }
                    if (typeof this.booking.nurse.entity.work_time_pref === 'string') {
                        this.booking.nurse.entity.work_time_pref = JSON.parse(this.booking.nurse.entity.work_time_pref);
                    }
                    this.booking.new_time = this.time;
                },
                immediate: true,
            },
            time: {
                handler(newValue, oldValue) {
                    this.booking.new_time = this.time;
                    this.countTotal();

                },
                deep: true,
            }
        },
        mounted() {
            console.log(this.booking);
            console.log(this.time);
        },
        methods: {
            changeRegularOrOne() {
                if (this.booking.one_time_or_regular == 'regular') {
                    this.show_for_regular = true;
                } else {
                    this.show_for_regular = false;
                }
                this.countTotal();
            },
            changeWeek() {
                this.countTotal();
            },
            addDays(day) {
                if (this.in_array(day, this.booking.days)) {
                    let evens = _.remove(this.booking.days,
                        function (n) {
                            return n === day;
                        });
                    this.booking.days = evens;
                } else {
                    this.booking.days.push(day);
                }
                this.countTotal();
            },
            checkWorkWeekDays() {
                if (this.booking.nurse.entity.work_time_pref.weekdays_7_11 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekdays_11_14 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekdays_14_17 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekdays_17_21 === "1") {
                    return true;
                }
            },
            checkWorkweekEnds() {
                if (this.booking.nurse.entity.work_time_pref.weekends_7_11 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekends_11_14 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekends_14_17 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekends_17_21 === "1") {
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
                if (this.booking.nurse.entity.multiple_bookings === 'no') {
                    this.time.time_interval = {};
                    this.time.time = {};
                    this.time.time_interval[index] = "1";
                }

                if (this.time.time[index] !== undefined) {
                    this.time.time[index] = "0";
                }

                if (this.time.time[index] !== undefined && this.time.time_interval[index] === "1") {
                    this.time.time[index] = "1";
                }

                if (this.time.time[index] === undefined) {
                    this.time.time[index] = "1";
                }
            },

            countTotal() {
                let hours = 0;
                for (let index in this.time.time) {
                    hours = hours + Number(this.time.time[index]);
                }

                this.booking.total = hours * this.booking.suggested_price_per_hour;

                if (this.booking.one_time_or_regular == 'regular') {
                    this.booking.total = this.booking.total * this.booking.days.length;
                    this.booking.total = this.booking.total * this.booking.weeks;
                }
            }
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
        padding: 0.2rem 0;
        color: #aaaaaa;
        border: 1px solid #aaaaaa;
        background-color: #eaeaea;
    }

    .work-day {
        cursor: pointer;
        color: #0a58ca;
    }
</style>
