<template>
    <div>
        <nurse_info :data="data"></nurse_info>

        <div class="pt-row" v-if="info">
            <div class="pt-col-md-6">
                <div class="pt-calendar pt-lg">
                    <Datepicker
                        inline
                        autoApply
                        @update-month-year="changeMonth($event)"
                        v-model="booking.date"
                        :monthChangeOnScroll="false"
                        :enableTimePicker="false">
                        <template #day="{ day, date }">
                            <div class="pt-calendar--special">
                                <div class="pt-calendar--special-day">
                                    {{ day }}
                                </div>

                                <div class="pt-calendar--special-times">
                                    <div class="pt-calendar--special-time"
                                         v-for="(n, index) in 4"
                                         :class="{active: checkDateForEvent(date)[index] == 0}"
                                    >

                                    </div>
                                </div>
                            </div>
                        </template>
                    </Datepicker>
                </div>
            </div>
            <div class="pt-col-md-6">
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
                        Datum:
                    </div>
                    <div class="pt-finder--form-block--inner">
                        <div class="pt-finder--form-group">
                            <p class="pt-form--label">
                                {{plurredDate}}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-finder--form-block" v-if="weekdays_intervals && weekdays_intervals.length > 0">
                    <div class="pt-finder--form-label">
                        <div class="pt-finder--form-label--number">3</div>
                        verfügbare Zeit:
                    </div>
                    <div class="pt-finder--form-block--inner">
                        <div class="pt-finder--form-group">
                            <div class="">
                                <template v-for="item in weekdays_intervals">
                                    <label class="pt-checkbox">
                                        <input type="checkbox" name="work_time_pref"
                                               true-value="1" false-value="0"
                                               @change="changeInterval(booking.time_interval[item.id])"
                                               v-model="booking.time_interval[item.id]">
                                        <span class="pt-checkbox--body">{{ item.interval }}</span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-finder--form-block" v-if="getTimeIntervals().weekdays && getTimeIntervals().weekdays.length>0">
                    <div class="pt-finder--form-label">
                        <div class="pt-finder--form-label--number">4</div>
                        Geben Sie die Anzahl der Stunden ein:
                    </div>
                    <div class="pt-finder--form-block--inner">
                        <div class="pt-finder--form-group">
                            <div class="">
                                <template v-for="item in getTimeIntervals().weekdays">
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

                <div class="pt-finder--form-block" v-if="weekends_intervals && weekends_intervals.length > 0">
                    <div class="pt-finder--form-label">
                        <div class="pt-finder--form-label--number">3</div>
                        verfügbare Zeit: (weekends)
                    </div>
                    <div class="pt-finder--form-block--inner">
                        <div class="pt-finder--form-group">
                            <div class="">
                                <div class="pt-finder--form-group">
                                    <div class="">
                                        <template v-for="item in weekends_intervals">
                                            <label class="pt-checkbox">
                                                <input type="checkbox" name="work_time_pref"
                                                       true-value="1" false-value="0"
                                                       @change="changeInterval(booking.time_interval[item.id])"
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

                <div class="pt-finder--form-block" v-if="getTimeIntervals().weekends && getTimeIntervals().weekends.length>0">
                    <div class="pt-finder--form-label">
                        <div class="pt-finder--form-label--number">4</div>
                        Geben Sie die Anzahl der Stunden ein: (weekends)
                    </div>
                    <div class="pt-finder--form-block--inner">
                        <div class="pt-finder--form-group">
                            <div class="">
                                <template v-for="item in getTimeIntervals().weekends">
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
                        {{$t('comment') }}
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
                Gesamtpreis:  {{getTotalPrice()}} €
            </div>

            <button class="pt-btn--primary" v-on:click="sendBooking()">{{ $t('send') }}</button>
        </div>
    </div>
</template>

