<template>
    <div>
        <h1>REGULAR</h1>


        <nurse_info :data="data"></nurse_info>

        <div class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <label for="suggested_price_per_hour" class="form-label col-form-label-sm label-name">{{
                        $t('suggested_price_per_hour') }}</label>
                </div>
                <div class="col-1">
                    <input type="number" class="form-control form-control-sm"
                           id="suggested_price_per_hour" min="10"
                           v-model="booking.suggested_price_per_hour">
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="additional_email" class="form-label col-form-label-sm label-name">{{
                        $t('additional_email') }}</label>
                </div>
                <div class="col-4">
                    <input type="email" class="form-control form-control-sm"
                           id="additional_email" min="10"
                           v-model="booking.additional_email">
                </div>
                <div class="col-3 offset-2">
                    <span>Total: {{ booking.total }} EUR</span>
                </div>
            </div>
        </div>

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

        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <label for="date" class="form-label col-form-label-sm">{{ $t('date') }}</label>
                    <input type="date" id="date" class="form-control form-control-sm" v-model="booking.date">
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
                                   v-bind:disabled="data.nurse.entity.work_time_pref.weekdays_7_11 === '0'"
                                   v-model="booking.time_interval['weekdays_7_11']">
                            &nbsp;<label for="weekdays_morning"></label>
                            <select class="form-control form-control-sm"
                                    v-if="data.nurse.entity.work_time_pref.weekdays_7_11 === '1'"
                                    v-model="booking.time['weekdays_7_11']">
                                <option value="1" selected>1 h</option>
                                <option value="2">2 h</option>
                                <option value="3">3 h</option>
                                <option value="4">4 h</option>
                            </select>
                        </div>
                        <div class="col-4 justify-content-center">
                            <input type="checkbox" id="weekends_morning" true-value="1" false-value="0"
                                   v-on:change="checkMultySelect('weekends_7_11')"
                                   v-bind:disabled="data.nurse.entity.work_time_pref.weekends_7_11 === '0'"
                                   v-model="booking.time_interval['weekends_7_11']">
                            &nbsp;<label for="weekends_morning"></label>
                            <select class="form-control form-control-sm"
                                    v-if="data.nurse.entity.work_time_pref.weekends_7_11 === '1'"
                                    v-model="booking.time['weekends_7_11']">
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
                                   v-bind:disabled="data.nurse.entity.work_time_pref.weekdays_11_14 === '0'"
                                   v-model="booking.time_interval['weekdays_11_14']">
                            &nbsp;<label for="weekdays_afternoon"></label>
                            <select class="form-control form-control-sm"
                                    v-if="data.nurse.entity.work_time_pref.weekdays_11_14 === '1'"
                                    v-model="booking.time['weekdays_11_14']">
                                <option value="1" selected>1 h</option>
                                <option value="2">2 h</option>
                                <option value="3">3 h</option>
                            </select>
                        </div>
                        <div class="col-4 justify-content-center">
                            <input type="checkbox" id="weekends_afternoon" true-value="1" false-value="0"
                                   v-on:change="checkMultySelect('weekends_11_14')"
                                   v-bind:disabled="data.nurse.entity.work_time_pref.weekends_11_14 === '0'"
                                   v-model="booking.time_interval['weekends_11_14']">
                            &nbsp;<label for="weekends_afternoon"></label>
                            <select class="form-control form-control-sm"
                                    v-if="data.nurse.entity.work_time_pref.weekends_11_14 === '1'"
                                    v-model="booking.time['weekends_11_14']">
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
                                   v-bind:disabled="data.nurse.entity.work_time_pref.weekdays_14_17 === '0'"
                                   v-model="booking.time_interval['weekdays_14_17']">
                            &nbsp;<label for="weekdays_evening"></label>
                            <select class="form-control form-control-sm"
                                    v-if="data.nurse.entity.work_time_pref.weekdays_14_17 === '1'"
                                    v-model="booking.time['weekdays_14_17']">
                                <option value="1" selected>1 h</option>
                                <option value="2">2 h</option>
                                <option value="3">3 h</option>
                            </select>
                        </div>
                        <div class="col-4 justify-content-center">
                            <input type="checkbox" id="weekends_evening" true-value="1" false-value="0"
                                   v-on:change="checkMultySelect('weekends_14_17')"
                                   v-bind:disabled="data.nurse.entity.work_time_pref.weekends_14_17 === '0'"
                                   v-model="booking.time_interval['weekends_14_17']">
                            &nbsp;<label for="weekends_evening"></label>
                            <select class="form-control form-control-sm"
                                    v-if="data.nurse.entity.work_time_pref.weekends_14_17 === '1'"
                                    v-model="booking.time['weekends_14_17']">
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
                                   v-bind:disabled="data.nurse.entity.work_time_pref.weekdays_17_21 === '0'"
                                   v-model="booking.time_interval['weekdays_17_21']">
                            &nbsp;<label for="weekdays_overnight"></label>
                            <select class="form-control form-control-sm"
                                    v-if="data.nurse.entity.work_time_pref.weekdays_17_21 === '1'"
                                    v-model="booking.time['weekdays_17_21']">
                                <option value="1" selected>1 h</option>
                                <option value="2">2 h</option>
                                <option value="3">3 h</option>
                                <option value="4">4 h</option>
                            </select>
                        </div>
                        <div class="col-4 justify-content-center">
                            <input type="checkbox" id="weekends_overnight" true-value="1" false-value="0"
                                   v-on:change="checkMultySelect('weekends_17_21')"
                                   v-bind:disabled="data.nurse.entity.work_time_pref.weekends_17_21 === '0'"
                                   v-model="booking.time_interval['weekends_17_21']">
                            &nbsp;<label for="weekends_overnight"></label>
                            <select class="form-control form-control-sm"
                                    v-if="data.nurse.entity.work_time_pref.weekends_17_21 === '1'"
                                    v-model="booking.time['weekends_17_21']">
                                <option value="1" selected>1 h</option>
                                <option value="2">2 h</option>
                                <option value="3">3 h</option>
                                <option value="4">4 h</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="col-2">
                    <label for="weeks" class="form-label col-form-label-sm">{{ $t('weeks') }}</label>
                    <input type="number" id="weeks" class="form-control form-control-sm" v-model="booking.weeks"
                           min="0">
                </div>

            </div>

        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <label for="comment" class="form-label col-form-label-sm label-name">{{
                        $t('comment') }}</label>
                </div>
                <div class="col-4">
                    <textarea class="form-control form-control-sm"
                              id="comment" v-model="booking.comment"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-2 offset-10">
                    <button class="btn btn-success btn-sm" v-on:click="sendBooking()">{{ $t('send') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import NurseInfo from "./NurseInfo";


    export default {
        name: "RegularBooking",
        props: ['data'],
        components: {
            'nurse_info': NurseInfo,
        },
        data() {
            return {
                weekdayLabels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                weekendLabels: ['Saturday', 'Sunday'],
                booking: {
                    total: 0,
                    suggested_price_per_hour: 0,
                    additional_email: null,
                    days: [],
                    date: null,
                    weeks: 1,
                    time_interval: {},
                    time: {},
                    comment: null,
                }
            }
        },
        watch: {
            data: {
                handler(newValue, oldValue) {
                    if (typeof this.data.nurse.entity.work_time_pref === "string") {
                        this.data.nurse.entity.work_time_pref = JSON.parse(this.data.nurse.entity.work_time_pref);
                    }
                    this.booking.suggested_price_per_hour = this.data.nurse.entity.price.hourly_payment;
                },
                immediate: true
            },
            booking: {
                handler(newValue, oldValue) {
                    let hours = 0;
                    for (let index in newValue.time){
                        hours = hours + Number(newValue.time[index]);
                    }
                    this.booking.total = hours * this.booking.suggested_price_per_hour * this.booking.weeks * this.booking.days.length;
                },
                deep: true,
            }
        },
        mounted() {

        },
        methods: {
            sendBooking() {
                console.log(this.booking);
                axios.post('/booking', {
                    'booking': this.booking,
                    'nurse_user_id': this.data.nurse.id,
                    'one_time_or_regular': 'regular'
                })
                    .then((response) => {
                        if (response.data.success) {
                            window.location.href = '/send-booking-message';
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
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
            },
            checkWorkWeekDays() {
                if (this.data.nurse.entity.work_time_pref.weekdays_7_11 === "1" ||
                    this.data.nurse.entity.work_time_pref.weekdays_11_14 === "1" ||
                    this.data.nurse.entity.work_time_pref.weekdays_14_17 === "1" ||
                    this.data.nurse.entity.work_time_pref.weekdays_17_21 === "1") {
                    return true;
                }
            },
            checkWorkweekEnds() {
                if (this.data.nurse.entity.work_time_pref.weekends_7_11 === "1" ||
                    this.data.nurse.entity.work_time_pref.weekends_11_14 === "1" ||
                    this.data.nurse.entity.work_time_pref.weekends_14_17 === "1" ||
                    this.data.nurse.entity.work_time_pref.weekends_17_21 === "1") {
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
                if (this.data.nurse.entity.multiple_bookings === 'no') {
                    this.booking.time_interval = {};
                    this.booking.time = {};
                    this.booking.time_interval[index] = "1";
                }

                if (this.booking.time[index] !== undefined) {
                    this.booking.time[index] = "0";
                }

                if (this.booking.time[index] !== undefined && this.booking.time_interval[index] === "1") {
                    this.booking.time[index] = "1";
                }

                if (this.booking.time[index] === undefined) {
                    this.booking.time[index] = "1";
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
