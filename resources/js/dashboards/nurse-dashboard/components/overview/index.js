import template from './template.html';
import './style.css'

export default {
    name: "Overview",
    template: template,
    props: ['user','data'],
    mounted(){
        console.log(this.data['last_unread_messages']);
        console.log(this.data);
    },
    methods: {
        formatDate(date) {
            let a = String(date).split('T');
            return a[0] + ' ' + String(a[1].split('.')[0]);
        },
    }
}
