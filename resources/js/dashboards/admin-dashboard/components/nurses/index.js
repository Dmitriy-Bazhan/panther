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
            filterString: '',
            url: 'get-nurses',
            links: [],
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
            axios.get(this.url + this.filterString)
                .then((response) => {
                    console.log(response.data);
                    this.nurses = response.data.data;
                    this.links = response.data.meta.links;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        newPage(url){
            console.log(url);
            if (url !== null) {
                this.url = url;
                this.getNurses();
            }
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



