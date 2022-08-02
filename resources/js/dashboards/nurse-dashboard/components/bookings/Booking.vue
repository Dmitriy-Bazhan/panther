<template>
    <div>
        <div class="pt-table--head">
            <div class="pt-messages--tabs">
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === ''}"
                        @click.prevent="activateTab('')">
                    <!--                {{ $t('all') }}-->
                    All
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'not_approved'}"
                        @click.prevent="activateTab('not_approved')">
                    <!--                {{ $t('not_approved_bookings') }}-->
                    Not approved
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'approved'}"
                        @click.prevent="activateTab('approved')">
                    <!--                {{ $t('approved_bookings') }}-->
                    Approved
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'in_process'}"
                        @click.prevent="activateTab('in_process')">
                    <!--                {{ $t('in_process_bookings') }}-->
                    In process
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'ended'}"
                        @click.prevent="activateTab('ended')">
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
                <div class="pt-table--row"
                     v-for="(booking, index) in bookings">
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            <div class="pt-table--number">
                                {{ index + 1 }}
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
                                    <div class="pt-table--ctrl-group" v-show="item === 'show_booking'">
                                        <button class="pt-btn" @click.prevent="openPopup('show_booking', booking)">
                                            {{ $t('show') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group"
                                         v-show="item === 'show_alternative'"
                                         v-if="booking.have_alternative === 'no'">
                                        <button class="pt-btn" @click.prevent="openPopup('show_alternative', booking)">
                                            {{ $t('alternative') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group" v-show="item === 'show_chat'">
                                        <button class="pt-btn"
                                                @click.prevent="openPopup('show_chat', false, booking.client)">
                                            {{ $t('send_message') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group" v-show="item === 'show_confirm_approve'">
                                        <button class="pt-btn" @click.prevent="openPopup('show_confirm_approve', booking)">
                                            {{ $t('approve') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group" v-show="item === 'show_refuse'">
                                        <button class="pt-btn" @click.prevent="openPopup('show_refuse', booking)">
                                            {{ $t('refuse') }}
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group" v-show="item === 'complaint'">
                                        <button class="pt-btn"
                                                @click.prevent="openPopup('complaint', false, booking.client)">
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

            <div class="pt-pagination" v-if="bookings.length > 0">
                <a href="" class="pt-pagination--link"
                   v-for="(link, index) in pagination"
                   @click.prevent="getNursesBookings(link)"
                   :class="{active: link.active}"
                >
                    <i class="fa-solid fa-angle-left" v-if="index === 0"></i>
                    <i class="fa-solid fa-angle-right" v-else-if="index === pagination.length-1"></i>
                    <template v-else>{{ link.label }}</template>
                </a>
            </div>
        </div>

        <div class="" v-if="false">
            <h4>{{ $t('bookings_wait_your_approve') }} 2</h4>

            <table>
                <thead>
                <tr>
                    <th>Client</th>
                    <th>One time or regular</th>
                    <th>Start Data</th>
                    <th>Create Date</th>
                    <th>Is set alternative</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="not_approved_bookings.length > 0" v-for="booking in not_approved_bookings">
                    <th>{{ booking.client.first_name + ' ' + booking.client.last_name }}</th>
                    <th>{{ $t(booking.one_time_or_regular) }}</th>
                    <th>{{ booking.start_date }}</th>
                    <th>{{ booking.created_at.split('T')[0] }}</th>
                    <th v-if="booking.agree_for_alternative === 'yes'">{{
                            $t('client_agree_on_your_alternative_booking')
                        }}
                    </th>
                    <th>{{ $t(booking.have_alternative) }}</th>
                    <th>
                        <button class="btn btn-sm btn-success" v-on:click="showCurrentBooking(booking)">
                            {{ $t('show') }}
                        </button>&nbsp;
                        <button v-if="booking.agree_for_alternative === 'yes'" class="btn btn-sm btn-secondary">
                            {{ $t('client-accept-alternative') }}
                        </button>&nbsp;
                        <button v-else-if="booking.have_alternative === 'no'" class="btn btn-sm btn-success"
                                v-on:click="showCurrentAlternativeBooking(booking)">
                            {{ $t('alternative') }}
                        </button>&nbsp;
                        <button v-else class="btn btn-sm btn-secondary">{{ $t('you-sent-alternative') }}</button>
                        &nbsp
                        <button class="btn btn-sm btn-success" v-on:click="showChatWithClient(booking.client)">
                            {{ $t('send_message') }}
                        </button>&nbsp;
                        <button class="btn btn-sm btn-success" v-on:click="showApproveBookingConfirm(booking)">{{
                                $t('approve')
                            }}
                        </button>&nbsp;
                        <button class="btn btn-sm btn-success" v-on:click="showRefuseBooking(booking)">{{
                                $t('refuse')
                            }}
                        </button>&nbsp;
                        <button class="btn btn-sm btn-danger" v-on:click="showComplaint(booking.client)">
                            {{ $t('complaint') }}
                        </button>
                    </th>
                </tr>
                </tbody>
            </table>

            <h4>{{ $t('bookings_approved_wait_payments') }}</h4>

            <table>
                <thead>
                <tr>
                    <th>Client</th>
                    <th>One time or regular</th>
                    <th>Start Data</th>
                    <th>Create Date</th>
                    <th>Is set alternative</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="approved_bookings.length > 0" v-for="booking in approved_bookings">
                    <th>{{ booking.client.first_name + ' ' + booking.client.last_name }}</th>
                    <th>{{ $t(booking.one_time_or_regular) }}</th>
                    <th>{{ booking.start_date }}</th>
                    <th>{{ booking.created_at.split('T')[0] }}</th>
                    <th v-if="booking.agree_for_alternative === 'yes'">{{
                            $t('client_agree_on_your_alternative_booking')
                        }}
                    </th>
                    <th>{{ $t(booking.have_alternative) }}</th>
                    <th>
                        <button class="btn btn-sm btn-success" v-on:click="showCurrentBooking(booking)">
                            {{ $t('show') }}
                        </button>&nbsp;
                        <button class="btn btn-sm btn-success" v-on:click="showChatWithClient(booking.client)">
                            {{ $t('send_message') }}
                        </button>&nbsp;
                        <button class="btn btn-sm btn-success" v-on:click="showRefuseBooking(booking)">{{
                                $t('refuse')
                            }}
                        </button>&nbsp;
                        <button class="btn btn-sm btn-danger" v-on:click="showComplaint(booking.client)">
                            {{ $t('complaint') }}
                        </button>
                    </th>
                </tr>
                </tbody>
            </table>

            <h4>{{ $t('booking_in_process') }}</h4>

            <table>
                <thead>
                <tr>
                    <th>Client</th>
                    <th>One time or regular</th>
                    <th>Start Data</th>
                    <th>Create Date</th>
                    <th>Is set alternative</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="in_process_bookings.length > 0" v-for="booking in in_process_bookings">
                    <th>{{ booking.client.first_name + ' ' + booking.client.last_name }}</th>
                    <th>{{ $t(booking.one_time_or_regular) }}</th>
                    <th>{{ booking.start_date }}</th>
                    <th>{{ booking.created_at.split('T')[0] }}</th>
                    <th v-if="booking.agree_for_alternative === 'yes'">{{
                            $t('client_agree_on_your_alternative_booking')
                        }}
                    </th>
                    <th>{{ $t(booking.have_alternative) }}</th>
                    <th>
                        <button class="btn btn-sm btn-success" v-on:click="showCurrentBooking(booking)">
                            {{ $t('show') }}
                        </button>&nbsp;
                        <button class="btn btn-sm btn-success" v-on:click="showChatWithClient(booking.client)">
                            {{ $t('send_message') }}
                        </button>&nbsp;
                        <button class="btn btn-sm btn-danger" v-on:click="showComplaint(booking.client)">
                            {{ $t('complaint') }}
                        </button>
                    </th>
                </tr>
                </tbody>
            </table>

            <h4>{{ $t('booking_is_ended') }}</h4>

            <table>
                <thead>
                <tr>
                    <th>Client</th>
                    <th>One time or regular</th>
                    <th>Start Data</th>
                    <th>Create Date</th>
                    <th>Is set alternative</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="ended_bookings.length > 0" v-for="booking in ended_bookings">
                    <th>{{ booking.client.first_name + ' ' + booking.client.last_name }}</th>
                    <th>{{ $t(booking.one_time_or_regular) }}</th>
                    <th>{{ booking.start_date }}</th>
                    <th>{{ booking.created_at.split('T')[0] }}</th>
                    <th v-if="booking.agree_for_alternative === 'yes'">{{
                            $t('client_agree_on_your_alternative_booking')
                        }}
                    </th>
                    <th>{{ $t(booking.have_alternative) }}</th>
                    <th>
                        <button class="btn btn-sm btn-success" v-on:click="showCurrentBooking(booking)">
                            {{ $t('show') }} 1
                        </button>&nbsp;
                        <button class="btn btn-sm btn-success" v-on:click="showChatWithClient(booking.client)">
                            {{ $t('send_message') }}
                        </button>&nbsp;
                        <button class="btn btn-sm btn-danger" v-on:click="showComplaint(booking.client)">
                            {{ $t('complaint') }}
                        </button>
                    </th>
                </tr>
                </tbody>
            </table>
        </div>

        <!--        show_booking-->
        <Modal
            v-model="modal.show_booking"
            :close="closePopup"
        >
            <div class="pt-popup">
                <h3 class="pt-title">
                    {{ $t('booking_from_nurse') + ': ' + booking.client.first_name + ' ' + booking.client.last_name }}
                </h3>
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">

                    <booking :data="data" :booking="booking"></booking>

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
                    Single Chat with {{ client.first_name + ' ' + client.last_name }}
                </h3>
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">

                    <single_chat :nurse="user" :data="data" :client="client"></single_chat>

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
                    <complaint :client="client"></complaint>
                </div>
            </div>
        </Modal>

        <!--        show_refuse-->
        <Modal
            v-model="modal.show_refuse"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">
                    <div class="pt-finder--form-group">
                        <p class="pt-form--label">
                            {{ $t('your_reason_to_refuse') }}
                        </p>
                        <div class="pt-select">
                            <div class="pt-select--icon">
                                <pt-icon type="users"></pt-icon>
                            </div>
                            <v-select label="title"
                                      :options="[
                                          $t('distance'),
                                          $t('time'),
                                          $t('a'),
                                          $t('b'),
                                          $t('c'),
                                          $t('other'),
                                          ]"
                                      v-model="booking.reason_of_refuse_booking"
                            >

                                <template #open-indicator>
                                    <span class="pt-select--caret"></span>
                                </template>
                            </v-select>
                        </div>
                    </div>
                    <div class="pt-finder--form-group">
                        <p class="pt-form--label">
                            {{ $t('if_you_refuse_booking_he_remove_from_listing') }}
                        </p>
                    </div>


                    <div class="pt-row">
                        <div class="pt-col-md-6">
                            <button class="pt-btn--primary" v-on:click="refuseBooking(booking.id)">{{
                                    $t('refuse')
                                }}
                            </button>
                        </div>
                        <div class="pt-col-md-6">
                            <button class="pt-btn" v-on:click="closePopup()">{{ $t('close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>

        <!--        show_confirm_approve-->
        <Modal
            v-model="modal.show_confirm_approve"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">
                    <h2 class="pt-title pt-mb-15">
                        {{ $t('approve_booking_with') + ' ' + booking.client.first_name + ' ' + booking.client.last_name }}
                    </h2>
                    <div class="pt-row">
                        <div class="pt-col-md-6">
                            <button class="pt-btn--primary" v-on:click="confirmApproveBooking()">{{
                                    $t('approve')
                                }}
                            </button>
                        </div>
                        <div class="pt-col-md-6">
                            <button class="pt-btn" v-on:click="closePopup()">{{ $t('close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>

        <!--        show_alternative-->
        <Modal
            v-model="modal.show_alternative"
            :close="closePopup"
        >
            <div class="pt-popup">
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">
                    <h3 class="pt-title">
                        Booking from {{ booking.client.full_name }}
                    </h3>

                    <alternative :data="data" :booking_id="booking.id" :nurse="user"></alternative>
                </div>
            </div>
        </Modal>
    </div>

</template>

<script>
import SingleChat from "./SingleChat";
import ShowBooking from "./ShowBooking";
import Alternative from "./Alternative";
import Complaint from "./Complaint";

export default {
    name: "Bookings",
    props: ['data', 'user'],
    components: {
        single_chat: SingleChat,
        booking: ShowBooking,
        alternative: Alternative,
        complaint: Complaint,
    },
    data() {
        return {
            modal: {
                show_confirm_approve: false,
                show_booking: false,
                show_feedback: false,
                show_alternative: false,
                complaint: false,
                show_refuse: false,
                show_chat: false,
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
            client: null,
            ctrl: {
                not_approved: [
                    'show_booking',
                    'show_alternative',
                    'show_chat',
                    'show_confirm_approve',
                    'show_refuse',
                    'complaint',
                ],
                approved: [
                    'show_booking',
                    'show_chat',
                    'show_refuse',
                    'complaint',
                ],
                in_process: [
                    'show_booking',
                    'show_chat',
                    'complaint',
                ],
                ended: [
                    'show_booking',
                    'show_chat',
                    'complaint',
                ],
            }
        }
    },
    mounted() {
        this.getNursesBookings();

        this.emitter.on('pt-search', (e) => {
            this.search = e
            this.getNursesBookings()
        })

        this.emitter.on('close-alternative-booking-modal', (e) => {
            this.show_alternative = false;
            this.getNursesBookings();
        });

        this.emitter.on('close-modal', (e) => {
            this.closePopup();
        });
    },
    methods: {
        closePopup() {
            let self = this;

            _.forEach(self.modal, function (item, key) {
                self.modal[key] = false;
            });
        },
        openPopup(id, booking, client) {
            this.modal[id] = true
            this.booking = booking;
            this.client = client;
        },
        activateTab(n) {
            this.activeTab = n
            this.search = ''
            this.getNursesBookings()
        },

        confirmApproveBooking() {
            this.approveBooking();
        },
        approveBooking() {
            axios.put('/dashboard/nurse-bookings/' + this.booking.id) //update method in NurseBookingController
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.closePopup();
                        this.getNursesBookings();
                    }
                }).catch((error) => {
                console.log(error)
            });
        },
        refuseBooking(booking) {
            axios.post('/dashboard/nurse-bookings/nurse-refuse-booking', {'booking': this.booking})
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.show_refuse = false;
                        this.getNursesBookings();
                        this.closePopup()
                    }
                }).catch((error) => {
                console.log(error)
            });
        },
        getNursesBookings(link) {
            let page = 1
            if(link){
                let linkUrl = new URL(link.url);
                page = linkUrl.searchParams.get('page')
            }
            let url = '/dashboard/nurse-bookings?nurse_id=' + this.user.id
                + '&page='+ page
                + '&status=' + this.activeTab
                + '&search=' + this.search
            axios.get(url)
                .then((response) => {
                    if (response.data.success) {
                        console.log(response.data)
                        this.bookings = response.data.booking.data;
                        this.pagination = response.data.booking.meta.links;
                        // this.not_approved_bookings = response.data.notApprovedBookings.data;
                        // this.approved_bookings = response.data.approvedBookings.data;
                        // this.in_process_bookings = response.data.inProcessBookings.data;
                        // this.ended_bookings = response.data.endedBookings.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
}

</script>

<style scoped lang="scss">
.pt-messages--tabs {
    width: auto;
    display: inline-flex;

    &-btn {
        padding: 0 20px;
        white-space: nowrap;
    }
}
</style>
