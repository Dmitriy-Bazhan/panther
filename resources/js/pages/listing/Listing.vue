<template>
    <div class="pt-finder">
        <div class="wrapper">
            <p class="pt-subtitle">
                <span>Suchen</span>
            </p>
            <h2 class="pt-title">
                LISTING
            </h2>

            <nurses-listing v-if="nurses" :nurses="nurses"></nurses-listing>
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
        'nurses-profile': NurseProfile,
    },
    data(){
        return {
            nurses: false
        }
    },
    mounted() {
        //console.log()
        this.nurses = JSON.parse(this.$route.params.data)
    }
}
</script>

<style scoped>

</style>
