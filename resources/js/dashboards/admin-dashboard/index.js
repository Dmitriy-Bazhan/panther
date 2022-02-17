import template from './wrapper.html';

export default {
    name: 'admin-dashboard',
    props: ['user'],
    template: template,
    mounted() {
        console.log(this.user);
    }
}
