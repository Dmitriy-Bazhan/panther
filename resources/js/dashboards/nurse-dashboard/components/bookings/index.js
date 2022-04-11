import template from './template.html';
import SingleChat from "./SingleChat";
import Booking from "./Booking";
import Alternative from "./Alternative";
import './style.css';

export default {
    name: "Bookings",
    template: template,
    props: ['data', 'user'],
    components: {
        single_chat: SingleChat,
        booking: Booking,
        alternative: Alternative,
    },
    data() {
        return {
            not_approved_bookings: [],
            show_chat: false,
            show_refuse: false,
            client: null,
            show_booking: false,
            show_alternative: false,
            show_confirm_approve: false,
            booking: null,
        }
    },
    mounted() {
        this.getNursesBookings();

        this.emitter.on('close-alternative-booking-modal', (e) => {
            this.show_alternative = false;
            this.getNursesBookings();
        });
    },
    methods: {
        closeModal() {
            this.show_alternative = false;
            this.show_chat = false;
            this.show_booking = false;
            this.show_refuse = false;
            this.show_confirm_approve = false;
            this.booking = null;
            this.client = null;
        },
        showCurrentBooking(booking) {
            this.show_booking = true;
            this.show_alternative = false;
            this.show_confirm_approve = false;
            this.show_chat = false;
            this.show_refuse = false;
            this.booking = booking;
        },
        showCurrentAlternativeBooking(booking) {
            this.show_alternative = true;
            this.show_booking = false;
            this.show_confirm_approve = false;
            this.show_chat = false;
            this.show_refuse = false;
            this.booking = booking;
        },
        showChatWithClient(client) {
            this.client = client;
            this.show_chat = true;
            this.show_booking = false;
            this.show_alternative = false;
            this.show_refuse = false;
            this.show_confirm_approve = false;
        },
        showRefuseBooking(booking) {
            this.show_refuse = true;
            this.show_alternative = false;
            this.show_booking = false;
            this.show_chat = false;
            this.show_confirm_approve = false;
            this.booking = booking;
        },
        showApproveBookingConfirm(booking) {
            this.show_confirm_approve = true;
            this.show_refuse = false;
            this.show_alternative = false;
            this.show_booking = false;
            this.show_chat = false;
            this.booking = booking;
        },
        confirmApproveBooking(){
            this.approveBooking();
        },

        approveBooking() {
            axios.put('/dashboard/nurse-bookings/' + this.booking.id) //update method in NurseBookingController
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.closeModal();
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
                    }
                }).catch((error) => {
                console.log(error)
            });
        },

        getNursesBookings() {
            axios.get('/dashboard/nurse-bookings?nurse_id=' + this.user.id)
                .then((response) => {
                    if (response.data.success) {
                        console.log(response.data);
                        this.not_approved_bookings = response.data.notApprovedBookings;

                    }

                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
}
