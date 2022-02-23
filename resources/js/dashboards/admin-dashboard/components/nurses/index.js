import template from './template.html';
import './style.css';
import NursesCard from '../nurses-card/index'

export default {
    name: "Nurses",
    template : template,
    components: {
        'nurses-card' : NursesCard,
    },
    data() {
        return {
            path: location.origin,
            nurses: [],
            nurse: null,
            nurseCardIsVisible : false,
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
        getNurses(){
            axios.get('get-nurses')
                .then((response) => {
                    // console.log(response.data);
                    this.nurses = response.data.nurses.data;
                })
                .catch((error)=>{
                    console.log(error);
                });
        },
        checkUser(nurse){
            this.nurse = nurse;
            this.nurseCardIsVisible = true;
        }
    }
}
