<template>
    <div>
        <h1>{{ $t('booking_verify_ok') }}</h1>

        <div class="container-fluid">
            <div class="row">
                <div class="col-4 offset-4 btn-group-vertical">

                    <button v-on:click="toDashboard" class="btn btn-lg btn-primary">To Dashboard</button>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "BookingVerify",
        mounted() {
            this.emitter.emit('not-show-layouts');
            this.emitter.emit('not-show-left-panel');
        },
        methods: {
            toDashboard() {
                    location.href = '/';
            },
        }
    }
</script>

<style scoped>

</style>
