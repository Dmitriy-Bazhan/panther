<template>
<!--    <div class="pt-rate">-->
<!--        <span v-for="index in 5">-->
<!--            <i class="fa-solid fa-star"-->
<!--               @click="setTheRate(index)"-->
<!--               :style="{'color': user.rate.round >= index ? '#ff9600' : '#c8d8dc'}"-->
<!--            ></i>-->
<!--        </span>-->
<!--    </div>-->
    <div class="pt-rate">
        <span v-for="index in 5">
            <i class="fa-solid fa-star"
               @click="update(index)"
               :style="{'color': val >= index ? '#ff9600' : '#c8d8dc'}"
            ></i>
        </span>

    </div>
</template>

<script>
    export default {
        name: "Rate",
        props: ['rate', 'modelValue'],
        emits: ['update:modelValue'],
        data(){
            return {
                val: 0
            }
        },
        mounted() {
            if(this.modelValue){
                console.log('modelValue')
                this.val = this.modelValue
            }
            if(this.rate){
                console.log('rate')
                this.val = this.rate
            }
        },
        methods: {
            update(e){
                if(this.modelValue !== undefined){
                    this.val = e
                    this.$emit("update:modelValue", e);
                }
            },
            setTheRate(index) {
                // let newRate = {
                //     user_id: this.user.id,
                //     new_rate: index,
                // };
                // axios.post('/set-user-rate', {'new_rate': newRate})
                //     .then((response) => {
                //         if (response.data.success) {
                //             this.user.rate.round = response.data.newRate.round;
                //             this.user.rate.real = response.data.newRate.real;
                //             this.user.rate.count = response.data.newRate.count;
                //         }
                //
                //     })
                //     .catch((error) => {
                //         console.log(error);
                //     });
            }
        }
    }

</script>

<style scoped>

</style>
