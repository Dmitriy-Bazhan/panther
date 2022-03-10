import template from './template.html';
import './style.css';
import NursesCard from '../nurses-card/index'

export default {
    name: "Nurses",
    template: template,
    components: {
        'nurses-card': NursesCard,
    },
    props: ['data'],
    data() {
        return {
            path: location.origin,
            nurses: [],
            nurse: null,
            nurseCardIsVisible: false,
            filterString: '?only_full_info=yes'
        }
    },
    watch : {

    },
    mounted() {
        this.getNurses();
        this.emitter.on('close-nurse-card', (e) => {
            this.nurse = null;
            this.nurseCardIsVisible = false;
        });


    },
    created() {

    },
    methods: {
        getNurses() {
            axios.get('get-nurses' + this.filterString)
                .then((response) => {
                    console.log(response.data.data[0].entity);
                    this.nurses = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        checkUser(nurse) {
            this.nurse = nurse;
            this.nurseCardIsVisible = true;
        }
    }
}



