<template>
    <h5>Site settings</h5>
    <label for="site_email" class="col-form-label-sm">{{ $t('site_email') }}</label>
    <input id="site_email" class="form-control form-control-sm" type="text"
           v-model="site_settings['site_email']">

    <label for="listing_paginate" class="col-form-label-sm">{{ $t('listing_paginate') }}</label>
    <input id="listing_paginate" class="form-control form-control-sm" type="number" min="1"
           v-model="site_settings['listing_paginate']">

    <label for="facebook_link" class="col-form-label-sm">{{ $t('facebook_link') }}</label>
    <input id="facebook_link" class="form-control form-control-sm" type="text"
           v-model="site_settings['facebook_link']">

    <label for="twitter_link" class="col-form-label-sm">{{ $t('twitter_link') }}</label>
    <input id="twitter_link" class="form-control form-control-sm" type="text"
           v-model="site_settings['twitter_link']">

    <label for="instagram_link" class="col-form-label-sm">{{ $t('instagram_link') }}</label>
    <input id="instagram_link" class="form-control form-control-sm" type="text"
           v-model="site_settings['instagram_link']">

    <button class="btn btn-sm btn-success" v-on:click="setSiteSettings()">{{ $t('save') }}</button>
</template>

<script>
    export default {
        name: "SiteSettings",
        props: ['user'],
        data() {
            return {
                site_settings: [],
            }
        },
        mounted() {
            this.getSiteSettings();
        },
        methods: {
            getSiteSettings() {
                axios.get('/dashboard/admin/get-site-settings')
                    .then((response) => {
                        this.site_settings = response.data.site_settings;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            setSiteSettings() {
                axios.post('/dashboard/admin/set-site-settings', {'site_settings': this.site_settings})
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('response-success-true');
                        } else {
                            console.log(response.data.errors);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
        }
    }
</script>

<style scoped>

</style>
