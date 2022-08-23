<template>
    <div>
        <nurse_info :data="data"></nurse_info>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">1</div>
                Price:
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <pt-input type="number" :modelValue="booking.suggested_price_per_hour"
                              icon="user"
                              @update:modelValue="newValue => booking.suggested_price_per_hour = newValue"
                    ></pt-input>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">2</div>
                Wochentag auswählen:
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <div class="">
                        <template v-for="item in weekdayLabels">
                            <label class="pt-checkbox" v-if="checkWorkWeekDays()">
                                <input type="checkbox" name="work_time_pref"
                                       :value="item.val"
                                       v-model="booking.days">
                                <span class="pt-checkbox--body">{{ item.label }}</span>
                            </label>
                        </template>
                        <template v-for="item in weekendLabels">
                            <label class="pt-checkbox">
                                <input type="checkbox" name="work_time_pref"
                                       :value="item.val"
                                       :disabled="!checkWorkweekEnds()"
                                       v-model="booking.days">
                                <span class="pt-checkbox--body">{{ item.label }}</span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">3</div>
                Wählen Sie ein Startdatum:
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <div class="pt-calendar">
                        <Datepicker v-model="booking.date"
                                    inline
                                    autoApply
                                    :monthChangeOnScroll="false"
                                    :enableTimePicker="false"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">4</div>
                verfügbare Zeit:
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <div class="">
                        <div class="pt-finder--form-group">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">5</div>
                Geben Sie die Anzahl der Stunden ein:
            </div>
            <div class="pt-finder--form-block--inner">
                <!--                <div class="pt-finder&#45;&#45;form-group">-->
                <!--                    <div class="pt-select">-->
                <!--                        <div class="pt-select&#45;&#45;icon">-->
                <!--                            <pt-icon type="watch"></pt-icon>-->
                <!--                        </div>-->
                <!--                        <v-select multiple :closeOnSelect="false" :options="intervals?intervals:[]"-->
                <!--                                  v-model="booking.time">-->
                <!--                            <template #open-indicator>-->
                <!--                                <span class="pt-select&#45;&#45;caret"></span>-->
                <!--                            </template>-->
                <!--                        </v-select>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div class="pt-finder--form-group">
                    <div class="">
                        <template v-for="item in intervals">
                            <label class="pt-checkbox">
                                <input type="checkbox" name="work_time_pref"
                                       :value="item"
                                       v-model="booking.time">
                                <span class="pt-checkbox--body">{{ item.val }}</span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">6</div>
                verfügbare Zeit: (weekends)
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <div class="">
                        <div class="pt-finder--form-group">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">7</div>
                Geben Sie die Anzahl der Stunden ein: (weekends)
            </div>
            <div class="pt-finder--form-block--inner">
                <!--                <div class="pt-finder&#45;&#45;form-group">-->
                <!--                    <div class="pt-select">-->
                <!--                        <div class="pt-select&#45;&#45;icon">-->
                <!--                            <pt-icon type="watch"></pt-icon>-->
                <!--                        </div>-->
                <!--                        <v-select multiple :closeOnSelect="false" :options="intervals?intervals:[]"-->
                <!--                                  v-model="booking.time">-->
                <!--                            <template #open-indicator>-->
                <!--                                <span class="pt-select&#45;&#45;caret"></span>-->
                <!--                            </template>-->
                <!--                        </v-select>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div class="pt-finder--form-group">
                    <div class="">
                        <template v-for="item in weekends_intervals">
                            <label class="pt-checkbox">
                                <input type="checkbox" name="work_time_pref"
                                       :value="item"
                                       v-model="booking.time">
                                <span class="pt-checkbox--body">{{ item.val }}</span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">8</div>
                Anzahl der Wochen auswählen:
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <pt-input type="number" :modelValue="booking.weeks"
                              icon="help"
                              @update:modelValue="newValue => booking.weeks = newValue"
                    ></pt-input>
                </div>
            </div>
        </div>

        <div class="pt-row pt-mt-50">
            <div class="pt-col-md-12">
                <p class="pt-block-heading pt-mb-10">
                    Persönliche Angaben
                </p>
            </div>
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('name') }}
                    </p>
                    <pt-input type="text" :modelValue="$store.state.user.first_name + ' ' + $store.state.user.last_name"
                              icon="user"
                              :disabled="true"
                    ></pt-input>
                </div>
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('nurse_location_subtitle') }}
                    </p>
                    <pt-input type="text" :modelValue="clientSearchInfo.phone"
                              icon="pin"
                    ></pt-input>
                </div>
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('phone') }}
                    </p>
                    <pt-input type="text" :modelValue="$store.state.user.phone"
                              icon="phone"
                              :disabled="true"
                    ></pt-input>
                </div>
            </div>
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('comment') }}
                    </p>
                    <div class="pt-textarea">
                        <div class="pt-textarea--icon">
                            <pt-icon type="text"></pt-icon>
                        </div>
                        <textarea v-model="booking.comment"></textarea>
                        <div class="pt-textarea--box"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-booking--result pt-mt-50">
            <div class="pt-block-heading">
                Gesamtpreis: {{ getTotalPrice() }} €
            </div>

            <button class="pt-btn--primary" v-on:click="sendBooking()">{{ $t('send') }}</button>
        </div>
    </div>
