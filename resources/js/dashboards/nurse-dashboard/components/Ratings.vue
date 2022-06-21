<template>
    <div>
        <h1>Ratings</h1>
    </div>
</template>

<script>
    export default {
        name: "Ratings",
        mounted() {
            this.getFeedbackAndRatings();
        },
        methods: {
            getFeedbackAndRatings(){
                axios.get('/dashboard/nurse-ratings/get-feedback-and-ratings')
                    .then((response) => {
                        if(response.data.success){
                            console.log(response.data);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
