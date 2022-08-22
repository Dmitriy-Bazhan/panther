<template>
    <div v-if="booking">
        <div class="pt-finder--form-block">
            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    {{ $t('suggested_price_per_hour') }}
                </p>
                <pt-input type="number" :modelValue="booking.suggested_price_per_hour"
                          icon="user"
                          v-on:change="changeWeek()"
                          @update:modelValue="newValue => booking.suggested_price_per_hour = newValue"
                ></pt-input>
            </div>

            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    {{ $t('additional_email') }}
                </p>
                <pt-input type="text" :modelValue="booking.additional_email"
                          icon="email"
                          @update:modelValue="newValue => booking.additional_email = newValue"
                ></pt-input>
            </div>

            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    {{ $t('start_date') }}
                </p>
                <div class="pt-select">
                    <div class="pt-select--icon">
                        <pt-icon type="calendar"></pt-icon>
                    </div>
                    <Datepicker  format="dd.MM.yyyy" v-model="booking.start_date" autoApply></Datepicker>
                    <span class="pt-select--caret"></span>
                </div>
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
                              :options="[$t('one'), $t('regular')]"
                              v-model="booking.one_time_or_regular"
                    >

                        <template #open-indicator>
                            <span class="pt-select--caret"></span>
                        </template>
                    </v-select>
                </div>
            </div>
        </div>

        <template v-if="show_for_regular">
            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    {{ $t('weeks') }}
                </p>
                <pt-input type="number" :modelValue="booking.weeks"
                          icon="user"
                          v-on:change="changeWeek()"
                          @update:modelValue="newValue => booking.weeks = newValue"
                ></pt-input>
            </div>

            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    {{ $t('days') }}
                </p>
                <div class="">
                    <template v-for="(item, key) in weekdayLabels" v-if="checkWorkWeekDays()">
                        <label class="pt-checkbox">
                            <input type="checkbox" name="work_time_pref"
                                   :checked="in_array(key, this.booking.days)"
                                   :value="key"
                                   @change="addDays(key)">
                            <span class="pt-checkbox--body">{{ item }}</span>
                        </label>
                    </template>
                    <template v-for="(item, key) in weekendLabels" v-if="checkWorkweekEnds()">
                        <label class="pt-checkbox">
                            <input type="checkbox" name="work_time_pref"
                                   :checked="in_array(key, this.booking.days)"
                                   :value="key"
                                   @change="addDays(key)">
                            <span class="pt-checkbox--body">{{ item }}</span>
                        </label>
                    </template>
                </div>
            </div>
        </template>

        <div class="row">
            <div class="col-4">
                {{ $t('total') + ': ' + booking.total }}
            </div>

        </div>




        <div class="pt-finder--form-block"  v-if="checkWorkWeekDays()">
            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    verfügbare Zeit:
                </p>
                <div class="">
                    <template v-for="item in data.time_intervals">
                        <label class="pt-checkbox" v-if="item.type === 'weekdays'">
                            <input type="checkbox" name="work_time_pref"
                                   true-value="1" false-value="0"
                                   @change="setIntervals"
                                   v-model="booking.time_interval[item.id]">
                            <span class="pt-checkbox--body">{{ item.interval }}</span>
                        </label>
                    </template>
                </div>
            </div>

            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    Geben Sie die Anzahl der Stunden ein:
                </p>
                <div class="">
                    <template v-for="(item, index) in intervals">
                        <label class="pt-checkbox">
                            <input type="checkbox" name="work_time_pref"
                                   :value="item"
                                   v-model="booking.week_days_checked"
                                   v-on:change="getTotalPrice()">
                            <span class="pt-checkbox--body">{{ item.val }}</span>
                        </label>
                    </template>
                </div>
            </div>
        </div>


        <div class="pt-finder--form-block" v-if="checkWorkweekEnds()">
            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    verfügbare Zeit: (weekends)
                </p>
                <div class="">
                    <template v-for="item in data.time_intervals">
                        <label class="pt-checkbox" v-if="item.type === 'weekends'">
                            <input type="checkbox" name="work_time_pref"
                                   true-value="1" false-value="0"
                                   @change="setIntervals"
                                   v-model="booking.time_interval[item.id]">
                            <span class="pt-checkbox--body">{{ item.interval }}</span>
                        </label>
                    </template>
                </div>
            </div>
            <div class="pt-finder--form-group">
                <p class="pt-form--label">
                    Geben Sie die Anzahl der Stunden ein: (weekends)
                </p>
                <div class="">
                    <template v-for="item in weekends_intervals">
                        <label class="pt-checkbox">
                            <input type="checkbox" name="work_time_pref"
                                   :value="item"
                                   v-model="booking.week_ends_checked" v-on:change="getTotalPrice()">
                            <span class="pt-checkbox--body">{{ item.val }}</span>
                        </label>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BookingEdit",
        props: ['data', 'inner_booking'],
        data() {
            return {
                weekdayLabels: {
                    1: 'Monday',
                    2: 'Tuesday',
                    3: 'Wednesday',
                    4: 'Thursday',
                    5: 'Friday'
                },
                weekendLabels: {
                    6: 'Saturday',
                    7: 'Sunday'
                },
                show_for_regular: false,
                intervals: false,
                weekends_intervals: false,
                show_week_days_interval: true,
                show_week_ends_interval: true,
                booking: false,
            }
        },
        watch: {
            booking: {
                handler(newValue, oldValue) {
                    if (this.inner_booking.one_time_or_regular == 'regular') {
                        this.show_for_regular = true;
                    }
                    if (typeof this.inner_booking.nurse.entity.work_time_pref === 'string') {
                        this.inner_booking.nurse.entity.work_time_pref = JSON.parse(this.inner_booking.nurse.entity.work_time_pref);
                    }
                },
                immediate: true,
            }
        },
        mounted() {
            this.booking = {...this.inner_booking};

            this.booking.time_interval = this.booking.nurse.entity.work_time_pref;
            this.setIntervals();
            this.booking.week_days_checked = [];
            this.booking.week_ends_checked = [];
            for (let i in this.intervals) {
                let time = this.booking.time.filter(($value) => {
                    if ($value.time == this.intervals[i].val && $value.time_interval == this.intervals[i].id) {
                        return true;
                    }
                });
                if (time.length > 0) {
                    let obj = {
                        id: this.intervals[i].id,
                        val: this.intervals[i].val
                    }
                    this.booking.week_days_checked.push(obj);
                }
            }

            for (let i in this.weekends_intervals) {
                let time = this.booking.time.filter(($value) => {
                    if ($value.time == this.weekends_intervals[i].val && $value.time_interval == this.weekends_intervals[i].id) {
                        return true;
                    }
                });
                let obj = {
                    id: this.weekends_intervals[i].id,
                    val: this.weekends_intervals[i].val
                }

                if (time.length > 0) {
                    this.booking.week_ends_checked.push(obj);
                }
            }
            if(this.booking.one_time_or_regular == 'regular'){
                this.checkWeekDaysOrEnds();
            }
        },
        methods: {
            setIntervals() {
                let self = this
                self.intervals = []
                self.weekends_intervals = []
                for (let key in self.booking.time_interval) {
                    if (self.booking.time_interval[key] === '1') {
                        let interval = self.data.time_intervals.find(function (int) {
                            return int.id === key
                        })
                        if (interval.type === 'weekdays') {
                            self.intervals.push(interval)
                        } else {
                            self.weekends_intervals.push(interval)
                        }
                    }
                }
                let timeIntervals = []
                self.intervals.forEach(function (item) {
                    for (let i = item.start; i < item.end; i++) {
                        timeIntervals.push({
                            id: item.id,
                            val: i + ':00 - ' + Number(i + 1) + ':00'
                        })
                    }
                })
                self.intervals = timeIntervals

                timeIntervals = []
                self.weekends_intervals.forEach(function (item) {
                    for (let i = item.start; i < item.end; i++) {
                        timeIntervals.push({
                            id: item.id,
                            val: i + ':00 - ' + Number(i + 1) + ':00'
                        })
                    }
                })
                self.weekends_intervals = timeIntervals;
            },
            getTotalPrice() {
                let self = this;
                console.log(this.booking);
                if (self.booking.start_date) {
                    let year = dayjs(self.booking.start_date).get('year');
                    let month = dayjs(self.booking.start_date).get('month');
                    let date = dayjs(self.booking.start_date).get('date');
                    let workDays = 0;
                    let workWeekendDays = 0;
                    for (let i = date; i < (date + (7 * self.booking.weeks)); i++) {
                        let day = dayjs(year + '-' + (month + 1) + '-' + i).get('day');
                        if (day === 6 || day === 0) {
                            if (self.booking.days.indexOf(day) !== -1) {
                                workWeekendDays++;
                            }
                        } else {
                            if (self.booking.days.indexOf(day) !== -1) {
                                workDays++;
                            }
                        }
                    }
                    let total = 0;
                    if(this.booking.one_time_or_regular == 'regular'){
                        total = this.booking.suggested_price_per_hour * this.booking.days.length * this.booking.weeks * this.booking.time.length;
                        // if (workDays) {
                        //     total += self.booking.suggested_price_per_hour * self.booking.week_ends_checked.length * workWeekendDays
                        // }

                    }else{
                        total = self.booking.suggested_price_per_hour * self.booking.week_days_checked.length;
                        if (self.booking.week_days_checked.length === 0) {
                            total += self.booking.suggested_price_per_hour * self.booking.week_ends_checked.length;
                        }
                    }

                    this.booking.total = total.toFixed(2);
                    return total.toFixed(2);
                }
            },
            changeRegularOrOne() {
                if (this.booking.one_time_or_regular == 'regular') {
                    this.show_for_regular = true;
                } else {
                    this.show_for_regular = false;
                }
                this.getTotalPrice();
            },
            changeWeek() {
                this.getTotalPrice();
            },
            addDays(day) {
                if (this.in_array(day, this.booking.days)) {
                    let evens = this.booking.days.filter(function(item, day) {
                        return item !== day;
                    });
                    this.booking.days = evens;
                } else {
                    this.booking.days.push(Number(day));
                }
                // this.checkWeekDaysOrEnds();
                console.log(this.booking.days);
                this.getTotalPrice();
            },
            checkWorkWeekDays() {
                if (this.booking.nurse.entity.work_time_pref.weekdays_7_11 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekdays_11_14 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekdays_14_17 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekdays_17_21 === "1") {
                    return true;
                }else{
                    return false;
                }
            },
            checkWorkweekEnds() {
                if (this.booking.nurse.entity.work_time_pref.weekends_7_11 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekends_11_14 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekends_14_17 === "1" ||
                    this.booking.nurse.entity.work_time_pref.weekends_17_21 === "1") {
                    return true;
                }else{
                    return false;
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

            checkWeekDaysOrEnds() {
                if (this.booking.days.indexOf(1) === -1 && this.booking.days.indexOf(2) === -1 && this.booking.days.indexOf(3) === -1 &&
                    this.booking.days.indexOf(4) === -1 && this.booking.days.indexOf(5) === -1) {
                    this.show_week_days_interval = false;
                    this.booking.week_days_checked = [];
                }else{
                    this.show_week_days_interval = true;
                }

                if (this.booking.days.indexOf(0) === -1 && this.booking.days.indexOf(6) === -1) {
                    this.show_week_ends_interval = false;
                    this.booking.week_ends_checked = [];
                }else{
                    this.show_week_ends_interval = true;
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
