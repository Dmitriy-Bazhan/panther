<template>
    <div class="pt-filters">
        <div class="pt-filters--ctrl">
            <router-link class="pt-btn--border" to="/finder">
                <pt-icon type="left"></pt-icon>
                zurück zur Suche
            </router-link>
            <button class="pt-btn--primary" @click.prevent="filter">
                neue Suche
            </button>
        </div>

        <div class="pt-filter">
            <div class="pt-filter--inner">
                <div class="pt-filter--title">
                    Preis pro Stunde
                </div>
                <div class="pt-range--slider">
                    <Slider v-model="filtersSettings.price"
                            :min="filters.prices.min_price"
                            :max="filters.prices.max_price"
                            tooltipPosition="bottom"
                            :format="format"
                    />
                    <div class="pt-range--slider-values">
                        <span>€{{filtersSettings.price[0]}}</span>
                        -
                        <span>€{{filtersSettings.price[1]}}</span>
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
    props: ['filters', 'clear'],
    data() {
        return {
            filtersSettings: {
                price: [0, 0],
            },
            format: function (value) {
                return `€${Math.round(value)}`
            },
        }
    },
    mounted() {
        this.filtersSettings.price[0] = this.filters.prices.min_price
        this.filtersSettings.price[1] = this.filters.prices.max_price
    },
    watch: {
        clear: function (val){
            if(!val){
                this.filtersSettings.price[0] = this.filters.prices.min_price
                this.filtersSettings.price[1] = this.filters.prices.max_price
            }
        }
    },
    methods: {
        filter(){
            this.$emit('filter', this.filtersSettings)
        }
    }
}
</script>

<style scoped>

</style>
