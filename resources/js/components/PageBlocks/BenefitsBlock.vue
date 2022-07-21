<template>
    <section class="pt-section-benefits" v-if="blockData">
        <div class="wrapper">
            <p class="pt-subtitle" v-if="blockData.subtitle">
                <span>{{blockData.subtitle}}</span>
            </p>
            <h2 class="pt-title" v-if="blockData.title">
                {{blockData.title}}
            </h2>

            <div class="pt-row pt-section-benefits--items" v-if="blockData.list.length > 0">
                <div class="pt-col-md-6" v-for="item in blockData.list">
                    <div class="pt-section-benefits--item">
                        <div class="pt-section-benefits--item-title">
                            <div class="pt-section-benefits--item-icon">
                                <pt-icon type="decor"></pt-icon>
                            </div>
                            {{item.title}}
                        </div>
                        <div class="pt-section-benefits--item-text">
                            {{item.text}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "BenefitsBlock",
    props: ['blockData'],
    mounted() {

    }
}
</script>

<style scoped>

</style>
