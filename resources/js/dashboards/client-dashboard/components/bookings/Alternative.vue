<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 offset-3">{{ $t('your_propose') }}</div>
            <div class="col-4">{{ $t('nurse_propose') }}</div>
        </div>
        <div class="row">
            <div class="col-3">{{ $t('one_time_or_regular') }}</div>
            <div class="col-4">{{ $t(booking.one_time_or_regular) }}</div>
            <div class="col-4">{{ $t(booking.alternative.alternative_one_time_or_regular) }}</div>
        </div>

        <div class="row">
            <div class="col-3">{{ $t('start_date')}}</div>
            <div class="col-4">{{ booking.start_date}}</div>
            <div class="col-4">{{ booking.alternative.alternative_start_date}}</div>
        </div>

        <div class="row">
            <div class="col-3">{{ $t('suggested_price_per_hour')}}</div>
            <div class="col-4">{{ booking.suggested_price_per_hour }}</div>
            <div class="col-4">{{ booking.alternative.alternative_suggested_price_per_hour }}</div>
        </div>

        <div class="row">
            <div class="col-3"></div>
            <div class="col-4"></div>
            <div class="col-4"></div>
        </div>

        <div class="row">
            <div class="col-3"></div>
            <div class="col-4" v-if="booking.one_time_or_regular === 'regular'">
                <div>{{ $t('days') }}: <span v-for="day in booking.days">{{ day }}&nbsp;</span></div>
                <div>{{ $t('weeks') }}: {{ booking.weeks }}</div>
            </div>
            <div class="col-4" v-if="booking.alternative.alternative_one_time_or_regular === 'regular'">
                <div>{{ $t('days') }}: <span v-for="day in booking.alternative.alternative_days">{{ day }}&nbsp;</span></div>
                <div>{{ $t('weeks') }}: {{ booking.alternative.alternative_weeks }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-3">{{ $t('time_interval')}}</div>
            <div class="col-4">
                <div v-for="time in booking.time">
                    {{ $t(time.time_interval)}}: {{ time.time + ' ' + $t('hours') }}
                </div>
            </div>
            <div class="col-4">
                <div v-for="time in booking.alternative.time">
                    {{ $t(time.alternative_time_interval)}}: {{ time.alternative_time + ' ' + $t('hours') }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-3">{{ $t('total') }}</div>
            <div class="col-4">{{ booking.total }}</div>
            <div class="col-4">{{ booking.alternative.total }}</div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Alternative",
        props: ['booking'],
        mounted() {
            console.log(this.booking);
        }

    }
</script>

<style scoped>

</style>
