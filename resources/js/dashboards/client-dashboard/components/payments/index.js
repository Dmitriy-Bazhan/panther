import template from './template.html';
import ShowBooking from "../bookings/ShowBooking";
import ShowPayment from "./ShowPayment";
import './style.css';

export default {
    name: "Payments",
    template: template,
    components: {
        show_booking: ShowBooking,
        show_payment: ShowPayment,
    },
    props: ['user', 'data'],
    data() {
        return {
            waiting_payments: [],
            break_payments: [],
            payed_payments: [],
            refuse_payments: [],
            show_booking: false,
            show_payment: false,
            booking: null,
            payment: null,
        }
    },
    mounted() {
        this.getClientPayments();
    },
    methods: {
        closeModal() {
            this.show_booking = false;
            this.show_payment = false;
            this.booking = null;
            this.payment = null;
        },
        showBooking(booking) {
            this.show_booking = true;
            this.show_payment = false;
            this.payment = null;
            this.booking = booking;
        },
        showPayment(payment) {
            this.show_payment = true;
            this.show_booking = false;
            this.payment = payment;
            this.booking = null;
        },
        getClientPayments() {
            axios.get('/dashboard/client-payments?client_id=' + this.user.id)
                .then((response) => {
                    console.log(response);
                    if (response.data.success) {
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
