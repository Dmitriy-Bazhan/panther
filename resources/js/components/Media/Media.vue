<template>
    <div class="pt-media">
        <div class="pt-media--modal">
            <h1>Media</h1>
        </div>
    </div>
</template>

<script>
export default {
    name: "Media",
}
</script>

<style lang="scss" scoped>
    .pt-media{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 100;
        padding: 20px;
        background-color: rgba(0,0,0,0.3);

        &--modal{
            width: 90%;
            height: 90vh;
            margin: 5vh auto;
            background-color: white;
            padding: 30px;
            border-radius: 5px;
        }
    }
</style>
