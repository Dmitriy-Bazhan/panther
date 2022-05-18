<template>
    <div>
        <h3>Choose pay methods, cards</h3>
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
            </div>
        </div>
        <button class="btn btn-sm btn-success" v-on:click="pay()">Pay</button>
        <button class="btn btn-sm btn-success" v-on:click="close()">Close</button>
    </div>
</template>

<script>
    export default {
        name: "PayPayment",
        props: ['payment'],
        data() {
            return {
                paymentMethods: [],
                paymentMethodsLoadStatus: 0,
                paymentMethodSelected: {}
            }
        },
        mounted() {
            this.loadPaymentMethods();
        },
        methods: {
            loadPaymentMethods() {
                this.paymentMethodsLoadStatus = 1;

                axios.get('/payment/payment-methods')
                    .then(function (response) {
                        this.paymentMethods = response.data;
                        this.paymentMethodsLoadStatus = 2;
                    }.bind(this));
            },
            pay(){
                axios.post('/payment/payment-pay' ,{
                    'payment_id' : this.payment.id,
                    'payment_method_id' : this.paymentMethodSelected
                })
                    .then((response) => {
                        if(response.data.success){
                            this.emitter.emit('close-modal');
                            this.emitter.emit('pay-payment');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            close() {
                this.emitter.emit('close-modal');
            }
        }
    }
</script>

<style scoped>

</style>
