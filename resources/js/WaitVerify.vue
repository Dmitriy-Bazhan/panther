<template>
    <div>
        <h1>{{ $t('email_wait_verify_text') }}</h1>

        <a href="/">HOME</a>
    </div>
</template>

<script>
export default {
    name: "WaitVerify",
    mounted() {
        this.emitter.emit('not-show-layouts');
    },
}
</script>

<style scoped>

</style>
