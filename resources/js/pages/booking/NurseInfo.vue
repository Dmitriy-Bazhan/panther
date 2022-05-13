<template>
    <div class="pt-nurse--info">
        <div class="pt-nurse--info-general">
            <div class="">
                <div class="pt-nurse--info-name">
                    {{ data.nurse.first_name }} <div>{{ data.nurse.last_name }}</div>.
                </div>
                <div class="pt-nurse--info-age">
                    {{ data.nurse.entity.age }} Jahre Alt
                </div>
            </div>
            <div class="pt-nurse--info-price">
                €{{ data.nurse.entity.price.hourly_payment }}/stunde
            </div>
        </div>

        <div class="pt-nurse--info-list">
            <div class="pt-nurse--info-list--item">
                <pt-icon type="phone"></pt-icon>
                <div class="">
                    <div class="pt-nurse--info-list--item-title">
                        {{data.nurse.phone}}
                    </div>
                </div>
            </div>
            <div class="pt-nurse--info-list--item">
                <pt-icon type="bar"></pt-icon>
                <div class="">
                    <div class="pt-nurse--info-list--item-title">
                        {{data.nurse.entity.available_care_range}}
                    </div>
                </div>
            </div>
            <div class="pt-nurse--info-list--item">
                <pt-icon type="email"></pt-icon>
                <div class="">
                    <div class="pt-nurse--info-list--item-title">
                        {{data.nurse.email}}
                    </div>
                </div>
            </div>
            <div class="pt-nurse--info-list--item">
                <pt-icon type="watch"></pt-icon>
                <div class="">
                    <div class="pt-nurse--info-list--item-title">
                        Verfügbarkeit: 5 Tage die Woche (07:00-21:00 Uhr)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-show="false">
        <h4>{{ $t('information') }}</h4>
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div>
                        <span class="name-of-info-item">{{ $t('name') }}</span>
                        <div>
                            <span class="info-item">{{ data.nurse.first_name + ' ' + data.nurse.last_name }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="name-of-info-item">{{ $t('contact_detail') }}</span>

                        <div><span class="info-item">{{ $t('phone') + ': ' + data.nurse.phone }}</span></div>
                        <div><span class="info-item">{{ $t('email') + ': ' + data.nurse.email }}</span></div>
                        <div><span class="info-item">{{ $t('zip_code') + ': ' + data.nurse.zip_code }}</span></div>
                    </div>

                    <div>
                        <span class="name-of-info-item">{{ $t('prices') }}</span>

                        <div>
                            <span class="info-item">{{ $t('hourly_payment') + ': ' + data.nurse.entity.price.hourly_payment }}</span>
                        </div>
                        <div>
                            <span class="info-item">
                                <span v-if="data.nurse.entity.price.holiday_surcharge ==='yes'">{{ $t('holiday_surcharge_payment') + ': ' + data.nurse.entity.price.holiday_surcharge_payment }}</span>
                                <span v-else>{{ $t('holiday_surcharge_payment') + ': 0' }}</span>
                            </span>
                        </div>
                        <div>
                            <span class="info-item">
                                <span v-if="data.nurse.entity.price.weekend_surcharge ==='yes'">{{ $t('weekend_surcharge_payment') + ': ' + data.nurse.entity.price.weekend_surcharge_payment }}</span>
                                <span v-else>{{ $t('weekend_surcharge_payment') + ': 0' }}</span>
                             </span>
                        </div>
                        <div>
                            <span class="info-item">
                                <span v-if="data.nurse.entity.price.fare_surcharge ==='yes'">{{ $t('fare_surcharge_payment') + ': ' + data.nurse.entity.price.fare_surcharge_payment }}</span>
                                <span v-else>{{ $t('fare_surcharge_payment') + ': 0' }}</span>
                            </span>
                        </div>
                    </div>

                </div>

                <div class="col-4">
                    <span class="name-of-info-item">{{ $t('needed_time') }}</span>

                    <div v-for="(item, index) in data.nurse.entity.work_time_pref">
                        <span class="info-item" v-if="item !== '0'">{{ $t(index) }}</span>
                    </div>

                    <span class="name-of-info-item">{{ $t('multiple_bookings') }}</span>
                    <div>
                        <span class="info-item">{{ $t(data.nurse.entity.multiple_bookings) }}</span>
                    </div>
                </div>

                <div class="col-4 nurse-profile-image-wrapper">
                    <img v-bind:src="path + '/storage/' + data.nurse.entity.original_photo" alt="no-photo"
                         class="nurse-profile-image">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NurseInfo",
        props: ['data'],
        data() {
            return {
                path: location.origin,
            }
        },
        watch: {
            data: {
                handler(newValue, oldValue) {
                    if (typeof this.data.nurse.entity.work_time_pref === "string") {
                        this.data.nurse.entity.work_time_pref = JSON.parse(this.data.nurse.entity.work_time_pref);
                    }
                },
                immediate: true
            },
        },
        mounted() {
            console.log(this.data.nurse);
        }
    }
</script>

<style scoped>
    .name-of-info-item {
        font-size: 14px;
        font-weight: 700;
    }

    .info-item {
        font-size: 14px;
        font-weight: 700;
        margin-left: 25px;
    }

    .nurse-profile-image-wrapper {
        padding: 10px;
        height: 180px;
    }

    .nurse-profile-image {
        width: 90%;
        height: 90%;
        object-fit: contain;
    }
</style>
