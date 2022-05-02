<template>
    <section class="pt-section-register" v-if="blockData">
        <div class="main-wrapper">
            <div class="pt-section-register--items">
                <div class="pt-section-register--item">
                    <img src="/images/fake/nurse.png" alt="" class="pt-section-register--item-img">
                    <p class="pt-block-heading" v-if="blockData.nurseTitle">
                        {{blockData.nurseTitle}}
                    </p>
                    <p class="pt-section-register--item-text" v-if="blockData.nurseText">
                        {{blockData.nurseText}}
                    </p>

                    <a href="" class="pt-btn pt-lg">Registrieren</a>
                </div>
                <div class="pt-section-register--item">
                    <img src="/images/fake/old.png" alt="" class="pt-section-register--item-img">
                    <p class="pt-block-heading" v-if="blockData.clientTitle">
                        {{blockData.clientTitle}}
                    </p>
                    <p class="pt-section-register--item-text" v-if="blockData.clientText">
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

    }
}
</script>

<style scoped>

</style>
