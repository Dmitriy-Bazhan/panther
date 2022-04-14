<template>
    <div>
        <h3>Temporary component, whose simulate pay terminal</h3>
        <p>{{ payment.id }} </p>
        <button class="btn btn-sm btn-success" v-on:click="pay()">Pay</button>
    </div>
</template>

<script>
    export default {
        name: "PayTemporary",
        props: ['payment'],
        methods: {
            pay(){
                axios.put('/dashboard/client-payments/' + this.payment.id)
                    .then((response) => {
                        if(response.data.success){
                            this.emitter.emit('temporary-pay');
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
