import template from './template.html';
import './style.css';
import Booking from "./BookingEdit";
import Alternative from "./Alternative";
import SingleChat from "./SingleChat";
import ShowBooking from "./ShowBooking";
import FeedBack from "./FeedBack";
import PayPayment from "./PayPayment";
import Complaint from "./Complaint";

export default {
    name: "Bookings",
    template: template,
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
            show_modal: false,
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

        this.emitter.on('close-modal', (e) => {
            this.closeModal();
        });

        this.emitter.on('pay-payment', (e) => {
            this.closeModal();
            this.getBookings();
        });


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
                        this.closeModal();
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
