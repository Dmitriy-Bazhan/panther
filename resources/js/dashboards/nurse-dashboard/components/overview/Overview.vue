<template>
    <div class="pt-overview">
        <div class="pt-row pt-row-stretch">
            <div class="pt-col-md-8">
                <div class="pt-calendar--wrapper">
                    <div class="pt-calendar">
                        <Datepicker
                            inline
                            autoApply
                            @selected="selectDate()"
                            @update-month-year="changeMonth($event)"
                            v-model="date"
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
                                             :class="{active: checkDateForEvent(date)[index] == 1}"
                                        >

                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Datepicker>
                    </div>

                    <div class="pt-calendar--info">
                        <div class="pt-calendar--info-inner">
                            <h3 class="pt-calendar--info-title">
                                {{ selectedDate.date }}
                            </h3>
                            <ul class="pt-calendar--info-list">
                                <li class="pt-calendar--info-list--item" v-for="item in selectedDate.time">
                           <span
                               class="pt-calendar--info-list--item-type"
                               :class="{active: item.active === '1'}"></span>

                                    <div class="pt-calendar--info-list--item-text">
                                        {{ item.interval }}
                                        <span v-if="item.active !== '1'">zugänglich</span>
                                        <span v-else>booking</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-col-md-4">
                <div class="pt-overview--user">
                    <div class="pt-overview--user-avatar">
                        <img
                            v-if="user.entity.original_photo !== null"
                            :src="path + '/storage/' + user.entity.original_photo" alt="no-photo"
                        >
                        <img v-else :src="path + '/images/no-photo.jpg'" alt="no-photo">
                    </div>
                    <p class="pt-overview--user-name">
                        {{ user.full_name }}
                    </p>
                    <div class="pt-overview--user-rating">

                    </div>
                    <p class="pt-overview--user-text">
                        {{ user.entity.age }} Jahre Alt | {{ user.zip_code }} <br>
                        etwas Besuche pro Woche
                    </p>
                    <div class="pt-overview--user-price">
                        €{{ user.entity.price.hourly_payment }}/Stunde
                    </div>

                    <div class="pt-overview--user-divider"></div>

                    <div class="pt-overview--user-clients">
                        <div class="pt-overview--user-client">
                            <div class="pt-overview--user-client--label">Kunden:</div>
                            <div class="pt-overview--user-client--count">
                                {{ user.all_clients }}
                            </div>
                        </div>
                        <div class="pt-overview--user-client">
                            <div class="pt-overview--user-client--label">Neue Kunden:</div>
                            <div class="pt-overview--user-client--count">
                                {{ user.new_clients }}
                            </div>
                        </div>
                        <div class="pt-overview--user-client">
                            <div class="pt-overview--user-client--label">Payments:</div>
                            <div class="pt-overview--user-client--count">
                                {{ user.payments }}
                            </div>
                        </div>
                        <div class="pt-overview--user-client">
                            <div class="pt-overview--user-client--label">Booking:</div>
                            <div class="pt-overview--user-client--count">
                                {{ user.bokkings_count }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-overview--messages" v-if="data.last_chats && Object.keys(data.last_chats.clients).length>0">
            <div class="pt-overview--messages-head">
                <h3 class="pt-overview--messages-head--title">
                    Messages
                </h3>

                <router-link
                    :to="{ name: 'NurseDashboardMessages'}"
                    class="pt-link"
                >
                    Alle Ansehen
                </router-link>
            </div>
            <div class="pt-client" v-for="nurse in data.last_chats.clients">
                <div class="pt-client--avatar">
                    <img :src="path + '/storage/' + nurse[0].entity.thumbnail_photo" alt="pic"
                         v-if="nurse[0].entity.thumbnail_photo">
                    <div class="pt-client--avatar-no-photo" v-else>
                        <span>{{ nurse[0].first_name }}</span>
                        <span>{{ nurse[0].last_name }}</span>
                    </div>
                    <span v-if="haveUnreadMessages" class="pt-client--signal"></span>
                </div>
                <div class="pt-client--info">
                    <div class="pt-client--name">
                        {{ nurse[0].full_name }}
                    </div>
                    <div class="pt-client--date">
                        {{ formatDate(nurse.last_message.created_at) }}
                    </div>
                </div>
                <div class="pt-client--msg" v-if="nurse.last_message">
                    {{ nurse.last_message.message }}
                </div>
                <div class="pt-client--meta">
                    <router-link
                        :to="{ name: 'NurseDashboardMessages', params: { chatId: nurse[0].id }}"
                        class="pt-btn--light"
                    >
                        Weiterlesen
                        <i class="fa-solid fa-arrow-right"></i>
                    </router-link>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "Overview",
    props: ['user', 'data'],
    data() {
        return {
            path: location.origin,
            time_calendar: [],
            chat: false,
            date: new Date(),
            selectedDate: false,
            neededDate: null,
        }
    },
    mounted() {
        this.getTimeCalendar();
    },
    watch: {
        date(val) {
            this.selectDate(val)
        }
    },
    methods: {
        changeMonth(date) {
            let dateStr = ''
            dateStr += date.year +'-'
            dateStr += date.month<9?'0'+(date.month+1):(date.month+1)
            dateStr += '-01'
            this.neededDate = dateStr
            this.getTimeCalendar();
        },
        selectDate(date) {
            let tmp;
            if (date) {
                tmp = this.time_calendar[dayjs(date).format('YYYY-MM-DD')]
                date = dayjs(date).format('YYYY-MM-DD')
            } else {
                tmp = this.time_calendar[dayjs(this.date).format('YYYY-MM-DD')]
                date = dayjs(this.date).format('YYYY-MM-DD')
            }

            let time = []
            _.forEach(tmp, function (item, key) {
                if (key.indexOf('_7_11') !== -1) {
                    time.push({
                        interval: '07:00 - 11:00',
                        active: item
                    })
                } else if (key.indexOf('_11_14') !== -1) {
                    time.push({
                        interval: '11:00 - 14:00',
                        active: item
                    })
                } else if (key.indexOf('_14_17') !== -1) {
                    time.push({
                        interval: '14:00 - 17:00',
                        active: item
                    })
                } else if (key.indexOf('_17_21') !== -1) {
                    time.push({
                        interval: '17:00 - 21:00',
                        active: item
                    })
                }
            })

            this.selectedDate = {
                date: date,
                time: time,
            }
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
            let a = String(date).split('T');
            return a[0] + ' ' + String(a[1].split('.')[0]);
        },
        getTimeCalendar() {
            axios.post('/dashboard/nurse/get-time-calendar', {
                'nurse_id': this.user.id,
                'needed_date': this.neededDate
            })
                .then((response) => {
                    this.time_calendar = response.data.time_calendar;
                    this.selectDate()
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}

</script>

<style lang="scss">
.pt-calendar--wrapper{
    .pt-calendar {
        .dp__menu{
            border-radius: 0;
            border: none;
        }
    }
}
</style>

<style scoped lang="scss">
.pt-calendar {
    .dp__main{
        max-width: 100%;
    }

    .dp__menu{
        border-radius: 0;
        border: none;
    }
}
</style>
