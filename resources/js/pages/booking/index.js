import template from './template.html';
import OneTimeBooking from "./OneTimeBooking";
import RegularBooking from "./RegularBooking";

export default {
    name: 'Booking',
    props: ['data'],
    template : template,
    components : {
        'one_time_booking' : OneTimeBooking,
        'regular_booking' : RegularBooking,
    },
    data() {
        return {
            startBooking: true,
            showOneTimeBookingContainer : false,
            showRegularBookingContainer : false,
        }
    },
    mounted () {
        this.showOneTimeBooking();
    },
    methods: {
        showOneTimeBooking(){
            this.startBooking = false;
            this.showOneTimeBookingContainer = true;
            this.showRegularBookingContainer = false;
        },
        showRegularBooking() {
            this.startBooking = false;
            this.showRegularBookingContainer = true;
            this.showOneTimeBookingContainer = false;
        }
    }
}
