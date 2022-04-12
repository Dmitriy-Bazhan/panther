import template from './template.html';
import './style.css';
import Booking from "./BookingEdit";
import Alternative from "./Alternative";
import SingleChat from "./SingleChat";
import ShowBooking from "./ShowBooking";

export default {
    name: "Bookings",
    template: template,
    props: ['data', 'user'],
    components: {
        booking: Booking,
        alternative: Alternative,
        single_chat: SingleChat,
        show_booking: ShowBooking,
    },
    data() {
        return {
            show_remove_confirm: false,
            show_booking_edit: false,
            show_booking: false,
            show_refused_booking: false,
            show_alternative: false,
            show_chat: false,
            booking: null,
            not_approved_bookings: [],
            approved_bookings: [],
            in_process_bookings: [],
            ended_bookings: [],
            nurse: null,
        }
    },
    mounted() {
        this.getBookings();
    },
    methods: {
        getBookings() {
            axios.get('/dashboard/client-bookings?client_id=' + this.user.id)
                .then((response) => {
                    if (response.data.success) {
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
            axios.get('/dashboard/client-bookings/agree-with-alternative/' + this.booking.id)
                .then((response) => {
                    if (response.data.success) {
                        this.closeModal();
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
                        this.closeModal();
                    }
                }).catch((error) => {
                console.log(error);
            });
        },
        closeModal() {
            this.show_chat = false;
            this.show_booking_edit = false;
            this.show_booking = false;
            this.show_alternative = false;
            this.show_refused_booking = false;
            this.show_remove_confirm = false;
            this.booking = null;
            this.nurse = null;
        },
        showBookingEdit(booking) {
            this.show_booking_edit = true;
            this.show_alternative = false;
            this.show_refused_booking = false;
            this.show_booking = false;
            this.show_chat = false;
            this.booking = booking;
        },
        showBooking(booking) {
            this.show_booking = true;
            this.show_booking_edit = false;
            this.show_alternative = false;
            this.show_refused_booking = false;
            this.show_chat = false;
            this.booking = booking;

            },
        showCurrentAlternativeBooking(booking) {
            this.show_alternative = true;
            this.show_booking_edit = false;
            this.show_booking = false;
            this.show_refused_booking = false;
            this.show_chat = false;
            this.booking = booking;
        },
        showChatWithNurse(nurse) {
            this.nurse = nurse;
            this.show_chat = true;
            this.show_booking_edit = false;
            this.show_booking = false;
            this.show_refused_booking = false;
            this.show_alternative = false;
        },
        showRefusedBooking(booking) {
            this.show_refused_booking = true;
            this.show_chat = false;
            this.show_booking_edit = false;
            this.show_booking = false;
            this.show_alternative = false;
            this.booking = booking;
        },
        deleteBooking(booking) {
            this.booking = booking;
            this.show_remove_confirm = true;
        },
        sendAgain(id) {
            axios.get('/dashboard/client-bookings/send-booking-again/' + id)
                .then((response) => {
                    this.closeModal();
                    this.getBookings();
                }).catch((error) => {
                console.log(error);
            });
        },
        deleteBookingConfirm() {
            axios.delete('/dashboard/client-bookings/' + this.booking.id) //destroy method in ClientBookingController
                .then((response) => {
                    if (response.data.success) {
                        this.closeModal();
                        this.getBookings();
                    }
                }).catch((error) => {
                console.log(error);
            });
        }
    }
}
