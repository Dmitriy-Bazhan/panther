<template>
    <div>
        <h5>Card 1</h5>

        <div class="row">
            <div class="col-8">
                <add_card :user="user" :data="data"></add_card>
            </div>

        </div>

        <div class="row">
            <div class="col-8">
                <pay_pal :payment="payment"></pay_pal>
            </div>
        </div>


        <h3>{{ $t('payment_wait') }}</h3>

        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Sum</th>
                <th>Nurse</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="waiting_payments.length > 0" v-for="payment in waiting_payments">
                <td>{{ payment.id }}</td>
                <td>{{ payment.sum }}</td>
                <td>{{ payment.booking.nurse.first_name + ' ' + payment.booking.nurse.last_name}}</td>
                <td>{{ payment.date }}</td>
                <td>
                    <button class="btn btn-sm btn-success" v-on:click="showPaymentTemporary(payment)">{{ $t('pay') }}</button>
                    <button class="btn btn-sm btn-success" v-on:click="showBooking(payment.booking)">{{ $t('show-booking') }}</button>
                    <button class="btn btn-sm btn-success" v-on:click="showPayment(payment)">{{ $t('show-payment') }}</button>
                </td>
            </tr>
            </tbody>
        </table>

        <h3>{{ $t('payment_payed') }}</h3>

        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Sum</th>
                <th>Nurse</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="payed_payments.length > 0" v-for="payment in payed_payments">
                <td>{{ payment.id }}</td>
                <td>{{ payment.sum }}</td>
                <td>{{ payment.booking.nurse.first_name + ' ' + payment.booking.nurse.last_name}}</td>
                <td>{{ payment.date }}</td>
                <td>
                    <button class="btn btn-sm btn-success" v-on:click="showBooking(payment.booking)">{{ $t('show-booking') }}</button>
                    <button class="btn btn-sm btn-success" v-on:click="showPayment(payment)">{{ $t('show-payment') }}</button>
                </td>
            </tr>
            </tbody>
        </table>

        <h3>{{ $t('break_payments') }}<span class="dev-temporary-notification">Payment, when client payed, but nurse refuse booking or cant execute booking</span></h3>

        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Sum</th>
                <th>Nurse</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="break_payments.length > 0" v-for="payment in break_payments">
                <td>{{ payment.id }}</td>
                <td>{{ payment.sum }}</td>
                <td>{{ payment.booking.nurse.first_name + ' ' + payment.booking.nurse.last_name}}</td>
                <td>{{ payment.date }}</td>
                <td>
                    <button class="btn btn-sm btn-success">{{ $t('pay') }}</button>
                    <button class="btn btn-sm btn-success" v-on:click="showBooking(payment.booking)">{{ $t('show-booking') }}</button>
                    <button class="btn btn-sm btn-success" v-on:click="showPayment(payment)">{{ $t('show-payment') }}</button>
                </td>
            </tr>
            </tbody>
        </table>

        <h3>{{ $t('refuse_payments') }}<span class="dev-temporary-notification">Payments, when client refuse payment( temporary)</span></h3>

        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Sum</th>
                <th>Nurse</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="break_payments.length > 0" v-for="payment in break_payments">
                <td>{{ payment.id }}</td>
                <td>{{ payment.sum }}</td>
                <td>{{ payment.booking.nurse.first_name + ' ' + payment.booking.nurse.last_name}}</td>
                <td>{{ payment.date }}</td>
                <td>
                    <button class="btn btn-sm btn-success">{{ $t('pay') }}</button>
                    <button class="btn btn-sm btn-success" v-on:click="showBooking(payment.booking)">{{ $t('show-booking') }}</button>
                    <button class="btn btn-sm btn-success" v-on:click="showPayment(payment)">{{ $t('show-payment') }}</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-if="show_booking" class="show-booking-wrapper">
            <div class="container-fluid">
                <h2>{{ $t('booking_from_nurse') + ': ' + booking.nurse.first_name + ' ' + booking.nurse.last_name}}</h2>
                <div class="row">
                    <div class="col-2 offset-10">
                        <button class="btn btn-sm btn-success" v-on:click="closeModal()">{{ $t('close') }}</button>
                    </div>

                </div>
                <br>
                <div class="row">
                    <show_booking :booking="booking"></show_booking>
                </div>
            </div>
        </div>

        <div v-if="show_payment" class="show-booking-wrapper">
            <div class="container-fluid">
                <h2>{{ $t('booking_from_nurse') + ': ' + payment.booking.nurse.first_name + ' ' + payment.booking.nurse.last_name}}</h2>
                <div class="row">
                    <div class="col-2 offset-10">
                        <button class="btn btn-sm btn-success" v-on:click="closeModal()">{{ $t('close') }}</button>
                    </div>

                </div>
                <br>
                <div class="row">
                    <show_payment :payment="payment"></show_payment>
                </div>
            </div>
        </div>

        <div v-if="show_pay_temporary" class="show-booking-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2 offset-10">
                        <button class="btn btn-sm btn-success" v-on:click="closeModal()">{{ $t('close') }}</button>
                    </div>

                </div>
                <br>
                <div class="row">
                    <pay_payment :payment="payment"></pay_payment>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ShowBooking from "../bookings/ShowBooking";
