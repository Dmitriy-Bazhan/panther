import template from './template.html';


export default {
    name: "Bookings",
    template : template,
    props: ['id'],
    mounted() {
        console.log(this.id);
    }
}
