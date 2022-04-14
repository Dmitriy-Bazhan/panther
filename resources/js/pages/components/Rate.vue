<template>
    <div class="rate-wrapper" :title="user.rate.real + '(' + user.rate.count + ')'">
        <span v-for="index in [1,2,3,4,5]">
        <i class="ti-star"
           v-on:click="setTheRate(index)"
           :style="{'background-color': user.rate.round >= index ? '#e6f326' : '#6B9BF3'}"
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
    .rate-wrapper {
        z-index: 200;
    }

    .ti-star {
        cursor: pointer;
    }
</style>
