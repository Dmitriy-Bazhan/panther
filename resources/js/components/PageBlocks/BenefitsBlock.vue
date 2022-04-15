<template>
    <section class="pt-section-benefits">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>vorteile</span>
            </p>
            <h2 class="pt-title">
                PflegePanther – wir stehen für freundliche und qualifizierte Pflege
            </h2>

            <div class="pt-row pt-section-benefits--items">
                <div class="pt-col-md-6" v-for="n in 4">
                    <div class="pt-section-benefits--item">
                        <div class="pt-section-benefits--item-title">
                            <div class="pt-section-benefits--item-icon">
                                <pt-icon type="decor"></pt-icon>
                            </div>
                            Geprüfte Qualität
                        </div>
                        <div class="pt-section-benefits--item-text">
                            Sämtliche der auf der Plattform registrierten Pflegekräfte wurden von unserem Team von Experten auf ihre nachweisbare Qualifikation hin geprüft
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "BenefitsBlock"
}
</script>

<style scoped>

</style>
