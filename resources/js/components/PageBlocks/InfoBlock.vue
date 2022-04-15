<template>
    <section class="pt-section-register" v-if="blockData">
        <div class="main-wrapper">
            <div class="pt-section-register--items">
                <div class="pt-section-register--item">
                    <img src="/images/fake/nurse.png" alt="" class="pt-section-register--item-img">
                    <p class="pt-block-heading">
                        {{blockData.nurseTitle}}
                    </p>
                    <p class="pt-section-register--item-text">
                        {{blockData.nurseText}}
                    </p>

                    <a href="" class="pt-btn pt-lg">Registrieren</a>
                </div>
                <div class="pt-section-register--item">
                    <img src="/images/fake/old.png" alt="" class="pt-section-register--item-img">
                    <p class="pt-block-heading">
                        {{blockData.clientTitle}}
                    </p>
                    <p class="pt-section-register--item-text">
                        {{blockData.clientText}}
                    </p>

                    <a href="" class="pt-btn pt-lg">Registrieren</a>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "InfoBlock",
    props: ['blockData'],
    mounted() {
        console.log(this.blockData)
    }
}
</script>

<style scoped>

</style>
