<template>
    <div>


        <div>{{ $t('one_time_or_regular') }}: {{ $t(booking.one_time_or_regular) }}</div>
        <div>{{ $t('start_date')}}: {{ booking.start_date}}</div>
        <div v-if="booking.status === 'not_approved'">{{ $t('suggested_price_per_hour')}}: {{ booking.suggested_price_per_hour }}</div>
        <div v-else>{{ $t('hourly_payment')}}: {{ booking.hourly_price }}</div>

        <span v-if="booking.one_time_or_regular === 'regular'">
            <div>{{ $t('days') }}: <span v-for="day in booking.days">{{ $t(day) }}&nbsp;</span></div>
            <div>{{ $t('weeks') }}: {{ booking.weeks }}</div>
        </span>

        <div>{{ $t('time_interval')}}</div>
        <div v-for="time in booking.time">
            {{ $t(time.time_interval)}}: {{ time.time + ' ' + $t('hours') }}
        </div>

        <div>{{ $t('total') }}: {{ booking.total }}</div>

    </div>
</template>

<script>
    export default {
        name: "Booking",
        props: ['booking'],
        mounted(){
            console.log(this.booking);
        }
    }
</script>

<style scoped>

</style>
