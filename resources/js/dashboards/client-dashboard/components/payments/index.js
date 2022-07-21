import template from './template.html';
import ShowBooking from "../bookings/ShowBooking";
import ShowPayment from "./ShowPayment";
import PayPayment from "./PayPayment";
import AddCard from "./AddCard";
import './style.css';

export default {
    name: "Payments",
    template: template,
    components: {
        show_booking: ShowBooking,
        show_payment: ShowPayment,
        pay_payment: PayPayment,
        add_card: AddCard,
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
            show_pay_temporary: false,
            booking: null,
            payment: null,
        }
    },
    mounted() {
        this.getClientPayments();

        this.emitter.on('temporary-pay', e =>{
            this.closeModal();
            this.getClientPayments();
        });
    },
    methods: {
        closeModal() {
            this.show_booking = false;
            this.show_payment = false;
            this.show_pay_temporary = false;
            this.booking = null;
            this.payment = null;
        },
        showPaymentTemporary(payment) {
            this.show_booking = false;
            this.show_payment = false;
            this.show_pay_temporary = true;
            this.booking = null;
            this.payment = payment;
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
                        this.payed_payments = response.data.payedPayments.data;
                        this.break_payments = response.data.breakPayments.data;
                        this.refuse_payments = response.data.refusePayments.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }

}