<script>
    import NurseInfo from "./NurseInfo";

    export default {
        name: "OneTimeBooking",
        props: ['data', 'clientSearchInfo'],
        data() {
            return {
                info: false,
                checkDate: null,
                intervals: false,
                weekends_intervals: [],
                weekdays_intervals: [],
                booking: {
                    total: 0,
                    suggested_price_per_hour: 0,
                    date: null,
                    additional_email: null,
                    comment: null,
                    time_interval: {},
                    time: [],
                },

                time_calendar: false,
            }
        },
        components: {
            'nurse_info': NurseInfo,
        },
        watch: {
            'booking.date': function (){
                if(this.time_calendar){
                    this.checkIntervals()
                    this.booking.time = []
                }
            }
        },
        mounted() {
            this.info = this.data
            this.booking.date = this.clientSearchInfo.one_time_date
            this.booking.time_interval = this.data.nurse.entity.work_time_pref
            this.booking.suggested_price_per_hour = this.data.nurse.entity.price.hourly_payment

            this.getTimeCalendar()
        },
        computed: {
            plurredDate(){
                let self = this
                return dayjs(self.booking.date).format('D.MM.YYYY')
            }
        },
        methods: {
            changeInterval(val) {
                let self = this
                if(val === '0'){
                    _.forEach(self.booking.time_interval, function (item, key){
                        if(item === '0'){
                            _.forEachRight(self.booking.time, function (o, i){
                                if(o.id === key){
                                    self.booking.time.splice(i, 1)
                                }
                            })
                        }
                    })
                }
            },
            indexing() {
                let list = document.querySelectorAll('.pt-finder--form-label--number')
                _.forEach(list, function (item, index){
                    item.innerHTML = index+1
                })
            },
            getTimeIntervals() {
                let self = this;
                let result = {
                    weekdays: [],
                    weekends: [],
                }

                _.forEach(self.booking.time_interval, function (item, key){
                    if(item == 1){
                        let type = key.substr(0, key.indexOf('_'))


                        let interval = _.find(self[type+'_intervals'], function(o) { return o.id === key; });

                        if(interval){
                            _.forEach(interval.value, function (el, index){
                                let tmp = {
                                    id: key,
                                    val: el
                                }
                                result[type].push(tmp)
                            })
                        }
                    }
                })

                setTimeout(function (){
                    self.indexing()
                }, 100)

                return result
            },
            checkIntervals() {
                let self = this
                let isWeekday = _.find(Object.keys(self.time_calendar[self.formatDate(self.booking.date)]), function (o){
                    if(o){
                        return o.indexOf('weekdays') !== -1
                    }
                    else{
                        return false
                    }
                })
                if(isWeekday){
                    self.weekends_intervals = false
                    self.weekdays_intervals = []
                }
                else{
                    self.weekends_intervals = []
                    self.weekdays_intervals = false
                }
                this.setIntervals()
            },
            setIntervals() {
                let self = this
                _.forEach(self.data.time_intervals, function (item){
                    if(self.time_calendar[self.formatDate(self.booking.date)][item.id] == 1){
                        if(item.id.indexOf('weekdays') !== -1){
                            if(self.weekdays_intervals){
                                self.weekdays_intervals.push(item)
                            }
                        }
                        else{
                            if(self.weekends_intervals){
                                self.weekends_intervals.push(item)
                            }
                        }
                    }
                })

                setTimeout(function (){
                    self.indexing()
                }, 100)
            },

            getTimeCalendar() {
                axios.post('/dashboard/nurse/get-time-calendar', {
                    'nurse_id': this.$route.params.id,
                    'needed_date': this.neededDate
                })
                    .then((response) => {
                        this.time_calendar = response.data.time_calendar;
                        this.checkIntervals()
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            changeMonth(date) {
                let dateStr = ''
                dateStr += date.year +'-'
                dateStr += date.month<9?'0'+(date.month+1):(date.month+1)
                dateStr += '-01'
                this.neededDate = dateStr
                this.getTimeCalendar();
            },
            checkDateForEvent(date) {
                let tmp = this.time_calendar[dayjs(date).format('YYYY-MM-DD')]
                let arr = []
                if (tmp) {
                    _.forEach(tmp, function (item) {
                        arr.push(item)
                    })
                }

                return arr
            },

            formatDate(date) {
                return dayjs(date).format('YYYY-MM-DD')
            },

            getTotalPrice(){
                let self = this
                if(self.booking.date){
                    let day = dayjs(self.booking.date).get('day')
                    let total = 0
                    total = self.booking.suggested_price_per_hour * self.booking.time.length

                    if(day === 6 || day === 0){
                        total += self.info.nurse.entity.price.weekend_surcharge_payment * self.booking.time.length
                    }

                    if(self.info.nurse.entity.price.weekend_surcharge ==='yes'){
                        //console.log('weekend_surcharge - ' + self.info.nurse.entity.price.weekend_surcharge_payment)
                    }
                    if(self.info.nurse.entity.price.fare_surcharge ==='yes'){
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
                    'nurse_user_id' : this.data.nurse.id,
                    'one_time_or_regular': 'one',
                })
                    .then((response) => {
                        if(response.data.success){
                            window.location.href = '/send-booking-message';
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
        },
    }
</script>

<style scoped>

</style>
