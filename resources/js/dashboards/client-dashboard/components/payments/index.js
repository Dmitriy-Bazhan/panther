import template from './template.html';
import './style.css';

export default {
    name: "Payments",
    template: template,
    props: ['user', 'data'],
    data() {
        return {
            waiting_payments: [],
            break_payments: [],
            payed_payments: [],
            refuse_payments: [],
        }
    },
    mounted() {
        this.getClientPayments();
    },
    methods: {
        getClientPayments(){
            axios.get('/dashboard/client-payments?client_id=' + this.user.id)
                .then((response) => {
                    console.log(response);
                    if(response.data.success){
                        this.waiting_payments = response.data.waitingPayments.data;
                        console.log(this.waiting_payments);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }

}
