import template from './template.html';
import './style.css';
import ShowChats from "./ShowChats";
import AddNewNurse from "./AddNewNurse";
import NurseInfo from "./NurseInfo";

export default {
    name: "Nurses",
    template: template,
    components: {
        show_chats: ShowChats,
        add_new_nurse: AddNewNurse,
        nurse_info: NurseInfo,
    },
    props: ['data'],
    data() {
        return {
            path: location.origin,
            nurses: [],
            nurse: null,
            nurseCardIsVisible: false,
            filterString: '',
            url: 'get-nurses?page=',
            links: [],
            show_modal: false,
            search: '',
        }
    },
    mounted() {
        this.getNurses();
        this.emitter.on('close-modal', (e) => {
            this.closeModal();
        });
    },
    methods: {
        searchNurse() {
            this.url = 'get-nurses?page=';
            this.getNurses();
        },

        closeModal() {
            this.show_modal = false;
            this.nurse = null;
        },
        showChats(nurse) {
            this.show_modal = 'show_chats';
            this.nurse = nurse;
        },
        addNewNurse() {
            this.show_modal = 'add_new_nurse';
            this.nurse = null;
        },
        checkNurse(nurse) {
            this.show_modal = 'nurse_info';
            this.nurse = nurse;
        },

        getNurses() {
            axios.get(this.url + this.filterString + '&search=' + this.search)
                .then((response) => {
                    this.nurses = response.data.nurses.data;
                    this.links = response.data.nurses.meta.links;
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



