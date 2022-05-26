import template from './template.html';
import SendMessage from "./SendMessage";
import './style.css';

export default {
    name: 'Complaint',
    template: template,
    props: ['user', 'data'],
    components: {
        send_message: SendMessage,
    },
    data() {
        return {
            complaints: false,
            links: false,
            url: '/dashboard/admin/get-complaints',
            temp_user: false,
            show_modal: false,
        }
    },
    mounted() {
        this.getComplaints();

        this.emitter.on('close-modal', (e) => {
            this.closeModal();
        });
    },
    methods: {
        getComplaints() {
            axios.get(this.url)
                .then((response) => {
                    if (response.data.success) {
                        this.complaints = response.data.complaints.data;
                        this.links = response.data.complaints.links;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        changeStatus(complaint) {
            axios.get('/dashboard/admin/change-status-complaint/' + complaint.id)
                .then((response) => {
                    if (response.data.success) {
                        complaint.status = response.data.status;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        goToPage(url) {
            if (url !== null) {
                this.url = url;
                this.getComplaints();
            }
        },
        closeModal() {
            this.show_modal = false;
            this.temp_user = false;
        },
        writeMessageToUser(user) {
            this.temp_user = user;
            this.show_modal = 'send_message';
        },

        banClient(client) {
            axios.get('ban-user/' + client.id)
                .then((response) => {
                    if (response.data.success) {
                        client.banned = 'yes';
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        dismissBanClient(client) {
            axios.get('dismiss-ban-user/' + client.id)
                .then((response) => {
                    if (response.data.success) {
                        client.banned = 'no';
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        banNurse(nurse) {
            axios.get('ban-user/' + nurse.id)
                .then((response) => {
                    if (response.data.success) {
                        nurse.banned = 'yes';
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        dismissBanNurse(nurse) {
            axios.get('dismiss-ban-user/' + nurse.id)
                .then((response) => {
                    if (response.data.success) {
                        nurse.banned = 'no';
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
}
