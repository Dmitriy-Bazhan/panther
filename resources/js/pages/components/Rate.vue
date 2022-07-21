<template>
    <div class="pt-rate" :title="user.rate.real + '(' + user.rate.count + ')'">
        <span v-for="index in [1,2,3,4,5]">
            <i class="fa-solid fa-star"
               v-on:click="setTheRate(index)"
               :style="{'color': user.rate.round >= index ? '#ff9600' : '#c8d8dc'}"
            ></i>
        </span>

    </div>
</template>

<script>
    export default {
        name: "Rate",
        props: ['user'],
        methods: {
            setTheRate(index) {
                let newRate = {
                    user_id: this.user.id,
                    new_rate: index,
                };
                axios.post('/set-user-rate', {'new_rate': newRate})
                    .then((response) => {
                        if (response.data.success) {
                            this.user.rate.round = response.data.newRate.round;
                            this.user.rate.real = response.data.newRate.real;
                            this.user.rate.count = response.data.newRate.count;
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
