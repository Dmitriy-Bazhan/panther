import template from "./template.html";
import './style.css';

export default {
    name: "NursesCard",
    template : template,
    props : ['nurse'],
    data() {
        return {
            path: location.origin,
        }
    },
    mounted() {

    },
    methods: {
        closeNurseCard(){
            this.emitter.emit('close-nurse-card');
        }
    }
}
