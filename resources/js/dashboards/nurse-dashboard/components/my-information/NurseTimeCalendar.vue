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
            <div class="col-3 offset-3">
                <h5>{{ $t('weekdays') }}</h5>
                <div v-for="(item,index) in time_intervals">
                    <template v-if="item.type ==='weekdays'">
                        <h6>{{ item.interval }}</h6>
                        <input type="checkbox" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref[item.id]">

                        <hr>
                    </template>
                </div>
            </div>
            <div class="col-3">
                <h5>{{ $t('weekends') }}</h5>
                <div v-for="(item,index) in time_intervals">
                    <template v-if="item.type ==='weekends'">
                        <h6>{{ item.interval }}</h6>
                        <input type="checkbox" true-value="1" false-value="0"
                               v-model="user.entity.work_time_pref[item.id]">

                        <hr>
                    </template>
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
                time_intervals: [],
            }
        },
        mounted() {
            console.log(this.user);
            this.time_intervals = this.data['time_intervals'];
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
