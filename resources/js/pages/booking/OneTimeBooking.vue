<template>
    <div>
        <nurse_info :data="data"></nurse_info>
        <br>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class='calendar'>
                        <div class='header'>
                            <a class='arrow' @click='movePreviousYear'>&laquo;</a>
                            <a class='arrow' @click='movePreviousMonth'>&lsaquo;</a>
                            <span class='title' @click='moveThisMonth'>{{ header.label }}</span>
                            <a class='arrow' @click='moveNextMonth'>&rsaquo;</a>
                            <a class='arrow' @click='moveNextYear'>&raquo;</a>
                        </div>
                        <div class='weekdays'>
                            <div class='weekday' v-for='weekday in weekdays'>
                                {{ weekday.label }}
                            </div>
                        </div>
                        <div class='week' v-for='week in weeks'>
                            <div class='day'
                                 :class='{ today: day.isToday, checkday: checkDate === year + "-" + month + "-" + day.number }'
                                 v-for='day in week'>
                                <span class="day-content" v-on:click="selectDate(day)">{{ day.label }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4" v-if="showTimeIntervalWindow">

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
            </div>
        </div>
        <br>
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

    // Calendar data
    const _daysInMonths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    const _weekdayLabels = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const _weekdayLength = 3;
    const _weekdayCasing = 'title';
    const _monthLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const _monthLength = 0;
    const _monthCasing = 'title';

    // Helper function for label transformation
    const _transformLabel = (label, length, casing) => {
        label = length <= 0 ? label : label.substring(0, length);
        if (casing.toLowerCase() === 'lower') return label.toLowerCase();
        if (casing.toLowerCase() === 'upper') return label.toUpperCase();
        return label;
    };

    // Today's data
    const _today = new Date();
    const _todayComps = {
        year: _today.getFullYear(),
        month: _today.getMonth() + 1,
        day: _today.getDate(),
    };

    export default {
        name: "OneTimeBooking",
        props: ['data'],
        data() {
            return {
                month: _todayComps.month,
                year: _todayComps.year,
                checkDate: null,
                showTimeIntervalWindow: false,
                booking: {
                    total: 0,
                    suggested_price_per_hour: 0,
                    date: null,
                    additional_email: null,
                    comment: null,
                    time_interval: {
                    },
                    time: {
                    },
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
                    this.booking.total = hours * this.booking.suggested_price_per_hour;
                },
                deep: true,
            }
        },
        components: {
            'nurse_info': NurseInfo,
        },
        computed: {
            monthIndex() {
                return this.month - 1;
            },
            // State referenced by header (no dependencies yet...)
            months() {
                return _monthLabels.map((ml, i) => ({
                    label: _transformLabel(ml, _monthLength, _monthCasing),
                    number: i + 1,
                }));
            },
            // State for weekday header (no dependencies yet...)
            weekdays() {
                return _weekdayLabels.map((wl, i) => {
                    return {
                        label: _transformLabel(wl, _weekdayLength, _weekdayCasing),
                        number: i + 1,
                    };
                });
            },
            // State for calendar header
            header() {
                const month = this.months[this.monthIndex];
                return {
                    month,
                    year: this.year.toString(),
                    shortYear: this.year.toString().substring(2, 4),
                    label: month.label + ' ' + this.year,
                };
            },
            // Returns number for first weekday (1-7), starting from Sunday
            firstWeekdayInMonth() {
                return new Date(this.year, this.monthIndex, 1).getDay() + 1;
            },
            // Returns number of days in the current month
            daysInMonth() {
                // Check for February in a leap year
                const isFebruary = this.month === 2;
                const isLeapYear = (this.year % 4 == 0 && this.year % 100 != 0) || this.year % 400 == 0;
                if (isFebruary && isLeapYear) return 29;
                // ...Just a normal month
                return _daysInMonths[this.monthIndex];
            },
            weeks() {
                const weeks = [];
                let monthStarted = false, monthEnded = false;
                let monthDay = 0;
                // Cycle through each week of the month, up to 6 total
                for (let w = 1; w <= 6 && !monthEnded; w++) {
                    // Cycle through each weekday
                    const week = [];
                    for (let d = 1; d <= 7; d++) {
                        // We need to know when to start counting actual month days
                        if (!monthStarted && d >= this.firstWeekdayInMonth) {
                            // Initialize day counter
                            monthDay = 1;
                            // ...and flag we're tracking actual month days
                            monthStarted = true;
                            // Still in the middle of the month (hasn't ended yet)
                        } else if (monthStarted && !monthEnded) {
                            // Increment the day counter
                            monthDay += 1;
                        }
                        // Append day info for the current week
                        // Note: this might or might not be an actual month day
                        //  We don't know how the UI wants to display various days,
                        //  so we'll supply all the data we can
                        week.push({
                            label: monthDay ? monthDay.toString() : '',
                            number: monthDay,
                            weekdayNumber: d,
                            weekNumber: w,
                            beforeMonth: !monthStarted,
                            afterMonth: monthEnded,
                            inMonth: monthStarted && !monthEnded,
                            isToday: monthDay === _todayComps.day && this.month === _todayComps.month && this.year === _todayComps.year,
                            isFirstDay: monthDay === 1,
                            isLastDay: monthDay === this.daysInMonth,
                        });

                        // Trigger end of month on the last day
                        if (monthStarted && !monthEnded && monthDay >= this.daysInMonth) {
                            monthDay = 0;
                            monthEnded = true;
                        }
                    }
                    // Append week info for the month
                    weeks.push(week);
                }
                return weeks;
            },
        },
        methods: {
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
            sendBooking() {
                axios.post('/booking', {'booking': this.booking, 'nurse_user_id' : this.data.nurse.id , 'one_time_or_regular': 'one_time'})
                    .then((response) => {
                        if(response.data.success){
                            window.location.href = '/send-booking-message';
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            selectDate(current_day) {
                let day = String(current_day.number).length === 1 ? day = '0' + current_day.number : current_day.number;
                let month = String(this.month).length === 1 ? month = '0' + this.month : this.month;
                this.booking.date = this.year + '-' + month + '-' + day;
                this.checkDate = this.year + '-' + this.month + '-' + current_day.number;
                console.log(this.booking.date);
                this.showTimeIntervalWindow = true;
            },
            moveThisMonth() {
                this.month = _todayComps.month;
                this.year = _todayComps.year;
            },
            moveNextMonth() {
                if (this.month < 12) {
                    this.month++;
                } else {
                    this.month = 1;
                    this.year++;
                }
            },
            movePreviousMonth() {
                if (this.month > 1) {
                    this.month--;
                } else {
                    this.month = 12;
                    this.year--;
                }
            },
            moveNextYear() {
                this.year++;
            },
            movePreviousYear() {
                this.year--;
            },
        },
    }
</script>

<style scoped>
    .calendar {
        display: flex;
        flex-direction: column;
    }

    .header {
        display: flex;
        justify-content: stretch;
        align-items: center;
        color: white;
        padding: 0.5rem 1rem;
        border-width: 1px;
        border-style: solid;
        border-color: #aaaaaa;
        background-color: #ff7a58;
    }

    .arrow {
        cursor: pointer;
        padding: 0 0.4em 0.2em 0.4em;
        font-size: 1.8rem;
        font-weight: 500;
        user-select: none;
        flex-grow: 0;
    }

    .arrow:hover {
        color: #dcdcdc;
    }

    .title {
        cursor: pointer;
        flex-grow: 1;
        font-size: 1.2rem;
        text-align: center;
    }

    .title:hover {
        color: #dcdcdc;
    }

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

    .week {
        display: flex;
    }

    .day {
        width: 14.2857%;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #3a3a3a;
        background-color: white;
        border: solid 1px #aaaaaa;
    }

    .today {
        font-weight: 500;
        color: white;
        background-color: #ff7a58;
    }

    .checkday {
        font-weight: 500;
        color: white;
        background-color: #1b40ff;

    }

    .day-content {
        cursor: pointer;
    }

    .label-name {
        font-size: 14px;
        font-weight: 700;
    }
</style>
