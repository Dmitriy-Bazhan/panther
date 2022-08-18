<template>
    <div v-if="payment">
        <a class="btn btn-primary m-3" v-on:click="toPaypal()">{{ payment.sum }} EUR</a>
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
