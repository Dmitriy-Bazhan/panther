import template from './template.html';


export default {
    name: "Bookings",
    template: template,
    props: ['data', 'user'],
    data() {
        return {
            bookings: [],
        }
    },
    mounted() {
        console.log(this.data);
        console.log(this.user);
        this.getBookings();
    },
    methods: {
        getBookings() {
            axios.get('/dashboard/client-bookings?client_id=' + this.user.id)
                .then((response) => {
                    if (response.data.success) {
                        this.bookings = response.data.bookings;
                        console.log(this.bookings);
                    }

                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showCurrentBooking(booking) {

        },
        showCurrentAlternativeBooking(booking) {

        },
        showChatWithNurse(nurse) {

        },
        deleteBooking(id) {

        },
    }
}
