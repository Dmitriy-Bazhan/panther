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
        let self = this

        axios.get('/listing/' + this.$store.state.user.entity_id)
            .then((response) => {
                console.log(response.data)
                // if(response.data.success && response.data.nurses.data.length > 0){
                //     self.nurses = response.data.nurses
                //     self.filters = response.data.filters
                // }
                // else{
                //     self.$router.push({ name: 'Finder' })
                // }
            })
            .catch((error) => {
                console.log(error);
            });
    }
}
</script>

<style scoped>

</style>
