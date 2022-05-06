<template>
    <div>
        <table>
            <thead>
            <tr>
                <th>{{ $t('id') }}</th>
                <th>{{ $t('data') }}</th>
                <th>{{ $t('is_show') }}</th>
                <th>{{ $t('action') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="hear_about_us.length > 0" v-for="item in hear_about_us">
                <td>{{ item.id }}</td>
                <td>
                    <input type="text" v-model="item.data[0].data">
                </td>
                <td>
                    <button v-if="item.is_show === 'yes'" class="btn btn-sm btn-success" v-on:click="changeShow(item)">
                        {{ $t(item.is_show) }}
                    </button>
                    <button v-else class="btn btn-sm btn-danger" v-on:click="changeShow(item)">{{ $t(item.is_show) }}
                    </button>
                </td>
                <td>
                    <button class="btn btn-sm btn-danger" v-on:click="removeYearAboutUs(item.id)">{{ $t('remove')}}
                    </button>
                </td>

            </tr>
            </tbody>
        </table>
        <div v-if="new_hear_about_us.length > 0" v-for="(item, index) in new_hear_about_us">
            <label class="col-form-label-sm" for="new_hear_about_us_data"></label>
            <input type="text" id="new_hear_about_us_data" v-model="new_hear_about_us[index].data">
            <button class="btn btn-sm btn-danger" v-on:click="removeItem(index)">{{ $t('remove') }}</button>
        </div>
        <button class="btn btn-sm btn-danger" v-on:click="addHearAboutUs()">{{ $t('add') }}</button>
        <br>
        <button class="btn btn-sm btn-success" v-on:click="setHearAboutUs()">{{ $t('save') }}</button>
    </div>
</template>

<script>
    export default {
        name: "HearAboutUs",
        props: ['user'],
        data() {
            return {
                hear_about_us: [],
                new_hear_about_us: [],
            }
        },
        mounted() {
            this.getHearAboutUs();
        },
        methods: {
            removeYearAboutUs(id) {
                axios.get('/dashboard/admin/remove-hear-about-us/' + id)
                    .then((response) => {
                        if(response.data.success){
                            this.emitter.emit('response-success-true');
                            this.getHearAboutUs();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            removeItem(index) {
                this.new_hear_about_us.splice(index, 1);
            },
            addHearAboutUs() {
                this.new_hear_about_us.push({
                    data: '',
                });
            },
            setHearAboutUs() {
                axios.post('/dashboard/admin/set-hear-about-us',
                    {
                        'hear_about_us': this.hear_about_us,
                        'lang': window.locale,
                        'new_hear_about_us': this.new_hear_about_us
                    })
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
                            this.getHearAboutUs();
                        } else {
                            console.log(response.data.errors);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            getHearAboutUs() {
                axios.get('/dashboard/admin/get-hear-about-us?lang=' + window.locale)
                    .then((response) => {
                        this.hear_about_us = response.data.hear_about_us;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            filterHearAboutUs(hear_about_as) {
                let lang = this.user.prefs.pref_lang;
                let el = hear_about_as.data.filter(function (value) {
                    if (value.lang == lang) {
                        return value;
                    }
                });
                return el[0].data;
            },
            changeShow(item) {
                axios.get('/dashboard/admin/change-hear-about-us-show/' + item.id)
                    .then((response) => {
                        if (response.data.success) {
                            item.is_show = response.data.is_show;
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
    .is-show-cell-item {
        cursor: pointer;
    }
</style>