import ShowPayment from "./ShowPayment";
import PayPayment from "./PayPayment";
import PayPal from "./PayPal";
import AddCard from "./AddCard";

export default {
    name: "Payments",
    components: {
        show_booking: ShowBooking,
        show_payment: ShowPayment,
        pay_payment: PayPayment,
        add_card: AddCard,
        pay_pal: PayPal,
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


            payments_wait_sum: 0,
            payments_payed_sum: 0,
            status: 'payed',
            search: '',
            activeTab: 'payed',
            payments: [],
            pagination: false,
            ctrl: {
                wait: [
                    // 'show_booking_edit',
                    // 'show_feedback',
                    // 'complaint',
                    // 'show_alternative',
                    // 'show_chat',
                    // 'show_remove_confirm',
                    // 'show_refused_booking',
                ],
                payed: [
                    // 'show_booking',
                    // 'show_chat',
                    // 'show_pay_payment',
                    // 'show_feedback',
                    // 'complaint',
                ],
                refuse: [
                    // 'show_booking_edit',
                    // 'show_remove_confirm',
                    // 'show_booking',
                    // 'show_chat',
                    // 'show_feedback',
                    // 'complaint',
                ],
                break: [
                    // 'show_booking_edit',
                    // 'show_remove_confirm',
                    // 'show_booking',
                    // 'show_chat',
                    // 'show_feedback',
                    // 'complaint',
                ],
            }
        }
    },
    mounted() {
        //this.getClientPayments();
        this.getPayments();
        this.emitter.on('temporary-pay', e =>{
            this.closeModal();
            this.getClientPayments();
        });
    },
    methods: {
        getPayments(link) {
            //status = wait, payed ...
            //status_of_view = 'yes' or 'no'; for admin, does he watched this payment or not

            let page = 1
            if (link) {
                let linkUrl = new URL(link.url);
                page = linkUrl.searchParams.get('page')
            }

            let url = '/dashboard/client-payments?client_id='
                + this.user.id
                + '&page=' + page
                + '&status=' + this.activeTab
                + '&search=' + this.search;

            // let query_string = '?status=' + this.status + '&status_of_view=' + this.status_of_view;

            axios.get(url)
                .then((response) => {
                    console.log(response)
                    if (response.data.success) {
                        this.payments = response.data.payments.data;
                        this.payments_wait_sum = response.data.payments_wait_sum;
                        this.payments_payed_sum = response.data.payments_payed_sum;
                        this.pagination = response.data.payments.meta.links;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
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

</script>

<style scoped>
table {
    margin-bottom: 50px;
}
</style>