</template>

<script>
import NurseInfo from "./NurseInfo";


export default {
    name: "RegularBooking",
    props: ['data', 'clientSearchInfo'],
    components: {
        'nurse_info': NurseInfo,
    },
    data() {
        return {
            weekdayLabels: [
                {
                    label: 'Monday',
                    val: 1,
                },
                {
                    label: 'Tuesday',
                    val: 2,
                },
                {
                    label: 'Wednesday',
                    val: 3,
                },
                {
                    label: 'Thursday',
                    val: 4,
                },
                {
                    label: 'Friday',
                    val: 5,
                },
            ],
            weekendLabels: [
                {
                    label: 'Saturday',
                    val: 6,
                },
                {
                    label: 'Sunday',
                    val: 0,
                },
            ],
            intervals: false,
            weekends_intervals: false,
            booking: {
                total: 0,
                suggested_price_per_hour: 0,
                additional_email: null,
                days: [],
                date: null,
                weeks: 1,
                time_interval: {},
                time: [],
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
                for (let index in newValue.time) {
                    hours = hours + Number(newValue.time[index]);
                }
                this.booking.total = hours * this.booking.suggested_price_per_hour * this.booking.weeks * this.booking.days.length;
            },
            deep: true,
        }
    },
    mounted() {
        this.info = this.data
        this.booking.date = this.clientSearchInfo.one_time_date
        this.booking.time_interval = this.data.nurse.entity.work_time_pref
        this.booking.suggested_price_per_hour = this.data.nurse.entity.price.hourly_payment

        this.setIntervals()
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
            self.weekends_intervals = timeIntervals
        },
        getTotalPrice() {
            let self = this
            if (self.booking.date) {
                let year = dayjs(self.booking.date).get('year');
                let month = dayjs(self.booking.date).get('month');
                let date = dayjs(self.booking.date).get('date');
                let workDays = 0
                let workWeekendDays = 0
                for (let i = date; i < (date + (7 * self.booking.weeks)); i++) {
                    let day = dayjs(year + '-' + (month + 1) + '-' + i).get('day')
                    if (day === 6 || day === 0) {
                        if (self.booking.days.indexOf(day) !== -1) {
                            workWeekendDays++
                        }
                    } else {
                        if (self.booking.days.indexOf(day) !== -1) {
                            workDays++
                        }
                    }
                }

                let total = 0
                total = self.booking.suggested_price_per_hour * self.booking.time.length * workDays
                if (workDays) {
                    total += self.booking.suggested_price_per_hour * self.booking.time.length * workWeekendDays
                }

                if (self.info.nurse.entity.price.weekend_surcharge === 'yes') {
                    //console.log('weekend_surcharge - ' + self.info.nurse.entity.price.weekend_surcharge_payment)
                }
                if (self.info.nurse.entity.price.fare_surcharge === 'yes') {
                    //console.log('fare_surcharge_payment - ' +self.info.nurse.entity.price.fare_surcharge_payment)
                }

                return total.toFixed(2)
            }
        },
        sendBooking() {
            this.booking.fullname = this.$store.state.user.first_name + ' ' + this.$store.state.user.last_name
            this.booking.client_phone = this.$store.state.user.phone
            this.booking.total = this.getTotalPrice()

            axios.post('/booking', {
                'booking': this.booking,
                'nurse_user_id': this.data.nurse.id,
                'one_time_or_regular': 'regular',
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
    }
}
</script>

<style scoped>

</style>
