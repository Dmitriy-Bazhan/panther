<template>
    <div>
        <div class="pt-table--head">
            <div class="pt-messages--tabs">
                <button class="pt-messages--tabs-btn">
                    <!--                {{ $t('all') }}-->
                    Payed sum : {{ payments_payed_sum }}
                </button>
                <button class="pt-messages--tabs-btn">
                    <!--                {{ $t('not_approved_bookings') }}-->
                    Wait sum : {{ payments_wait_sum}}
                </button>
            </div>
        </div>

        <div class="pt-table--head">
            <div class="pt-messages--tabs">
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'payed'}"
                        @click.prevent="activateTab('payed')">
                    <!--                {{ $t('all') }}-->
                    Payed
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'wait'}"
                        @click.prevent="activateTab('wait')">
                    <!--                {{ $t('not_approved_bookings') }}-->
                    Wait
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'refuse'}"
                        @click.prevent="activateTab('refuse')">
                    <!--                {{ $t('approved_bookings') }}-->
                    Refuse
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'break'}"
                        @click.prevent="activateTab('break')">
                    <!--                {{ $t('in_process_bookings') }}-->
                    Break
                </button>
                <!--                <button class="pt-messages&#45;&#45;tabs-btn" :class="{active: activeTab === 'not_pass'}"-->
                <!--                        @click.prevent="activateTab('not_pass')">-->
                <!--                    &lt;!&ndash;                {{ $t('ended_bookings') }}&ndash;&gt;-->
                <!--                    Not Pass-->
                <!--                </button>-->
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
                            <pt-icon type="sum"></pt-icon>
                            {{ payment.sum }}
                        </div>
                    </div>
                    <div v-if="payment.status === 'payed'" class="pt-table--col">
                        <div class="pt-table--text">
                            <pt-icon type="pin"></pt-icon>
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
                        <div class="pt-table--ctrl">
                            <div class="pt-status" :class="payment.status">
                                {{ $t(payment.status) }}
                            </div>

                            <pt-menu>
                                <template v-for="item in ctrl[payment.status]" :key="item">

                                    <!--                                    <template>-->
                                    <!--                                        <div class="pt-table&#45;&#45;ctrl-group" v-show="item === 'show_booking_edit'">-->
                                    <!--                                            <button class="pt-btn" @click.prevent="openPopup('show_booking_edit', booking)">-->
                                    <!--                                                Details-->
                                    <!--                                            </button>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="pt-table&#45;&#45;ctrl-group" v-show="item === 'show_feedback'">-->
                                    <!--                                            <button class="pt-btn" @click.prevent="openPopup('show_feedback', false, booking.nurse)">-->
                                    <!--                                                comment-->
                                    <!--                                            </button>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="pt-table&#45;&#45;ctrl-group" v-show="item === 'complaint'">-->
                                    <!--                                            <button class="pt-btn" @click.prevent="openPopup('complaint', false, booking.nurse)">-->
                                    <!--                                                {{ $t('complaint') }}-->
                                    <!--                                            </button>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="pt-table&#45;&#45;ctrl-group" v-show="item === 'show_alternative'"-->
                                    <!--                                             v-if="booking.have_alternative === 'yes'">-->
                                    <!--                                            <button class="pt-btn"-->
                                    <!--                                                    @click.prevent="openPopup('show_alternative', booking)">-->
                                    <!--                                                {{ $t('show_alternative') }}-->
                                    <!--                                            </button>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="pt-table&#45;&#45;ctrl-group" v-show="item === 'show_chat'">-->
                                    <!--                                            <button class="pt-btn" @click.prevent="openPopup('show_chat', false, booking.nurse)">-->
                                    <!--                                                {{ $t('send_message') }}-->
                                    <!--                                            </button>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="pt-table&#45;&#45;ctrl-group" v-show="item === 'show_remove_confirm'">-->
                                    <!--                                            <button class="pt-btn" @click.prevent="openPopup('show_remove_confirm', booking)">-->
                                    <!--                                                {{ $t('remove') }}-->
                                    <!--                                            </button>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="pt-table&#45;&#45;ctrl-group" v-show="item === 'show_booking'">-->
                                    <!--                                            <button class="pt-btn" @click.prevent="openPopup('show_booking', booking)">-->
                                    <!--                                                {{ $t('show') }}-->
                                    <!--                                            </button>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="pt-table&#45;&#45;ctrl-group" v-show="item === 'show_pay_payment'">-->
                                    <!--                                            <button class="pt-btn" @click.prevent="openPopup('show_pay_payment', booking)">-->
                                    <!--                                                {{ $t('pay') }}-->
                                    <!--                                            </button>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="pt-table&#45;&#45;ctrl-group"-->
                                    <!--                                             v-if="booking.nurse_is_refuse_booking === 'yes'"-->
                                    <!--                                             v-show="item === 'show_refused_booking'">-->
                                    <!--                                            <button class="btn btn-sm btn-danger" @click.prevent="openPopup('show_refused_booking', booking)">-->
                                    <!--                                                {{ $t('nurse_refuse_booking') }}-->
                                    <!--                                            </button>&nbsp;-->
                                    <!--                                        </div>-->
                                    <!--                                    </template>-->
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
    </div>
</template>

<script>
export default {
    name: "Payments",
    data() {
        return {
            status_of_view: false,
            status: 'payed',
            search: '',
            activeTab: 'payed',
            payments: [],
            payments_wait_sum: 0,
            payments_payed_sum: 0,
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
        this.getPayments();
    },
    methods: {
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

            let url = '/dashboard/admin/get-payments'
                + '?page=' + page
                + '&status=' + this.activeTab
                + '&search=' + this.search;

            // let query_string = '?status=' + this.status + '&status_of_view=' + this.status_of_view;

            axios.get(url)
                .then((response) => {
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
.pt-messages--tabs {
    width: 70%;
}

.pt-messages--tabs-btn {
    width: auto;
    display: inline-flex;
    padding: 0 20px;
    white-space: nowrap;
}
</style>
