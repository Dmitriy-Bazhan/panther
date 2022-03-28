import template from './template.html';

export default {
    name: "Bookings",
    template: template,
    props: ['data', 'user'],
    components: {

    },
    data() {
        return {
            bookings: [],
        }
    },
    mounted() {
        this.getNursesBookings();
    },
    methods: {
        getNursesBookings() {
            axios.get('/dashboard/nurse-bookings?nurse_id=' + this.user.id)
                .then((response) => {
                    if(response.data.success){
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
