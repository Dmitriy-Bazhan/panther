import template from './template.html';
import './style.css';
import NursesCard from '../nurses-card/index';
import ShowChats from "./ShowChats";
import CheckFiles from "./CheckFiles";

export default {
    name: "Nurses",
    template: template,
    components: {
        nurses_card: NursesCard,
        show_chats: ShowChats,
        check_files: CheckFiles,
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
            show_modal: false,
        }
    },
    mounted() {
        this.getNurses();
        this.emitter.on('close-modal', (e) => {
            this.closeModal();
        });
    },
    methods: {
        closeModal() {
            this.show_modal = false;
            this.nurse = null;
        },
        showChats(nurse) {
            this.show_modal = 'show_chats';
            this.nurse = nurse;
        },
        checkFiles(nurse){
            this.show_modal = 'check_files';
            this.nurse = nurse;
        },
        getNurses() {
            axios.get(this.url + this.filterString)
                .then((response) => {
                    this.nurses = response.data.data;
                    this.links = response.data.meta.links;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        newPage(url) {
            if (url !== null) {
                this.url = url;
                this.getNurses();
            }
        },
        checkUser(nurse) {
            this.show_modal = 'nurses_card';
            this.nurse = nurse;
        },
        approveNurse(id) {
            axios.post('approve-nurse', {'id': id})
                .then((response) => {
                    this.nurses.filter(function (el, index) {
                        if (el.entity.id === response.data.id) {
                            el.entity.is_approved = 'yes';
                            el.entity.change_info = 'no';
                        }
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        dismissNurse(id) {
            axios.post('dismiss-nurse', {'id': id})
                .then((response) => {
                    this.nurses.filter(function (el, index) {
                        if (el.entity.id === response.data.id) {
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



