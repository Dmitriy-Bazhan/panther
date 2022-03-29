<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div>
                    <label class="form-label col-form-label-sm">Client propose price: {{
                        booking.suggested_price_per_hour }}</label>
                </div>
                <div>
                    <label class="form-label col-form-label-sm">Your price</label>
                    <input type="number" class="form-control form-control-sm"
                           v-model="alternative.alternative_suggested_price_per_hour" min="15">
                </div>
            </div>
            <div class="col-3">
                <div>
                    <label class="form-label col-form-label-sm">{{ $t('one_time_or_regular') }}: {{
                        booking.one_time_or_regular }}</label>
                </div>
                <div>
                    <label class="form-label col-form-label-sm">{{ $t('your_one_time_or_regular') }}</label>
                    <select class="form-control form-control-sm"
                            v-model="alternative.alternative_one_time_or_regular">
                        <option value="one">{{ $t('one') }}</option>
                        <option value="regular">{{ $t('regular') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <label class="form-label col-form-label-sm">{{ $t('start_date') }}: {{ booking.start_date }}</label>
                </div>
                <div>
                    <label class="form-label col-form-label-sm">{{ $t('your_start_date') }}</label>
                    <input type="date" class="form-control form-control-sm"
                           v-model="alternative.alternative_start_date">
                </div>
            </div>

            <div class="col-3">
                <div>
                    <label class="form-label col-form-label-sm">{{ $t('time') }}:</label>
                </div>
                 <div v-for="(item, index) in JSON.parse(nurse.entity.work_time_pref)">
                    <div v-if="item === '1'">
                        <input type="checkbox" v-model="alternative.alternative_time">
                        <label>{{ index }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Alternative",
        props: ['booking', 'nurse'],
        data() {
            return {
                alternative: {
                    alternative_suggested_price_per_hour: 0,
                    total: 0,
                    alternative_one_time_or_regular: null,
                    alternative_start_date: null,
                    alternative_finish_date: null,
                    alternative_weeks: 0,
                    alternative_days: null,
                    alternative_time: {}
                },
                show_for_regular: false,
            }
        },
        watch: {
            alternative: {
                handler(newValue, oldValue) {
                    console.log(newValue.alternative_one_time_or_regular);
                },
                deep: true
            }

        },
        mounted() {
            console.log(this.nurse);
            if (this.booking.have_alternative === 'yes') {
                this.alternative = this.booking.alternative;
            } else {
                this.alternative.alternative_suggested_price_per_hour = this.booking.suggested_price_per_hour;
                this.alternative.alternative_one_time_or_regular = this.booking.one_time_or_regular;
                this.alternative.alternative_start_date = this.booking.start_date;
                this.alternative.alternative_finish_date = this.booking.finish_date;
                this.alternative.alternative_weeks = this.booking.weeks;
                this.alternative.alternative_days = this.booking.days;
                this.alternative.alternative_time = this.booking.time;
            }
            console.log(this.alternative);
        },
        methods: {}
    }
</script>

<style scoped>

</style>
