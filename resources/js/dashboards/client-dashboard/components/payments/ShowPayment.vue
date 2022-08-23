<template>
    <div>
        <div class="pt-finder--form-group" v-show="payment.booking.nurse">
            <p class="pt-form--label">
                Nurse name
            </p>
            <p class="pt-form--text">
                {{payment.booking.nurse.full_name}}
            </p>
        </div>
        <div class="pt-finder--form-group" v-show="payment.date">
            <p class="pt-form--label">
                date
            </p>
            <p class="pt-form--text">
                {{payment.date}}
            </p>
        </div>
        <div class="pt-finder--form-group" v-show="payment.status">
            <p class="pt-form--label">
                status
            </p>
            <p class="pt-form--text">
                {{payment.status}}
            </p>
        </div>
        <div class="pt-finder--form-group" v-show="payment.method">
            <p class="pt-form--label">
                method
            </p>
            <p class="pt-form--text">
                {{payment.method}}
            </p>
        </div>
        <div class="pt-finder--form-group" v-show="payment.sum">
            <p class="pt-form--label">
                sum
            </p>
            <p class="pt-form--text">
                {{payment.sum}}
                {{payment.currency}}
            </p>
        </div>


<!--        <pre>-->
<!--        {{ payment }}-->
<!--        </pre>-->
    </div>
</template>

<script>
    export default {
        name: "ShowPayment",
        props: ['payment'],
    }
</script>

<style scoped>

</style>
