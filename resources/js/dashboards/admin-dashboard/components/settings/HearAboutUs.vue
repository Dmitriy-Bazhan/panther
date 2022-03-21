<template>
    <div>
        <table>
            <thead>
            <tr>
                <th>{{ $t('id') }}</th>
                <th>{{ $t('data') }}</th>
                <th>{{ $t('other') }}</th>
                <th>{{ $t('is_show') }}</th>
            </tr>
            </thead>
            <tbody>
                <tr v-if="hear_about_us.length > 0" v-for="item in hear_about_us">
                    <th>{{ item.id }}</th>
                    <th>{{ filterHearAboutUs(item) }}</th>
                    <th>{{ item.other }}</th>
                    <th>
                        <span class="is-show-cell-item" v-on:click="changeShow(item)">{{ $t(item.is_show) }}</span>
                    </th>

                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "HearAboutUs",
        props: ['hear_about_us', 'user'],
        data() {
            return {

            }
        },
        mounted() {
        },
        methods: {
            filterHearAboutUs(hear_about_as){
                let lang = this.user.prefs.pref_lang;
                let el = hear_about_as.data.filter(function (value) {
                    if(value.lang == lang){
                        return value;
                    }
                });
                return el[0].data;
            },
            changeShow(item) {
                axios.get('/dashboard/admin/change-hear-about-us-show/' + item.id)
                    .then((response) => {
                        console.log(response.data);
                        if(response.data.success){
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
