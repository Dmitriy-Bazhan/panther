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
            bookings: [],
            show_chat: false,
            client: null,
            show_booking: false,
            show_alternative: false,
            booking: null,
        }
    },
    mounted() {
        this.getNursesBookings();

        this.emitter.on('close-alternative-booking-modal', (e) => {
            this.show_alternative = false;
        });
    },
    methods: {
        closeModal() {
            this.show_alternative = false;
            this.show_chat = false;
            this.show_booking = false;
            this.booking = null;
            this.client = null;
        },
        showCurrentBooking(booking) {
            this.show_booking = true;
            this.show_alternative = false;
            this.show_chat = false;
            this.booking = booking;
        },
        showCurrentAlternativeBooking(booking) {
            this.show_alternative = true;
            this.show_booking = false;
            this.show_chat = false;
            this.booking = booking;
        },
        showChatWithClient(client) {
            this.client = client;
            this.show_chat = true;
            this.show_booking = false;
            this.show_alternative = false;
        },
        approveBooking(id) {
            axios.put('/dashboard/nurse-bookings/' + id) //update method
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.show_booking = false;
                    }
                }).catch((error) => {
                console.log(error)
            });
        },
        refuseBooking(id) {
            axios.delete('/dashboard/nurse-bookings/' + id) //destroy method
                .then((response) => {
                    if (response.data.success) {
                        this.emitter.emit('response-success-true');
                        this.show_booking = false;
                        alert('refuse');
                    }
                }).catch((error) => {
                console.log(error)
            });
        },

        getNursesBookings() {
            axios.get('/dashboard/nurse-bookings?nurse_id=' + this.user.id)
                .then((response) => {
                    if (response.data.success) {
                        this.bookings = response.data.bookings;
                        console.log(this.bookings[0]);
                    }

                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
}
