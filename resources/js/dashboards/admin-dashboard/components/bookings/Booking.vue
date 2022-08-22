<template>
    <div>
        <div class="pt-table--head">
            <div class="pt-messages--tabs">
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === ''}"
                        @click.prevent="activateTab('')">
                    {{ $t('all') }}
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'not_approved'}"
                        @click.prevent="activateTab('not_approved')">
                    {{ $t('not_approved_bookings') }}
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'approved'}"
                        @click.prevent="activateTab('approved')">
                    {{ $t('approved_bookings') }}
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'in_process'}"
                        @click.prevent="activateTab('in_process')">
                    {{ $t('in_process_bookings') }}
                </button>
                <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'ended'}"
                        @click.prevent="activateTab('ended')">
                    {{ $t('ended_bookings') }}
                </button>
            </div>

            <pt-search class="pt-ml-a"></pt-search>
        </div>

        <div class="pt-table--container">
            <div class="pt-table" v-if="bookings.length > 0">
                <div class="pt-table--heading">
                    <div class="pt-table--col">
                        <div class="pt-table--text">
                            {{ $t('participants') }}
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
                                {{ index + 1 }}
                            </div>
                            <div>
                                {{ $t('nurse') + ': ' }}
                                <span>{{ booking.nurse.full_name }}</span>
                            </div>
                            <div style="float: left;">
                                {{ $t('client') + ': ' }}
                                <span>{{ booking.client.full_name }}</span>
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
                                    <div class="pt-table--ctrl-group" v-show="item === 'show_booking_edit'">
                                        <button class="pt-btn"
                                                @click.prevent="openPopup('show_booking_edit', booking)">
                                            Details
                                        </button>
                                    </div>
                                    <div class="pt-table--ctrl-group" v-show="item === 'show_remove_confirm'">
                                        <button class="pt-btn"
                                                @click.prevent="openPopup('show_remove_confirm', booking)">
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
                        {{ $t('nurse') + ': ' + booking.nurse.first_name + ' ' + booking.nurse.last_name }}
                    </h3>
                    <h3 class="pt-title">
                        {{ $t('client') + ': ' + booking.client.first_name + ' ' + booking.client.last_name }}
                    </h3>

                    <edit_booking :data="data" :booking="booking"></edit_booking>

                    <button @click.prevent="updateBooking()" class="pt-btn--primary pt-sm pt-m-a pt-mt-25">
                        {{ $t('update') }}
                    </button>
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
                            <button class="pt-btn--primary" v-on:click="deleteBookingConfirm()">{{
                                $t('remove')
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

        <!--        show_booking-->
        <Modal
            v-model="modal.show_booking"
            :close="closePopup"
        >
            <div class="pt-popup">
                <h3 class="pt-title">
                    {{ $t('booking_from_nurse') + ': ' + booking.nurse.first_name + ' ' + booking.nurse.last_name }}
                </h3>
                <button class="pt-popup--close" @click.prevent="closePopup">
                    <pt-icon type="cross"></pt-icon>
                </button>
                <div class="pt-popup--inner">

                    <show_booking :data="data" :booking="booking"></show_booking>

                </div>
            </div>
        </Modal>

    </div>
</template>

<script>
import ShowBooking from "./ShowBooking";
import BookingEdit from "./BookingEdit";

export default {
    name: "Booking",
    props: ['data', 'user'],
    components: {
        show_booking: ShowBooking,
        edit_booking: BookingEdit,
    },
    data() {
        return {
            modal: {
                show_booking_edit: false,
                show_booking: false,
                show_remove_confirm: false,
            },
            search: '',
            activeTab: '',
            show_modal: false,
            pagination: false,
            booking: null,
            bookings: [],
            nurse: null,
            client: null,
            ctrl: {
                not_approved: [
                    'show_booking',
                    'show_booking_edit',
                    'show_remove_confirm',
                ],
                approved: [
                    'show_booking',
                    'show_booking_edit',
                    'show_remove_confirm',
                ],
                in_process: [
                    'show_booking',
                    'show_booking_edit',
                    'show_remove_confirm',
                ],
                ended: [
                    'show_booking',
                    'show_booking_edit',
                    'show_remove_confirm',
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

    },
    methods: {
        closePopup() {
            let self = this;

            _.forEach(self.modal, function (item, key) {
                self.modal[key] = false;
            });
        },
        openPopup(id, booking) {
            this.modal[id] = true
            this.booking = booking;
            this.nurse = booking.nurse;
            this.client = booking.client;
        },
        activateTab(n) {
            this.activeTab = n
            this.search = ''
            this.getBookings()
        },
        getBookings(link) {
            let page = 1
            if (link) {
                let linkUrl = new URL(link.url);
                page = linkUrl.searchParams.get('page')
            }
            //AdminBookingsController@index
            let url = '/dashboard/admin/get-bookings'
                + '?page=' + page
                + '&status=' + this.activeTab
                + '&search=' + this.search;

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
        updateBooking() {
            //AdminBookingsController@update
            axios.put('/dashboard/admin/get-bookings/' + this.booking.id, {'booking': this.booking})
                .then((response) => {
                    if (response.data.success) {
                        this.closePopup();
                    }
                }).catch((error) => {
                console.log(error);
            });
        },
        deleteBookingConfirm() {
            //AdminBookingsController@destroy
            axios.delete('/dashboard/admin/get-bookings/' + this.booking.id)
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
.pt-messages--tabs {
    width: auto;
    display: inline-flex;


    &-btn {
        padding: 0 20px;
        white-space: nowrap;
    }
}
</style>
