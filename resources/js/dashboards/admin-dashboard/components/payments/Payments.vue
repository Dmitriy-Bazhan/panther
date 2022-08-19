<template>
    <div>
        Payments
    </div>
</template>

<script>
    export default {
        name: "Payments",
        data() {
            return {
                status_of_view: false,
                status: false,
            }
        },
        mounted() {
            this.getPayments();
            this.getPayment();
        },
        methods: {
            getPayments() {
                //status = wait, payed ...
                //status_of_view = 'yes' or 'no'; for admin, does he watched this payment or not
                let query_string = '?status=' + this.status + '&status_of_view=' + this.status_of_view;
                axios.get('/dashboard/admin/get-payments' + query_string)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            getPayment() {
                axios.get('/dashboard/admin/get-payment/' + 4)
                    .then((response) => {
                        console.log(response);
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
