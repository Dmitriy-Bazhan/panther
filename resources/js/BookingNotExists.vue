<template>
    <div>
        <h1>{{ $t('booking_not_exists') }}</h1>

        <div class="container-fluid">
            <div class="row">
                <div class="col-4 offset-4 btn-group-vertical">

                    <button v-on:click="toBookings()" class="btn btn-lg btn-primary">{{ $t('to_bookings') }}</button>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "BookingNotExists",
        mounted() {
            this.emitter.emit('not-show-layouts');
            this.emitter.emit('not-show-left-panel');
        },
        methods: {
            toBookings() {
                location.href = '/dashboard/client/bookings';
            },
        }
    }
</script>

<style scoped>

</style>
