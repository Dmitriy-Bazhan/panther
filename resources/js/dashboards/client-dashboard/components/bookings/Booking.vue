<template>
    <div>
        <div class="pt-table--head">
            <div class="pt-messages--tabs">
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === ''}" @click.prevent="activateTab('')">
                    <!--                {{ $t('all') }}-->
                    All
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'not_approved'}" @click.prevent="activateTab('not_approved')">
                    <!--                {{ $t('not_approved_bookings') }}-->
                    Not approved
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'approved'}" @click.prevent="activateTab('approved')">
                    <!--                {{ $t('approved_bookings') }}-->
                    Approved
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'in_process'}" @click.prevent="activateTab('in_process')">
                    <!--                {{ $t('in_process_bookings') }}-->
                    In process
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'ended'}" @click.prevent="activateTab('ended')">
                    <!--                {{ $t('ended_bookings') }}-->
                    Ended
                </button>
            </div>

            <pt-search class="pt-ml-a"></pt-search>
        </div>

        <div class="pt-table--container">
            <div class="pt-table" v-if="bookings.length > 0">
                <div class="pt-table--heading">
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('Name') }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('Adresse') }}
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
                <div class="pt-table--row" v-for="(booking, index) in bookings">
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <div class="pt-table--number">
                                {{index + 1}}
                            </div>
                            <div>
                                {{ booking.nurse.full_name }}
                                <span>{{ booking.nurse.entity.age }} Jahre Alt</span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <pt-icon type="pin"></pt-icon>
                            12345 Berlin
                            Some Strasse 69
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <pt-icon type="calendar"></pt-icon>
                            {{ booking.start_date }}
                        </div>
                    </div>
                    <div class="pt-table--col">
                        <div class="pt-table--ctrl">
                            <div class="pt-status" :class="booking.status">
                                {{ $t(booking.status) }}
                            </div>

                            <pt-menu>
                                <template v-for="item in ctrl[booking.status]" :key="item">
                                    <template v-if="booking.is_verification ==='no'">
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_booking_edit'">
                                            <button class="pt-btn" @click.prevent="openPopup('show_booking_edit', booking)">
                                                Details
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_remove_confirm'">
                                            <button class="pt-btn" @click.prevent="openPopup('show_remove_confirm', booking)">
                                                {{ $t('remove') }}
                                            </button>
                                        </div>
                                    </template>

                                    <template v-else>
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_booking_edit'">
                                            <button class="pt-btn" @click.prevent="openPopup('show_booking_edit', booking)">
                                                Details
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_feedback'">
                                            <button class="pt-btn" @click.prevent="openPopup('show_feedback', false, booking.nurse)">
                                                comment
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'complaint'">
                                            <button class="pt-btn" @click.prevent="openPopup('complaint', false, booking.nurse)">
                                                {{ $t('complaint') }}
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_alternative'"
                                             v-if="booking.have_alternative === 'yes'">
                                            <button class="pt-btn"
                                                    @click.prevent="openPopup('show_alternative', booking)">
                                                {{ $t('show_alternative') }}
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_chat'">
                                            <button class="pt-btn" @click.prevent="openPopup('show_chat', false, booking.nurse)">
                                                {{ $t('send_message') }}
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_remove_confirm'">
                                            <button class="pt-btn" @click.prevent="openPopup('show_remove_confirm', booking)">
                                                {{ $t('remove') }}
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_booking'">
                                            <button class="pt-btn" @click.prevent="openPopup('show_booking', booking)">
                                                {{ $t('show') }}
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group" v-show="item === 'show_pay_payment'">
                                            <button class="pt-btn" @click.prevent="openPopup('show_pay_payment', booking)">
                                                {{ $t('pay') }}
                                            </button>
                                        </div>
                                        <div class="pt-table--ctrl-group"
                                             v-if="booking.nurse_is_refuse_booking === 'yes'"
                                             v-show="item === 'show_refused_booking'">
                                            <button class="btn btn-sm btn-danger" @click.prevent="openPopup('show_refused_booking', booking)">
                                                {{ $t('nurse_refuse_booking') }}
                                            </button>&nbsp;
                                        </div>
                                    </template>
                                </template>
                            </pt-menu>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="" v-else>
                No bookings
            </h2>

            <div class="pt-pagination" v-if="bookings.length > 0">
                <a href="" class="pt-pagination--link"
                   v-for="(link, index) in pagination"
                   @click.prevent="getBookings(link)"
                   :class="{active: link.active}"
                >
                    <i class="fa-solid fa-angle-left" v-if="index === 0"></i>
                    <i class="fa-solid fa-angle-right" v-else-if="index === pagination.length-1"></i>
                    <template v-else>{{ link.label }}</template>
                </a>
            </div>
        </div>



