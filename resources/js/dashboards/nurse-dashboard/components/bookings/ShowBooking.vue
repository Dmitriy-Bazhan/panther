<template>
    <div class="pt-finder--form-block">
        <div class="pt-finder--form-group" v-show="booking.suggested_price_per_hour">
            <p class="pt-form--label">
                {{ $t('suggested_price_per_hour') }}
            </p>
            <p class="pt-form--text">
                {{booking.suggested_price_per_hour}}
            </p>
        </div>

        <div class="pt-finder--form-group" v-show="booking.additional_email">
            <p class="pt-form--label">
                {{ $t('additional_email') }}
            </p>
            <p class="pt-form--text">
                {{booking.additional_email}}
            </p>
        </div>

        <div class="pt-finder--form-group" v-show="booking.start_date">
            <p class="pt-form--label">
                {{ $t('start_date') }}
            </p>
            <p class="pt-form--text">
                {{booking.start_date}}
            </p>
        </div>

        <div class="pt-finder--form-group" v-show="booking.one_time_or_regular">
            <p class="pt-form--label">
                {{ $t('one_time_or_regular') }}
            </p>
            <p class="pt-form--text">
                {{booking.one_time_or_regular}}
            </p>
        </div>

        <div class="pt-finder--form-group" v-show="booking.weeks">
            <p class="pt-form--label">
                {{ $t('weeks') }}
            </p>
            <p class="pt-form--text">
                {{booking.weeks}}
            </p>
        </div>

        <div class="pt-finder--form-group" v-show="booking.days">
            <p class="pt-form--label">
                {{ $t('days') }}
            </p>
            <p class="pt-form--text">
                <template v-for="(day, index) in booking.days">
                    <template v-if="index !== 0">, </template>
                    {{days[day]}}
                </template>
            </p>
        </div>

        <div class="pt-finder--form-group" v-show="booking.time">
            <p class="pt-form--label">
                {{ $t('time') }}
            </p>
            <p class="pt-form--text">
                <template v-for="(date, index) in booking.time">
                    <template v-if="index !== 0">, </template>
                    {{date.time}}
                </template>
            </p>
        </div>

        <div class="pt-finder--form-group" v-show="booking.total">
            <p class="pt-form--label">
                {{ $t('total') }}
            </p>
            <p class="pt-form--text">
                {{ booking.total }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Booking",
        props: ['booking'],
        data(){
            return {
                days: {
                    1: 'Monday',
                    2: 'Tuesday',
                    3: 'Wednesday',
                    4: 'Thursday',
                    5: 'Friday',
                    6: 'Saturday',
                    0: 'Sunday'
                },
            }
        }
    }
</script>

<style scoped>
.pt-form--text{
    text-align: left;
}
</style>
