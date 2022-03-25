<template>
    <div class="response-success-true-wrapper">
        <span>Request complete</span>
    </div>
</template>

<script>
    export default {
        name: "ResponseSuccessTrue"
    }
</script>

<style scoped>
    .response-success-true-wrapper {
        position: fixed;
        top: 90%;
        left: 2%;
        width: 200px;
        height: 50px;
        background: #1acd36;
        color: white;
        text-align: center;
        padding-top: 10px;
        border: solid 1px green;
        z-index: 100;
    }
</style>
