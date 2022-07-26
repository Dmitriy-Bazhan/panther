<template>
    <div>
        <div class="pt-table--head">
            <div class="pt-messages--tabs">
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'all'}" @click.prevent="activateTab('all')">
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

            <form action="" @submit.prevent="" class="pt-search pt-ml-a">
                <input type="text" class="pt-search--input" v-model="search" placeholder="Suchen">
                <button class="pt-search--btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <div class="pt-table--container" v-show="activeTab === 'all'">
            <div class="pt-table" v-if="all_bookings.length > 0">
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
                <div class="pt-table--row" v-for="(booking, index) in filterUsers(all_bookings)">
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
                        <div class="pt-status" :class="booking.status">
                            {{ $t(booking.status) }}
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="" v-else>
                No bookings
            </h2>
        </div>

        <div class="pt-table--container" v-show="activeTab === 'not_approved'">
            <div class="pt-table" v-if="not_approved_bookings.length > 0">
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
                <div class="pt-table--row" v-for="(booking, index) in not_approved_bookings">
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
                                <template v-if="booking.is_verification ==='no'">
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_booking_edit', booking)">
                                            Details
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_remove_confirm', booking)">
                                            {{ $t('remove') }}
                                        </button>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_booking_edit', booking)">
                                            Details
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_feedback', false, booking.nurse)">
                                            comment
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('complaint', false, booking.nurse)">
                                            {{ $t('complaint') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group" v-if="booking.have_alternative === 'yes'">
                                        <button class="pt-btn"
                                                @click.prevent="openPopup('show_alternative', booking)">
                                            {{ $t('show_alternative') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_chat', false, booking.nurse)">
                                            Chat
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_remove_confirm', booking)">
                                            {{ $t('remove') }}
                                        </button>
                                    </div>
                                </template>
                            </pt-menu>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="" v-else>
                No bookings
            </h2>
        </div>

        <div class="pt-table--container" v-show="activeTab === 'approved'">
            <div class="pt-table" v-if="approved_bookings.length > 0">
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
                <div class="pt-table--row" v-for="(booking, index) in approved_bookings">
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
                                <div class="pt-table--ctrl-group">
                                    <button class="pt-btn" @click.prevent="openPopup('show_booking', booking)">
                                        {{ $t('show') }}
                                    </button>
                                </div>
                                <div class="pt-table--ctrl-group">
                                    <button class="pt-btn" @click.prevent="showPayPayment(booking)">
                                        {{ $t('pay') }}
                                    </button>
                                </div>

                                <div class="pt-table--ctrl-group">
                                    <button class="pt-btn" @click.prevent="openPopup('show_chat', false, booking.nurse)">
                                        {{ $t('send_message') }}
                                    </button>
                                </div>

                                <div class="pt-table--ctrl-group">
                                    <button class="pt-btn" @click.prevent="openPopup('show_feedback', false, booking.nurse)">
                                        {{ $t('feedback') }}
                                    </button>
                                </div>

                                <div class="pt-table--ctrl-group">
                                    <button class="pt-btn" @click.prevent="openPopup('complaint', false, booking.nurse)">
                                        {{ $t('complaint') }}
                                    </button>
                                </div>
                            </pt-menu>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="" v-else>
                No bookings
            </h2>
        </div>

        <div class="pt-table--container" v-show="activeTab === 'in_process'">
            <div class="pt-table" v-if="in_process_bookings.length > 0">
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
                <div class="pt-table--row" v-for="(booking, index) in in_process_bookings">
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
                                <template v-if="booking.is_verification ==='no'">
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_booking_edit', booking)">
                                            {{ $t('show_and_edit') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_remove_confirm', booking)">
                                            {{ $t('remove') }}
                                        </button>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_booking', booking)">
                                            {{ $t('show') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_chat', false, booking.nurse)">
                                            {{ $t('send_message') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_feedback', false, booking.nurse)">
                                            {{ $t('feedback') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('complaint', false, booking.nurse)">
                                            {{ $t('complaint') }}
                                        </button>
                                    </div>
                                </template>
                            </pt-menu>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="" v-else>
                No bookings
            </h2>
        </div>

        <div class="pt-table--container" v-show="activeTab === 'ended'">
            <div class="pt-table" v-if="ended_bookings.length > 0">
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
                <div class="pt-table--row" v-for="(booking, index) in ended_bookings">
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
                                <template v-if="booking.is_verification ==='no'">
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn"
                                                @click.prevent="openPopup('show_booking_edit', booking)">
                                            {{ $t('show_and_edit') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group">
                                        <button class="pt-btn" @click.prevent="openPopup('show_remove_confirm', booking)">
                                            {{ $t('remove') }}
                                        </button>
                                    </div>
                                </template>

                                <div class="pt-table--ctrl-group">
                                    <button class="pt-btn" @click.prevent="openPopup('show_booking', booking)">
                                        {{ $t('show') }}
                                    </button>
                                </div>

                                <div class="pt-table--ctrl-group">
                                    <button class="pt-btn" @click.prevent="openPopup('show_chat', false, booking.nurse)">
                                        {{ $t('send_message') }}
                                    </button>
                                </div>

                                <div class="pt-table--ctrl-group">
                                    <button class="pt-btn" @click.prevent="openPopup('show_feedback', false, booking.nurse)">
                                        {{ $t('feedback') }}
                                    </button>
                                </div>

                                <div class="pt-table--ctrl-group">
                                    <button class="pt-btn" @click.prevent="openPopup('complaint', false, booking.nurse)">
                                        {{ $t('complaint') }}
                                    </button>
                                </div>
                            </pt-menu>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="" v-else>
                No bookings
            </h2>
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


        <div v-if="show_modal === 'show_refused_booking'" class="client-refuse-booking-wrapper">

            <div class="row">
                <div class="col-2 offset-10">
                    <button class="btn btn-sm btn-success" v-on:click="closeModal()">{{ $t('close') }}</button>
                </div>

            </div>
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

        <div v-if="show_modal === 'show_pay_payment'" class="pay-payment-wrapper">
            <div class="row">
                <pay_payment :payment="booking.payment"></pay_payment>
            </div>
        </div>
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
                    test: false,
                    show_booking_edit: false,
                    show_booking: false,
                    show_feedback: false,
                    show_alternative: false,
                    complaint: false,
                    show_remove_confirm: false,
                    show_chat: false,
                },
                search: '',
                activeTab: 'all',
                show_modal: false,
                booking: null,
                all_bookings: [],
                not_approved_bookings: [],
                approved_bookings: [],
                in_process_bookings: [],
                ended_bookings: [],
                nurse: null,
            }
        },
        mounted() {
            this.getBookings();

            this.emitter.on('close-modal', (e) => {
                this.closePopup();
            });

            this.emitter.on('pay-payment', (e) => {
                this.closePopup();
                this.getBookings();
            });


        },
        methods: {
            filterUsers(arr) {
                let self = this
                return _.filter(arr, function (e){
                    return e.nurse.full_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1
                })
            },
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
            },
            getBookings() {
                axios.get('/dashboard/client-bookings?client_id=' + this.user.id)
                    .then((response) => {
                        if (response.data.success) {
                            console.log(response.data)
                            this.all_bookings = [
                                ...response.data.notApprovedBookings.data,
                                ...response.data.approvedBookings.data,
                                ...response.data.inProcessBookings.data,
                                ...response.data.endedBookings.data
                            ];
                            this.not_approved_bookings = response.data.notApprovedBookings.data;
                            this.approved_bookings = response.data.approvedBookings.data;
                            this.in_process_bookings = response.data.inProcessBookings.data;
                            this.ended_bookings = response.data.endedBookings.data;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            agreeWithAlternativeBooking() {
                console.log(this.booking)
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
            closeModal() {
                this.show_modal = false;
                this.booking = null;
                this.nurse = null;
            },
            showComplaint(nurse) {
                this.show_modal = 'complaint';
                this.nurse = nurse;
                this.booking = null;
            },
            showPayPayment(booking) {
                this.show_modal = 'show_pay_payment';
                this.booking = booking;
                this.nurse = null;
            },
            showFeedback(nurse) {
                this.show_modal = 'show_feedback';
                this.booking = null;
                this.nurse = nurse;
            },
            showBookingEdit(booking) {
                this.show_modal = 'show_booking_edit';
                this.booking = booking;
            },
            showBooking(booking) {
                this.show_modal = 'show_booking';
                this.booking = booking;
            },
            showCurrentAlternativeBooking(booking) {
                this.show_modal = 'show_alternative';
                this.booking = booking;
                console.log(booking);
            },
            showChatWithNurse(nurse) {
                this.show_modal = 'show_chat';
                this.nurse = nurse;
            },
            showRefusedBooking(booking) {
                this.show_modal = 'show_refused_booking';
                this.booking = booking;
            },
            deleteBooking(booking) {
                this.show_modal = 'show_remove_confirm';
                this.booking = booking;
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
