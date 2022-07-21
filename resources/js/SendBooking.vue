<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 offset-3">
                    {{ $t('send_booking_message') }}
            </div>
        </div>
        <div class="row">
            <div class="col-2 offset-4">
                <a href="/">HOME</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SendBooking",
        mounted() {
            this.emitter.emit('not-show-layouts');
            this.emitter.emit('not-show-left-panel');
        }
    }
</script>

<style scoped>
</style>
