import template from './template.html';
import SingleChat from "./SingleChat";
import Booking from "./Booking";
import Alternative from "./Alternative";
import Complaint from "./Complaint";
import './style.css';

export default {
    name: "Bookings",
    template: template,
    props: ['data', 'user'],
    components: {
        single_chat: SingleChat,
        booking: Booking,
        alternative: Alternative,
        complaint: Complaint,
    },
    data() {
        return {
            not_approved_bookings: [],
            approved_bookings: [],
            in_process_bookings: [],
            ended_bookings: [],
            client: null,
            booking: null,
            show_modal: false,
        }
    },
    mounted() {
        this.getNursesBookings();

        this.emitter.on('close-alternative-booking-modal', (e) => {
            this.show_alternative = false;
            this.getNursesBookings();
        });

        this.emitter.on('close-modal', (e) => {
            this.closeModal();
        });
    },
    methods: {
        closeModal() {
            this.show_modal = false;
            this.booking = null;
            this.client = null;
        },
        showComplaint(client) {
            this.show_modal = 'complaint';
            this.client = client;
            this.booking = null;
        },
        showCurrentBooking(booking) {
            this.show_modal = 'show_booking';
            this.booking = booking;
            this.client = null;
        },
        showCurrentAlternativeBooking(booking) {
            this.show_modal = 'show_alternative';
            this.booking = booking;
            this.client = null;
        },
        showChatWithClient(client) {
            this.show_modal = 'show_chat';
            this.client = client;
            this.booking = null;
        },
        showRefuseBooking(booking) {
            this.show_modal = 'show_refuse';
            this.booking = booking;
            this.client = null;
        },
        showApproveBookingConfirm(booking) {
            this.show_modal = 'show_confirm_approve';
            this.booking = booking;
            this.client = null;
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
    }
}
