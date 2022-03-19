<template>
    <div>
        <h1>{{ $t('you_welcome') }}</h1>

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
    name: "YouWelcome",
    mounted() {
        this.emitter.emit('not-show-layouts');
        this.emitter.emit('not-show-left-panel');
    },
    methods: {
        toDashboard() {
            if (window.guard === 'client') {
                location.href = '/dashboard/client/my-information/';
            }

            if (window.guard === 'nurse') {
                location.href = '/dashboard/nurse/my-information/';
            }
        },
    }
}
</script>

<style scoped>

</style>
