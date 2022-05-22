import template from './template.html';
import './style.css';

export default {
    name: 'Complaint',
    template: template,
    props: ['user', 'data'],
    mounted() {
        this.getComplaints();
    },
    methods: {
        getComplaints() {
            axios.get('get-complaints')
                .then((response) => {
                    if (response.data.success) {
                        console.log(response.data.complaints);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
