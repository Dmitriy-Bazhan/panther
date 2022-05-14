<template>
    <div class="pt-booking pt-section-default">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>buchung</span>
            </p>
            <h2 class="pt-title">
                Katharina M.
            </h2>

            <div class="pt-tabs pt-mt-45">
                <button v-on:click="activateTab(0)" :class="{active: activeTab === 0}" class="pt-tabs--btn">
                    {{ $t('one_time_booking') }}
                </button>

                <br>

                <button v-on:click="activateTab(1)" :class="{active: activeTab === 1}" class="pt-tabs--btn">
                    {{ $t('regular_booking') }}
                </button>
            </div>

            <div class="notification-you-have-booking" v-if="data.have_booking && startBooking">
                {{ $t('you_have_booking_to_this_nurse') }}
                <div class="link-to-bookings" v-on:click="goToMyBookings()">
                    {{ $t('go_to_my_bookings') }}
                </div>
            </div>


            <one_time_booking v-if="activeTab === 0 && clientSearchInfo" :clientSearchInfo="clientSearchInfo" :data="data"></one_time_booking>

            <regular_booking v-if="activeTab === 1 && clientSearchInfo" :clientSearchInfo="clientSearchInfo" :data="data"></regular_booking>
        </div>
    </div>
</template>

<script>
import template from './template.html';
import './style.css';
import OneTimeBooking from "./OneTimeBooking";
import RegularBooking from "./RegularBooking";

export default {
    name: 'Booking',
    props: ['data'],
    template: template,
    components: {
        'one_time_booking': OneTimeBooking,
        'regular_booking': RegularBooking,
    },
    data() {
        return {
            activeTab: 1,
            startBooking: true,
            clientSearchInfo: false,
        }
    },
    mounted() {
        this.getClientSearchInfo();
    },
    methods: {
        getClientSearchInfo() {
            axios.get('/finder/get-client-search-info')
                .then((response) => {
                    if (response.data.success) {
                        this.clientSearchInfo = response.data.clientSearchInfo;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        goToMyBookings() {
            window.location.href = '/dashboard/client/bookings';
        },
        activateTab(n) {
            this.activeTab = n;
            this.startBooking = false;
        },
    }
}

</script>

<style scoped>
.notification-you-have-booking {
    font-size: 14px;
    color: red;
    font-weight: 700;
}

.link-to-bookings {
    font-size: 13px;
    color: #0e2bff;
    font-weight: 700;
    cursor: pointer;
}

.link-to-bookings:hover {
    color: #6975ff;
}

</style>
