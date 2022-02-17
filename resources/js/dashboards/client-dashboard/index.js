import template from './wrapper.html';

export default {
    name: 'dashboard',
    props: ['user'],
    template: template,
    mounted() {
        console.log(this.user);
    }
}
