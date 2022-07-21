<template>
    <div>
        <label>Card Holder Name</label>
        <input id="card-holder-name" type="text" v-model="name" class="form-control mb-2">

        <label>Card</label>
        <div id="card-element">

        </div>

        <button class="btn btn-primary mt-3" id="add-card-button" v-on:click="submitPaymentMethod()">
            Save Payment Method
        </button>
        <div class="mt-3 mb-3">
            OR
        </div>

        <div v-show="paymentMethodsLoadStatus === 2 && paymentMethods.length === 0" class="">
            No payment method on file, please add a payment method.
        </div>

        <div v-show="paymentMethodsLoadStatus === 2 && paymentMethods.length > 0">
            <div v-for="(method, key) in paymentMethods"
                 v-bind:key="'method-'+key"
                 v-on:click="paymentMethodSelected = method.id"
                 class="border rounded row p-1"
                 v-bind:class="{'bg-success text-light': paymentMethodSelected === method.id }">
                <div class="col-2">
                    {{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}
                </div>
                <div class="col-7">
                     **** **** **** {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}
                </div>
                <div class="col-3">
                    <span v-on:click.stop="removePaymentMethod( method.id )">Remove</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddCard",
        props: ['user', 'data'],
        data() {
            return {
                name: '',
                stripeAPIToken: '',
                intentToken: '',
                stripe: '',
                elements: '',
                card: '',
                addPaymentStatus: 0,
                addPaymentStatusError: '',
                paymentMethods: [],
                paymentMethodsLoadStatus: 0,
                paymentMethodSelected: {}
            }
        },
        mounted() {
            this.getStripeAPIToken();
            this.loadPaymentMethods();
        },
        methods: {
            submitPaymentMethod() {
                this.addPaymentStatus = 1;

                this.stripe.confirmCardSetup(
                    this.intentToken.client_secret, {
                        payment_method: {
                            card: this.card,
                            billing_details: {
                                name: this.name
                            }
                        }
                    }
                ).then(function (result) {
                    if (result.error) {
                        this.addPaymentStatus = 3;
                        this.addPaymentStatusError = result.error.message;
                    } else {
                        this.savePaymentMethod(result.setupIntent.payment_method);
                        this.addPaymentStatus = 2;
                        this.card.clear();
                        this.name = '';
                    }
                }.bind(this));
            },
            savePaymentMethod(method) {
                axios.post('/payment/method/store', {
                    payment_method: method
                }).then(function () {
                    this.loadPaymentMethods();
                }.bind(this));
            },
            loadPaymentMethods() {
                this.paymentMethodsLoadStatus = 1;

                axios.get('/payment/payment-methods')
                    .then(function (response) {
                        this.paymentMethods = response.data;
                        this.paymentMethodsLoadStatus = 2;
                    }.bind(this));
            },
            removePaymentMethod(paymentID) {
                axios.post('/payment/method/remove', {
                    id: paymentID
                }).then(function (response) {
                    this.loadPaymentMethods();
                }.bind(this));
            },
            getStripeAPIToken() {
                axios.get('/payment/get-stripe-api-token')
                    .then((response) => {
                        if (response.data.success) {
                            this.stripeAPIToken = response.data.stripeAPIToken;
                            this.intentToken = response.data.intentToken;
                            this.includeStripe('js.stripe.com/v3/', function () {
                                this.configureStripe();
                            }.bind(this));
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            includeStripe(URL, callback) {
                let documentTag = document, tag = 'script',
                    object = documentTag.createElement(tag),
                    scriptTag = documentTag.getElementsByTagName(tag)[0];
                object.src = '//' + URL;
                if (callback) {
                    object.addEventListener('load', function (e) {
                        callback(null, e);
                    }, false);
                }
                scriptTag.parentNode.insertBefore(object, scriptTag);
            },
            configureStripe() {
                this.stripe = Stripe(this.stripeAPIToken);

                this.elements = this.stripe.elements();
                this.card = this.elements.create('card');

                this.card.mount('#card-element');
            },
        }

    }
</script>

<style scoped>

</style>
