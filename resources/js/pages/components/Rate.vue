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
        mounted() {
            console.log(this.user.rate);
        },
        methods: {
            setTheRate(index) {
                let newRate = {
                    user_id: this.user.id,
                    new_rate: index,
                };

                axios.post('/set-user-rate', {'new_rate': newRate})
                    .then((response) => {
                        console.log(response.data.newRate);
                        this.user.rate.round = index;
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
