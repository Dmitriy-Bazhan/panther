<template>
    <div class="pt-filters">
        <div class="pt-filter">
            <div class="pt-filter--inner">
                <div class="pt-filter--title">
                    Preis
                </div>
                <div class="pt-range--slider">
                    <Slider v-model="priceValue"
                            :min="filters.prices.min_price"
                            :max="filters.prices.max_price"
                            tooltipPosition="bottom"
                            :format="format"
                    />
                    <div class="pt-range--slider-values">
                        <span>€{{priceValue[0]}}</span>
                        -
                        <span>€{{priceValue[1]}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Slider from '@vueform/slider'
import '@vueform/slider/themes/default.css'

export default {
    name: "Filters",
    components: {
        Slider,
    },
    props: ['filters'],
    data() {
        return {
            priceValue: [0, 0],
            format: function (value) {
                return `€${Math.round(value)}`
            },
        }
    },
    mounted() {
        this.priceValue[0] = this.filters.prices.min_price
        this.priceValue[1] = this.filters.prices.max_price
    }
}
</script>

<style scoped>

</style>
