<template>
    <h5>{{ $t('payment_api_settings') }}</h5>
    <h6>{{ $t('stripe')}}</h6>
    <label for="stripe_key" class="col-form-label-sm">{{ $t('stripe_key') }}</label>
    <input id="stripe_key" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['stripe_key']">

    <label for="stripe_secret" class="col-form-label-sm">{{ $t('stripe_secret') }}</label>
    <input id="stripe_secret" class="form-control form-control-sm" type="text" min="1"
           v-model="payment_api_settings['stripe_secret']">

    <label for="stripe_currency" class="col-form-label-sm">{{ $t('stripe_currency') }}</label>
    <input id="stripe_currency" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['stripe_currency']">
    <br>
    <br>
    <h6>{{ $t('paypal')}}</h6>
    <label for="paypal_mode" class="col-form-label-sm">{{ $t('paypal_mode') }}</label>
    <input id="paypal_mode" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_mode']">

    <label for="paypal_sandbox_client_id" class="col-form-label-sm">{{ $t('paypal_sandbox_client_id') }}</label>
    <input id="paypal_sandbox_client_id" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_sandbox_client_id']">

    <label for="paypal_sandbox_client_secret" class="col-form-label-sm">{{ $t('paypal_sandbox_client_secret') }}</label>
    <input id="paypal_sandbox_client_secret" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_sandbox_client_secret']">

    <label for="paypal_sandbox_app_id" class="col-form-label-sm">{{ $t('paypal_sandbox_app_id') }}</label>
    <input id="paypal_sandbox_app_id" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_sandbox_app_id']">

    <label for="paypal_live_client_id" class="col-form-label-sm">{{ $t('paypal_live_client_id') }}</label>
    <input id="paypal_live_client_id" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_live_client_id']">

    <label for="paypal_live_client_secret" class="col-form-label-sm">{{ $t('paypal_live_client_secret') }}</label>
    <input id="paypal_live_client_secret" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_live_client_secret']">

    <label for="paypal_live_app_id" class="col-form-label-sm">{{ $t('paypal_live_app_id') }}</label>
    <input id="paypal_live_app_id" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_live_app_id']">

    <label for="paypal_payment_action" class="col-form-label-sm">{{ $t('paypal_payment_action') }}</label>
    <input id="paypal_payment_action" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_payment_action']">

    <label for="paypal_currency" class="col-form-label-sm">{{ $t('paypal_currency') }}</label>
    <input id="paypal_currency" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_currency']">

    <label for="paypal_notify_url" class="col-form-label-sm">{{ $t('paypal_notify_url') }}</label>
    <input id="paypal_notify_url" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_notify_url']">

    <label for="paypal_locale" class="col-form-label-sm">{{ $t('paypal_locale') }}</label>
    <input id="paypal_locale" class="form-control form-control-sm" type="text"
           v-model="payment_api_settings['paypal_locale']">

    <label for="paypal_validate_ssl" class="col-form-label-sm">{{ $t('paypal_validate_ssl') }}</label>
    <select id="paypal_validate_ssl" class="form-control form-control-sm"
            v-model="payment_api_settings['paypal_validate_ssl']">
            <option value="1">{{ $t('true')}}</option>
            <option value="0">{{ $t('false')}}</option>
    </select>

    <button class="btn btn-sm btn-success" v-on:click="setPaymentApiSettings()">{{ $t('save') }}</button>
</template>

<script>
    export default {
        name: "PaymentApiSettings",
        data() {
            return {
                payment_api_settings: [],
            }
        },
        mounted() {
            this.getPaymentApiSettings();
        },
        methods: {
            getPaymentApiSettings() {
                axios.get('/dashboard/admin/get-payment-api-settings')
                    .then((response) => {
                        this.payment_api_settings = response.data.payment_api_settings;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            setPaymentApiSettings() {
                axios.post('/dashboard/admin/set-payment-api-settings', {'payment_api_settings': this.payment_api_settings})
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
