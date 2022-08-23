<template>
    <div>
        <h2 class="pt-block-heading">Payments method</h2>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-group">
                <label class="pt-box">
                    <input type="radio" name="methods" value="stripe" v-model="payment_method">
                    <span class="pt-box--body"></span>
                    <span class="pt-box--label">Stripe</span>
                </label>
            </div>
            <div class="pt-finder--form-group">
                <label class="pt-box">
                    <input type="radio" name="methods" value="paypal" v-model="payment_method">
                    <span class="pt-box--body"></span>
                    <span class="pt-box--label">PayPal</span>
                </label>
            </div>

            <div class="pt-finder--form-group" v-show="payment_method === 'stripe'">
                <add_card :user="user" :data="data"></add_card>
            </div>

            <div class="pt-finder--form-group" v-show="payment_method === 'paypal'">
                You can go to paypal page when you start to pay
            </div>
        </div>


        <div class="pt-table--head">
            <div class="pt-messages--tabs">
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'wait'}"
                        @click.prevent="activateTab('wait')">
                    <!--                {{ $t('not_approved_bookings') }}-->
                    Wait
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'payed'}"
                        @click.prevent="activateTab('payed')">
                    <!--                {{ $t('all') }}-->
                    Payed
                </button>
            </div>

            <pt-search class="pt-ml-a"></pt-search>
        </div>

        <div class="pt-table--container">
            <div class="pt-table" v-if="payments.length > 0">
                <div class="pt-table--heading">
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('Name') }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('sum') }}
                        </div>
                    </div>
                    <div v-if="activeTab === 'payed'" class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('method') }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('Laufzeit') }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('order_number') }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('Status') }}
                        </div>
                    </div>
                </div>
                <div class="pt-table--row" v-for="(payment, index) in payments">
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <div class="pt-table--number">
                                {{ index + 1 }}
                            </div>
                            <div>
                                {{ payment.booking.client.first_name + ' ' + payment.booking.client.last_name }}
                            </div>
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <pt-icon type="card"></pt-icon>
                            {{ payment.sum }}€
                        </div>
                    </div>
                    <div v-if="payment.status === 'payed'" class="pt-table--col">
                        <div class="pt-table--text">
                            {{ payment.method }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <pt-icon type="calendar"></pt-icon>
                            <template v-if="payment.status == 'payed'">
                                {{ payment.updated_at }}
                            </template>
                            <template v-else>
                                {{ payment.updated_at }}
                            </template>
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <pt-icon type="calendar"></pt-icon>
                            {{ payment.id }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--ctrl">
                            <div class="pt-status" :class="payment.status">
                                {{ $t(payment.status) }}
                            </div>

                            <pt-menu>
                                <template v-for="item in ctrl[payment.status]" :key="item">
                                    <div class="pt-table--ctrl-group" v-show="item === 'show_booking'">
                                        <button class="pt-btn"
                                                @click.prevent="openPopup('show_booking', payment.booking)">
                                            {{ $t('show-booking') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group" v-show="item === 'show_booking'">
                                        <button class="pt-btn"
                                                @click.prevent="openPopup('show_payment', false, payment)">
                                            {{ $t('show-payment') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group" v-show="item === 'show_pay_temporary'">
                                        <button class="pt-btn"
                                                @click.prevent="openPopup('show_pay_temporary', false, payment)">
                                            {{ $t('pay') }}
                                        </button>
                                    </div>
                                </template>
                            </pt-menu>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="" v-else>
                No payments
            </h2>

            <div class="pt-pagination" v-if="payments.length > 0">
                <a href="" class="pt-pagination--link"
                   v-for="(link, index) in pagination"
                   @click.prevent="getPayment(link)"
                   :class="{active: link.active}"
                >
                    <i class="fa-solid fa-angle-left" v-if="index === 0"></i>
                    <i class="fa-solid fa-angle-right" v-else-if="index === pagination.length-1"></i>
                    <template v-else>{{ link.label }}</template>
                </a>
            </div>
        </div>



        <!--        show_booking-->
        <Modal
            v-model="modal.show_booking"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner" v-if="booking">
                    <h2>
                        {{ $t('booking_from_nurse') + ': ' + booking.nurse.first_name + ' ' + booking.nurse.last_name }}
                    </h2>

                    <show_booking :booking="booking"></show_booking>
                </div>
            </div>
        </Modal>

        <!--        show_payment-->
        <Modal
            v-model="modal.show_payment"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner" v-if="payment">
                    <show_payment :payment="payment"></show_payment>
                </div>
            </div>
        </Modal>

        <!--        show_pay_temporary-->
        <Modal
            v-model="modal.show_pay_temporary"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">
                    <pay_payment :payment="payment" v-if="payment_method === 'stripe'"></pay_payment>

                    <pay_pal :payment="payment" v-if="payment_method === 'paypal'"></pay_pal>
                </div>
            </div>
        </Modal>
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



            modal: {
                show_booking: false,
                show_payment: false,
                show_pay_temporary: false,
            },

            payments_wait_sum: 0,
            payments_payed_sum: 0,
            payment_method: 'stripe',
            status: 'wait',
            search: '',
            activeTab: 'wait',
            payments: [],
            pagination: false,
            ctrl: {
                wait: [
                    'show_booking',
                    'show_payment',
                    'show_pay_temporary',
                ],
                payed: [
                    'show_booking',
                    'show_payment',
                ],
            }
        }
    },
    mounted() {
        //this.getClientPayments();
        this.getPayments();
        this.emitter.on('temporary-pay', e => {
            this.closeModal();
            this.getClientPayments();
        });

        this.emitter.on('pt-search', (e) => {
            this.search = e
            this.getPayments()
        })

        this.emitter.on('close-modal', (e) => {
            this.closePopup();
        });
    },
    methods: {
        closePopup() {
            let self = this;
            self.booking = null;
            self.payment = null;
            _.forEach(self.modal, function (item, key) {
                self.modal[key] = false;
            });
        },
        openPopup(id, booking, payment){
            this.modal[id] = true
            this.booking = booking;
            this.payment = payment;
        },
        activateTab(n) {
            this.activeTab = n;
            this.search = '';
            this.getPayments();
        },
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
