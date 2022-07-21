import template from './template.html';
import './style.css';
import ShowChats from "./ShowChats";

export default {
    name: 'Clients',
    template: template,
    props: ['user', 'data'],
    components: {
        show_chats: ShowChats,
    },
    data() {
        return {
            path: location.origin,
            clients: [],
            links: [],
            url: 'get-clients',
            show_modal: false,
            client: false,
        }
    },
    mounted() {
        this.getClients();

        this.emitter.on('close-modal', (e) => {
            this.closeModal();
        });
    },
    methods: {
        getClients() {
            axios.get(this.url)
                .then((response) => {
                    this.clients = response.data.clients.data;
                    this.links = response.data.clients.meta.links;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        showChats(client) {
           this.show_modal = 'show_chats';
           this.client = client;
        },
        newPage(url){
            if (url !== null) {
                this.url = url;
                this.getClients();
            }
        },
        closeModal() {
            this.show_modal = false;
            this.client = false;
        },
    }
}
