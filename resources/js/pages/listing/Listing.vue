<template>
    <div class="pt-finder">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>Suchen</span>
            </p>
            <h2 class="pt-title">
                LISTING
            </h2>

            <nurses-listing v-if="nurses" :nurses="nurses" :filters="filters"></nurses-listing>
        </div>
    </div>
</template>

<script>
import NursesListing from "./NursesListing";
import NurseProfile from "./NurseProfile";

export default {
    name: "Listing",
    components: {
        'nurses-listing': NursesListing,
    },
    data(){
        return {
            nurses: false,
            filters: false,
        }
    },
    mounted() {
        this.nurses = JSON.parse(this.$route.params.data)
        this.filters = JSON.parse(this.$route.params.filters)
    }
}
</script>

<style scoped>

</style>
