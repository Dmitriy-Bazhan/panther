<template>
    <div v-if="time_intervals.length > 0" class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h5>{{ $t('weekdays') }}</h5>
                <div v-for="(item,index) in time_intervals">
                    <template v-if="item.type ==='weekdays'">
                        <h6>{{ item.interval }}</h6>
                        <div class="row">
                            <div class="col-6">
                                start:
                                <input class="form-control form-control-sm" type="number" v-model="item.start"
                                       :min="0" :max="item.end"
                                       v-on:change="changeValue(index)">
                            </div>
                            <div class="col-6">
                                end:
                                <input class="form-control form-control-sm" type="number" v-model="item.end"
                                       :min="item.start" :max="24"
                                       v-on:change="changeValue(index)">
                            </div>
                        </div>
                        <br>
                        <span class="time-interval-value" v-for="hour in item.value">{{ hour }}</span>

                        <hr>
                    </template>
                </div>
            </div>
            <div class="col-6">
                <h5>{{ $t('weekends') }}</h5>
                <div v-for="(item,index) in time_intervals">
                    <template v-if="item.type ==='weekends'">
                        <h6>{{ item.interval }}</h6>
                        <div class="row">
                            <div class="col-6">
                                start:
                                <input class="form-control form-control-sm" type="number" v-model="item.start"
                                       v-on:change="changeValue(index)">
                            </div>
                            <div class="col-6">
                                end:
                                <input class="form-control form-control-sm" type="number" v-model="item.end"
                                       :min="item.start"
                                       v-on:change="changeValue(index)">
                            </div>
                        </div>
                        <br>
                        <span class="time-interval-value" v-for="hour in item.value">{{ hour }}</span>

                        <hr>
                    </template>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <button class="btn btn-danger btn-sm" v-on:click="setDefaultTimeIntervals()">{{
                    $t('set_default_properties') }}
                </button>
            </div>
            <div class="col-4 offset-4">
                <button class="btn btn-success btn-sm" v-on:click="saveTimeIntervals()">{{ $t('save') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Input from "../../../../components/Input/Input";

    export default {
        name: "TimeIntervals",
        components: {Input},
        props: ['data'],
        data() {
            return {
                time_intervals: [],
            }
        },
        mounted() {
            this.time_intervals = this.data['time_intervals'];
        },
        methods: {
            changeValue(index) {
                this.time_intervals[index].interval = this.time_intervals[index].start + ':00-' + this.time_intervals[index].end + ':00';
                this.time_intervals[index].value = [];
                for (let i = this.time_intervals[index].start; i < this.time_intervals[index].end; i++) {
                    let value = i + ':00-' + (i + 1) + ':00';
                    this.time_intervals[index].value.push(value);
                }
            },
            saveTimeIntervals() {
                axios.post('set-time-intervals', {'time_intervals': this.time_intervals})
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            setDefaultTimeIntervals() {
                axios.get('set-default-time-intervals')
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
                            this.time_intervals = response.data.time_intervals;
                            this.$props.data['time_intervals'] = response.data.time_intervals;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }

        }
    }
</script>

<style scoped>
    .time-interval-value {
        padding: 5px;
        margin: 5px;
        background-color: orange;
        border: solid 1px darkorange;
        border-radius: 5px;
        font-weight: 600;
        color: black;
        font-size: 12px;
    }
</style>
