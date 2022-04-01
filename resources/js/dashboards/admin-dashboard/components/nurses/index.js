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
    mounted() {
        this.getNurses();
        this.emitter.on('close-nurse-card', (e) => {
            this.nurse = null;
            this.nurseCardIsVisible = false;
        });
    },
    methods: {
        getNurses() {
            axios.get('get-nurses' + this.filterString)
                .then((response) => {
                    console.log(response.data.data[0]);
                    this.nurses = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        checkUser(nurse) {
            this.nurse = nurse;
            this.nurseCardIsVisible = true;
        },
        approveNurse(id){
            axios.post('approve-nurse', {'id': id})
                .then((response) => {
                     this.nurses.filter(function (el, index) {
                        if(el.entity.id === response.data.id){
                            el.entity.is_approved = 'yes';
                            el.entity.change_info = 'no';
                            el.entity.info_is_full = 'no';
                        }
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        dismissNurse(id){
            axios.post('dismiss-nurse', {'id': id})
                .then((response) => {
                    this.nurses.filter(function (el, index) {
                        if(el.entity.id === response.data.id){
                            el.entity.is_approved = 'no';
                        }
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
}



