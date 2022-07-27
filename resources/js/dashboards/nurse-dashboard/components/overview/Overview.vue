<template>
    <div class="pt-overview">
        <div class="pt-row">
            <div class="pt-col-md-8">
                <div class="pt-calendar">
                    <Datepicker
                                inline
                                autoApply
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
                        {{user.full_name}}
                    </p>
                    <div class="pt-overview--user-rating">

                    </div>
                    <p class="pt-overview--user-text">
                        {{user.entity.age}} Jahre Alt | {{user.zip_code}} <br>
                        etwas Besuche pro Woche
                    </p>
                    <div class="pt-overview--user-price">
                        €{{user.entity.price.hourly_payment}}/Stunde
                    </div>

                    <div class="pt-overview--user-divider"></div>

                    <div class="pt-overview--user-clients">
                        <div class="pt-overview--user-client">
                            <div class="pt-overview--user-client--label">Kunden:</div>
                            <div class="pt-overview--user-client--count">
                                {{user.all_clients}}
                            </div>
                        </div>
                        <div class="pt-overview--user-client">
                            <div class="pt-overview--user-client--label">Neue Kunden:</div>
                            <div class="pt-overview--user-client--count">
                                {{user.new_clients}}
                            </div>
                        </div>
                        <div class="pt-overview--user-client">
                            <div class="pt-overview--user-client--label">Payments:</div>
                            <div class="pt-overview--user-client--count">
                                {{user.payments}}
                            </div>
                        </div>
                        <div class="pt-overview--user-client">
                            <div class="pt-overview--user-client--label">Booking:</div>
                            <div class="pt-overview--user-client--count">
                                {{user.bokkings_count}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-overview--messages" v-if="data.last_chats && data.last_chats.clients && data.last_chats.clients.length>0">
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
                    <img :src="path + '/storage/' + nurse[0].entity.thumbnail_photo" alt="pic" v-if="nurse[0].entity.thumbnail_photo">
                    <div class="pt-client--avatar-no-photo" v-else>
                        <span>{{ nurse[0].first_name }}</span>
                        <span>{{ nurse[0].last_name }}</span>
                    </div>
                    <span v-if="haveUnreadMessages" class="pt-client--signal"></span>
                </div>
                <div class="pt-client--info">
                    <div class="pt-client--name">
                        {{ nurse[0].full_name}}
                    </div>
                    <div class="pt-client--date">
                        {{formatDate(nurse.last_message.created_at)}}
                    </div>
                </div>
                <div class="pt-client--msg" v-if="nurse.last_message">
                    {{ nurse.last_message.message}}
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
            }
        },
        mounted() {
            console.log(this.data)
        },
        created() {

        },
        methods: {
            checkDateForEvent(date) {
                let tmp = this.time_calendar[dayjs(date).format('YYYY-MM-DD')]
                let arr = []
                if(tmp){
                    _.forEach(tmp, function (item){
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
                        console.log(this.time_calendar);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }

</script>

<style scoped lang="scss">
.pt-calendar .dp__main{
    max-width: 100%;
}

.chat-wrapper {
    height: 400px;
    overflow: auto;
    background: lightcyan;
    padding: 10px;
}

.chat-client-message-wrapper {
    background: #85acff;
    border: solid 1px #405dff;
    padding: 10px;
    border-radius: 10px;
    width: 75%;
    margin-bottom: 10px;
}

.chat-client-name {
    font-size: 14px;
    font-weight: 700;
    color: #051dff;
}

.chat-client-message {
    font-size: 14px;
    font-weight: 700;
    color: #6500ff;
}

.chat-client-date {
    font-size: 10px;
    font-weight: 700;
    color: #051dff;
}

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
    height: 100px;
    display: block;
    justify-content: center;
    align-items: center;
    color: #3a3a3a;
    background-color: white;
    border: solid 1px #aaaaaa;
}

.calendar-marker {
    width: 50%;
    display: inline-block;
    text-align: center;
}

.calendar-marker-busy {
    display: inline-block;
    width: 50px;
    height: 25px;
    background-color: red;
    margin-top: 5px;
}

.calendar-marker-not-busy {
    display: inline-block;
    width: 50px;
    height: 25px;
    background-color: green;
    margin-top: 5px;
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
