<template>

    <div class="pt-finder--form-block">
        <div class="pt-row">
            <div class="pt-col-md-6">
                <h2 class="pt-title">
                    {{ $t('your_propose') }}
                </h2>
            </div>
            <div class="pt-col-md-6">
                <h2 class="pt-title">
                    {{ $t('nurse_propose') }}
                </h2>
            </div>
        </div>
        <div class="pt-row">
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('one_time_or_regular') }}
                    </p>
                    <p class="pt-form--text">
                        {{booking.one_time_or_regular}}
                    </p>
                </div>
            </div>
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('one_time_or_regular') }}
                    </p>
                    <p class="pt-form--text">
                        {{ $t(booking.alternative.alternative_one_time_or_regular) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="pt-row">
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('start_date') }}
                    </p>
                    <p class="pt-form--text">
                        {{booking.start_date}}
                    </p>
                </div>
            </div>
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('start_date') }}
                    </p>
                    <p class="pt-form--text">
                        {{ booking.alternative.alternative_start_date}}
                    </p>
                </div>
            </div>
        </div>
        <div class="pt-row">
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('suggested_price_per_hour') }}
                    </p>
                    <p class="pt-form--text">
                        {{booking.suggested_price_per_hour}}
                    </p>
                </div>
            </div>
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('suggested_price_per_hour') }}
                    </p>
                    <p class="pt-form--text">
                        {{ booking.alternative.alternative_suggested_price_per_hour}}
                    </p>
                </div>
            </div>
        </div>
        <div class="pt-row">
            <div class="pt-col-md-6" v-if="booking.one_time_or_regular === 'regular'">
                <div class="pt-finder--form-group">
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
            </div>
            <div class="pt-col-md-6" v-if="booking.alternative.alternative_one_time_or_regular === 'regular'">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('days') }}
                    </p>
                    <p class="pt-form--text">
                        <template v-for="(day, index) in booking.alternative.alternative_days">
                            <template v-if="index !== 0">, </template>
                            {{days[day]}}
                        </template>
                    </p>
                </div>
            </div>
        </div>
        <div class="pt-row">
            <div class="pt-col-md-6" v-if="booking.one_time_or_regular === 'regular'">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('weeks') }}
                    </p>
                    <p class="pt-form--text">
                        {{booking.weeks}}
                    </p>
                </div>
            </div>
            <div class="pt-col-md-6" v-if="booking.alternative.alternative_one_time_or_regular === 'regular'">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('weeks') }}
                    </p>
                    <p class="pt-form--text">
                        {{ booking.alternative.alternative_weeks}}
                    </p>
                </div>
            </div>
        </div>
        <div class="pt-row">
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('time_interval') }}
                    </p>
                    <p class="pt-form--text">
                        <template v-for="(time, index) in booking.time">
                            <template v-if="index !== 0">, </template>
                            {{ $t(time.time_interval)}}: {{ time.time + ' ' + $t('hours') }}
                        </template>
                    </p>
                </div>
            </div>
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('time_interval') }}
                    </p>
                    <p class="pt-form--text">
                        <template v-for="(time, index) in booking.alternative.time">
                            <template v-if="index !== 0">, </template>
                            {{ $t(time.alternative_time_interval)}}: {{ time.alternative_time + ' ' + $t('hours') }}
                        </template>
                    </p>
                </div>
            </div>
        </div>
        <div class="pt-row">
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('total') }}
                    </p>
                    <p class="pt-form--text">
                        {{ booking.total }}
                    </p>
                </div>
            </div>
            <div class="pt-col-md-6">
                <div class="pt-finder--form-group">
                    <p class="pt-form--label">
                        {{ $t('total') }}
                    </p>
                    <p class="pt-form--text">
                        {{ booking.alternative.total }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Alternative",
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
        },
        mounted() {
            console.log(this.booking);
        }

    }
</script>

<style scoped>
    .pt-form--text{
        text-align: left;
    }
</style>