<!--        show_booking_edit-->
        <Modal
            v-model="modal.show_booking_edit"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">
                    <h3 class="pt-title">
                        {{ $t('booking_from_nurse') + ': ' + booking.nurse.first_name + ' ' + booking.nurse.last_name}}
                    </h3>

                    <booking :data="data" :booking="booking"></booking>

                    <button @click.prevent="updateBooking()" class="pt-btn--primary pt-sm pt-m-a pt-mt-25">
                        {{ $t('update') }}
                    </button>
                </div>
            </div>
        </Modal>

<!--        show_feedback-->
        <Modal
            v-model="modal.show_feedback"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">


                    <feedback :nurse="nurse"></feedback>

                </div>
            </div>
        </Modal>

<!--        complaint-->
        <Modal
            v-model="modal.complaint"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">


                    <complaint :nurse="nurse"></complaint>

                </div>
            </div>
        </Modal>

<!--        show_remove_confirm-->
        <Modal
            v-model="modal.show_remove_confirm"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">
                    <div class="pt-row">
                        <div class="pt-col-md-6">
                            <button class="pt-btn--primary" v-on:click="deleteBookingConfirm()">{{ $t('remove') }}</button>
                        </div>
                        <div class="pt-col-md-6">
                            <button class="pt-btn" v-on:click="closePopup()">{{ $t('close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>

<!--        show_chat-->
        <Modal
            v-model="modal.show_chat"
            :close="closePopup"
        >
            <div class="pt-popup">
                <h3 class="pt-title">
                    Single Chat with {{ nurse.first_name + ' ' + nurse.last_name}}
                </h3>
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">

                    <single_chat :nurse="nurse" :data="data" :client="user"></single_chat>

                </div>
            </div>
        </Modal>

<!--        show_booking-->
        <Modal
            v-model="modal.show_booking"
            :close="closePopup"
        >
            <div class="pt-popup">
                <h3 class="pt-title">
                    {{ $t('booking_from_nurse') + ': ' + booking.nurse.first_name + ' ' + booking.nurse.last_name}}
                </h3>
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">

                    <show_booking :data="data" :booking="booking"></show_booking>

                </div>
            </div>
        </Modal>

<!--        show_alternative-->
        <Modal
            v-model="modal.show_alternative"
            :close="closePopup"
        >
            <div class="pt-popup">
                <h3 class="pt-title">
                    {{ $t('alternative_booking_from_nurse') + ': ' + booking.nurse.first_name + ' ' + booking.nurse.last_name}}
                </h3>
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">

                    <alternative :booking="booking"></alternative>


                    <button class="pt-btn--primary" v-on:click="agreeWithAlternativeBooking()">{{ $t('agree') }}</button>&nbsp;
                </div>
            </div>
        </Modal>

<!--        show_pay_payment-->
        <Modal
            v-model="modal.show_pay_payment"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">
                    <pay_payment :payment="booking.payment"></pay_payment>
                </div>
            </div>
        </Modal>

<!--        show_refused_booking-->
        <Modal
            v-model="modal.show_refused_booking"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">
                    <h5>{{ $t('nurse') + ' ' + booking.nurse.first_name + ' ' + booking.nurse.last_name + ' ' + $t('refuse_this_booking_your_action')}}</h5>


                    <div class="row">
                        <div class="col-2 offset-3">
                            <button class="btn btn-sm btn-success" v-on:click="sendAgain(booking.id)">{{ $t('send_again') }}</button>

                        </div>
                        <div class="col-2 offset-2">
                            <button class="btn btn-sm btn-danger" @click.prevent="openPopup('show_remove_confirm', booking)">{{ $t('remove') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script>
    import Booking from "./BookingEdit";
    import Alternative from "./Alternative";
    import SingleChat from "./SingleChat";
    import ShowBooking from "./ShowBooking";
    import FeedBack from "./FeedBack";
    import PayPayment from "./PayPayment";
    import Complaint from "./Complaint";

    export default {
        name: "Bookings",
        props: ['data', 'user'],
        components: {
            booking: Booking,
            alternative: Alternative,
            single_chat: SingleChat,
            show_booking: ShowBooking,
            feedback: FeedBack,
            pay_payment: PayPayment,
            complaint: Complaint,
        },
        data() {
            return {
                modal: {
                    show_booking_edit: false,
                    show_booking: false,
                    show_feedback: false,
                    show_alternative: false,
                    complaint: false,
                    show_remove_confirm: false,
                    show_chat: false,
                    show_pay_payment: false,
                    show_refused_booking: false,
                },
                search: '',
                activeTab: '',
                show_modal: false,
                pagination: false,
                booking: null,
                bookings: [],
                not_approved_bookings: [],
                approved_bookings: [],
                in_process_bookings: [],
                ended_bookings: [],
                nurse: null,
                ctrl: {
                    not_approved: [
                        'show_booking_edit',
                        'show_feedback',
                        'complaint',
                        'show_alternative',
                        'show_chat',
                        'show_remove_confirm',
                        'show_refused_booking',
                    ],
                    approved: [
                        'show_booking',
                        'show_chat',
                        'show_pay_payment',
                        'show_feedback',
                        'complaint',
                    ],
                    in_process: [
                        'show_booking_edit',
                        'show_remove_confirm',
                        'show_booking',
                        'show_chat',
                        'show_feedback',
                        'complaint',
                    ],
                    ended: [
                        'show_booking_edit',
                        'show_remove_confirm',
                        'show_booking',
                        'show_chat',
                        'show_feedback',
                        'complaint',
                    ],
                }
            }
        },
        mounted() {
            this.getBookings();

            this.emitter.on('pt-search', (e) => {
                this.search = e
                this.getBookings()
            })

            this.emitter.on('close-modal', (e) => {
                this.closePopup();
            });

            this.emitter.on('pay-payment', (e) => {
                this.closePopup();
                this.getBookings();
            });
        },
        methods: {
            closePopup() {
                let self = this;

                _.forEach(self.modal, function (item, key) {
                    self.modal[key] = false;
                });
            },
            openPopup(id, booking, nurse){
                this.modal[id] = true
                this.booking = booking;
                this.nurse = nurse;
            },
            activateTab(n) {
                this.activeTab = n
                this.search = ''
                this.getBookings()
            },
            getBookings(link) {
                let page = 1
                if(link){
                    let linkUrl = new URL(link.url);
                    page = linkUrl.searchParams.get('page')
                }

                let url = '/dashboard/client-bookings?client_id=' + this.user.id
                    + '&page='+ page
                    + '&status=' + this.activeTab
                    + '&search=' + this.search
                axios.get(url)
                    .then((response) => {
                        if (response.data.success) {
                            this.bookings = response.data.booking.data;
                            this.pagination = response.data.booking.meta.links;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            agreeWithAlternativeBooking() {
                axios.get('/dashboard/client-bookings/agree-with-alternative/' + this.booking.id)
                    .then((response) => {
                        if (response.data.success) {
                            this.closePopup();
                            this.getBookings();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            updateBooking() {
                axios.put('/dashboard/client-bookings/' + this.booking.id, {'booking': this.booking}) //update method in ClientBookingController
                    .then((response) => {
                        if (response.data.success) {
                            this.closePopup();
                        }
                    }).catch((error) => {
                    console.log(error);
                });
            },
            sendAgain(id) {
                axios.get('/dashboard/client-bookings/send-booking-again/' + id)
                    .then((response) => {
                        this.closePopup();
                        this.getBookings();
                    }).catch((error) => {
                    console.log(error);
                });
            },
            deleteBookingConfirm() {
                axios.delete('/dashboard/client-bookings/' + this.booking.id) //destroy method in ClientBookingController
                    .then((response) => {
                        if (response.data.success) {
                            this.closePopup();
                            this.getBookings();
                        }
                    }).catch((error) => {
                    console.log(error);
                });
            }
        }
    }

</script>

<style scoped lang="scss">
.pt-messages--tabs{
    width: auto;
    display: inline-flex;

    &-btn{
        padding: 0 20px;
        white-space: nowrap;
    }
}
</style>
