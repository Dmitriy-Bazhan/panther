<template>
    <div v-if="payment">
        <h3 class="pt-mb-10">Pay by PayPal</h3>

        <a class="pt-btn pt-sm" v-on:click="toPaypal()">Pay {{ payment.sum }} EUR</a>
    </div>
</template>

<script>
    export default {
        name: "PayPal",
        props: ['payment'],
        mounted() {
            console.log(this.payment);
        },
        methods: {
            toPaypal(){
                let url = '/paypal/process-transaction' + '?payment_id=' + this.payment.id;
                window.location.href = url;
            }
        }
    }
</script>

<style scoped>

</style>
