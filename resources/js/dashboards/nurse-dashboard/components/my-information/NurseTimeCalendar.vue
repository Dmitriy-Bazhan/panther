<template>
    <div  class="container-fluid">
        <!-- one or regular order -->
        <div class="row">
            <div class="col-3">
                <label for="one_or_regular" class="form-label col-form-label-sm">
                    {{ $t('one_or_regular') }}
                </label>
            </div>

            <div class="col-3">
                <select class="form-control form-control-sm" v-model="user.entity.one_or_regular"
                        id="one_or_regular">
                    <option value="one">{{ $t('one') }}</option>
                    <option value="regular">{{ $t('regular') }}</option>
                    <option value="no_matter">{{ $t('no_matter') }}</option>
                </select>
            </div>
        </div>

        <!--        ready to work-->
        <div class="row">
            <div class="col-3">
                <label for="ready_to_work" class="form-label col-form-label-sm">
                    {{ $t('ready_to_work') }}
                </label>
            </div>

            <div class="col-3">
                <select class="form-control form-control-sm" v-model="user.entity.ready_to_work"
                        id="ready_to_work">
                    <option value="yes">{{ $t('yes') }}</option>
                    <option value="no">{{ $t('no') }}</option>
                </select>
            </div>
        </div>

        <!--        start date ready to work-->
        <div class="row">
            <div class="col-3">
                <label for="start_date_ready_to_work" class="form-label col-form-label-sm">
                    {{ $t('start_date_ready_to_work') }}
                </label>
            </div>

            <div class="col-3">
                <input type="date" class="form-control form-control-sm" v-model="user.entity.start_date_ready_to_work"
                       id="start_date_ready_to_work">
            </div>
        </div>

        <div class="row">

            <div class="row">
                <div class="col-12 justify-content-center">
                    <span class="form-label col-form-label-sm">{{ $t('time_calendar') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8 offset-2">
                <div class="row">
                    <div class="col-4 offset-4 justify-content-center">{{ $t('weekdays') }}</div>
                    <div class="col-4 justify-content-center">{{ $t('weekends') }}</div>
                </div>
                <div class="row">
                    <div class="col-4 offset-4 justify-content-center">{{ $t('mon_fri') }}</div>
                    <div class="col-4 justify-content-center">{{ $t('sat_sun') }}</div>
                </div>

                <!--                        7-11 Uhr  -->
                <div class="row">
                    <div class="col-4">7-11 Uhr</div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekdays_morning" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref.weekdays_7_11">
                        &nbsp;<label for="weekdays_morning"></label>
                    </div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekends_morning" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref.weekends_7_11">
                        &nbsp;<label for="weekends_morning"></label>
                    </div>
                </div>
                <!--                        11-14 Uhr  -->
                <div class="row">
                    <div class="col-4">11-14 Uhr</div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekdays_afternoon" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref.weekdays_11_14">
                        &nbsp;<label for="weekdays_afternoon"></label>
                    </div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekends_afternoon" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref.weekends_11_14">
                        &nbsp;<label for="weekends_afternoon"></label>
                    </div>
                </div>
                <!--                        14-17 Uhr -->
                <div class="row">
                    <div class="col-4">14-17 Uhr</div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekdays_evening" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref.weekdays_14_17">
                        &nbsp;<label for="weekdays_evening"></label>
                    </div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekends_evening" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref.weekends_14_17">
                        &nbsp;<label for="weekends_evening"></label>
                    </div>
                </div>
                <!--                        17-21 Uhr -->
                <div class="row">
                    <div class="col-4">17-21 Uhr</div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekdays_overnight" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref.weekdays_17_21">
                        &nbsp;<label for="weekdays_overnight"></label>
                    </div>
                    <div class="col-4 justify-content-center">
                        <input type="checkbox" id="weekends_overnight" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref.weekends_17_21">
                        &nbsp;<label for="weekends_overnight"></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-2 offset-10">
                <button class="btn btn-success btn-sm" v-on:click="updateInformation">{{ $t('update') }}</button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "NurseTimeCalendar",
        props: ['user', 'data', 'errors'],
        data() {
            return {

            }
        },
        mounted() {
            console.log(this.user);

        },
        watch: {
            user: {
                handler(newValue, oldValue) {
                    if (typeof this.user.entity.work_time_pref === "string") {
                        this.user.entity.work_time_pref = JSON.parse(this.user.entity.work_time_pref);
                    }
                },
                immediate: true
            },
        },
        methods: {
            updateInformation() {
                this.emitter.emit('update-information');
            },
        }
    }
</script>

<style scoped>

</style>
